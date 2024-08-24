<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\OffreNotification;
use App\Models\Alerte;
use App\Models\Offre;
use App\Models\Type_Offre;
use App\Models\User;
use App\Notifications\OffreCorrespondante;

class OffreController extends Controller
{
    ///LEs offres
    function storeOffre(){
        $offre = DB::table('offres')
        ->join('categories', 'offres.categ_id', 'categories.id')
        ->join('autorites', 'offres.ac_id', 'autorites.id')
        ->get(['offres.*', 'categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre']);

        return view('adminView.offre.liste',['offres'=>$offre]);

    }

    function publierOffre(){
        return view('adminView.offre.create');
    }
    function saveOffre(Request $req)
    {
        // Validation des données
        $req->validate([
            'reference' => ['required', 'string', 'max:15'],
            'titre' => ['required', 'string'],
            'depot' => ['required', 'string'],
            'categorie' => ['required', 'numeric'],
            'autorite' => ['required', 'numeric'],
            'service' => ['required'],
            'marche' => ['required', 'array'], // Valider comme un tableau
            'marche.*' => ['numeric'], // Chaque élément du tableau doit être un nombre
            'dateOuv' => ['required'],
            'heureOuv' => ['required'],
            'dateExp' => ['required'],
            'fichier' => 'required|file|mimes:pdf|max:5000000',
        ]);
    
        // Stockage du fichier
        $chemin = $req->file('fichier')->store('upload_files', 'public');
    
        // Création de l'offre
        $offre = new Offre();
        $offre->titre = $req['titre'];
        $offre->reference = $req['reference'];
        $offre->lieu_depot = $req['depot'];
        $offre->datePublication = date('Y-m-d');
        $offre->dateExpiration = $req['dateExp'];
        $offre->dateOuverture = $req['dateOuv'];
        $offre->heureOuverture = $req['heureOuv'];
        $offre->categ_id = $req['categorie'];
        $offre->ac_id = $req['autorite'];
        $offre->service = $req['service'];
        $offre->writeBy = Auth::user()->id;
        $offre->fichier = $chemin;
        $offre->save();
    
        // Insertion manuelle dans la table pivot
        foreach ($req['marche'] as $typeId) {
            DB::table('offre_type')->insert([
                'offre_id' => $offre->id,
                'type_id' => $typeId,
            ]);
        }

    
        $users = User::whereHas('alertes', function ($query) use ($offre) {
            $typeMarIds = $offre->types->pluck('id'); // Obtenir les IDs des types de marché
            $acId = $offre->ac_id;
            foreach($typeMarIds as $typeMarId){
                Alerte::where('marches', $typeMarId)
                ->where('ac', $acId)->get();
            };
        })->get();
        

        foreach ($users as $user) {
            $data = [
                'offre' => $offre,
                'user' => $user,
                'lien_offre' => url('/appels-d-offres/') // Génère le lien direct vers l'offre
            ];
    
            Mail::send('emails.offre_notification', $data, function ($message) use ($user) {
                $message->subject('Nouvelle Alerte Correspondante')
                        ->from(config('mail.from.address'), config('mail.from.name'))
                        ->to($user->email);
            });
        }
    
        return redirect()->route('admin.offre.list')
            ->with('msg-success', "L'offre a été bien ajoutée.");
    }


    function editer($id){
        return view('adminView.offre.edit',['offre'=>Offre::find($id)]);
    }

    function saveEdit(Request $req){
        if($req['fichier'] == null){

            $req->validate([
                'id'=>['required',  'numeric'],
                'reference'=>['required',  'string' , 'max:15'],
                'titre'=>['required',  'string'],
                'depot'=>['required',  'string' ],
                'categorie'=>['required',  'numeric' ],
                'autorite'=>['required',  'numeric'],
                'service'=>['required'],
                'marche'=>['required',  'numeric' ],
                'dateOuv'=>['required'],
                'heureOuv'=>['required'],
                'dateExp'=>['required'],
            ]);

        }else{
            $req->validate([
                'id'=>['required',  'numeric'],
                'reference'=>['required',  'string' , 'max:15'],
                'titre'=>['required',  'string'],
                'depot'=>['required',  'string' ],
                'categorie'=>['required',  'numeric' ],
                'autorite'=>['required',  'numeric'],
                'service'=>['required'],
                'marche'=>['required',  'numeric' ],
                'dateOuv'=>['required'],
                'heureOuv'=>['required'],
                'dateExp'=>['required'],
                'fichier'=>'required|file|mimes:pdf|max:5000000',
            ]);

            $chemin=$req->file('fichier')->store('upload_files', 'public');

        }



        $offre = Offre::find($req['id']);

        $offre->titre = $req['titre'];
        $offre->reference = $req['reference'];
        $offre->lieu_depot = $req['depot'];

        $offre->datePublication = date('Y-m-d');
        $offre->dateExpiration = $req['dateExp'];
        $offre->dateOuverture = $req['dateOuv'];
        $offre->heureOuverture = $req['heureOuv'];
        $offre->typeMar_id = $req['marche'];
        $offre->categ_id = $req['categorie'];
        $offre->ac_id = $req['autorite'];
        $offre->service = $req['service'];

        if($req['fichier'] != null){

            if(file_exists($offre->fichier)){
                unlink($offre->fichier);
            }

            $offre->fichier = $chemin;
        }


       $offre->save();

       return redirect()->route('admin.offre.list')
             ->with('msg-success', "Offre bien modifiée.");

    }

    function voir($id){

        $offre = DB::table('offres')
        ->join('categories', 'offres.categ_id', 'categories.id')
        ->join('autorites', 'offres.ac_id', 'autorites.id')
        ->where('offres.id', $id)
        ->get(['offres.*', 'categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre']);

        return view('adminView.offre.voir', ['offre'=>$offre]);
    }

}
