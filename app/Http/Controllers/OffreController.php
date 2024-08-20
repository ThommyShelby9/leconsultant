<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\OffreNotification;

use App\Models\Offre;
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

    function saveOffre(Request $req){

        $req->validate([
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

       $offre = new Offre();
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
       $offre->writeBy = Auth::user()->id;
       $offre->fichier = $chemin;
       $offre->save();


       $nbre=$req['marche'];
       $tm = $req['categorie'];

       //return $nbre. " et ".$tm;

    //    $o = DB::table('alertes')
    //    ->join('abonnements', 'alertes.abonnement_id', 'abonnements.id')
    //    ->where('abonnements.dateFin', '>=', date('Y-m-d'))
    //    ->Where('alertes.marches', 'like','%'.$nbre.'%')
    //    ->Where('alertes.ac', 'like','%'.$tm.'%')
    //    ->get(['alertes.idUser']);

       $users = User::whereHas('alertes', function ($query) use ($offre) {
        $query->where('marches', $offre->typeMar_id )
              ->where('ac', $offre->ac_id);
    })->get();

    // Envoyer les notifications
    foreach ($users as $user) {
        $user->notify(new OffreCorrespondante($offre, $user));
    }

       //Envoyez la notification aux abonnées



    //    foreach($o as $item){

    //         $user_al = User::find($item->idUser);

    //         $offre = ['titre'=>$req['titre'] , 'expire'=>$req['dateExp'] ];

    //         $user = ['email'=>$user_al->email , 'nomPrenoms'=>$user_al->nom." ".$user_al->prenoms, 'nomSociete'=>$user_al->nomSociete ,'type'=>$user_al->typeActor];

    //         Mail::to($user['email'])->send(new OffreNotification($user , $offre ));

    //    }


       return redirect()->route('admin.offre.list')
             ->with('msg-success', "La direction a été bien ajoutée.");

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
