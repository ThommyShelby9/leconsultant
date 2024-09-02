<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Mail\AlerteNotification;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Alerte;
use App\Models\Autorite;
use App\Models\Type;
use Illuminate\Support\Facades\Mail;

class AlerteController extends Controller
{
    function pageAlerte(){

        //Le type d'abonnements de la personne
        $abon = DB::table('abonnements')
        ->join('packs', 'packs.id', 'abonnements.typePack')
        ->where('abonnements.idUser', Auth::user()->id)
        ->OrderBy('abonnements.id', 'desc')->limit(1)->get(['typePack', 'modeEssaie', 'dateFin', 'abonnements.id']);



        return view('userView.alerte.create' ,
                ['abon_actu'=>$abon]
            );

    }

    function alerteCreer(Request $req , $type){

        /*$nbre=7;
        $o = DB::table('alertes')
        ->where('marches', '=',$nbre)
        ->orWhere('marches', 'like','%-'.$nbre.'-%')
        ->orWhere('marches', 'like','%-'.$nbre)->get(['id']);
        return $o;*/

        // return $type;
        if($type == "gratuit"){

            return view('userView.alerte.create' ,
                ['data_input'=>'radio' , 'data_1'=>'marche' , 'data_2'=>'ac' , 'type'=>$type]
            );
        }else{

            return view('userView.alerte.create' ,
                ['data_input'=>'checkbox' , 'data_1'=>'marche[]' , 'data_2'=>'ac[]' , 'type'=>$type]
            );
        }

    }

    function alerteSave(Request $req ){
        return $req;

        if($req['type']==1){

            $req->validate([
                'idAbonnement'=>['required', 'numeric'],
                'ac'=>['required', 'numeric'],
                'marche'=>['required', 'numeric'],
            ]);

        }else{
            if($req['type']==2){

                $req->validate([
                    'idAbonnement'=>['required', 'numeric'],
                    'ac'=>['required', 'array'],
                    'marche'=>['required', 'array'],
                ]);

            }


        }

        //Voir si pour cet abonnement l'alerte n"existait pas
        $aler = DB::table('alertes')
        ->where('abonnement_id',$req['idAbonnement'])
        ->where('idUser',Auth::user()->id)->count();

        if($aler == 0){
            //Si ça n'existe pas encore
            $al =  new Alerte();

            $al->idUser = Auth::user()->id;
            $al->details=$req['type']." - Type ";
            $al->dateDebut = date('Y-m-d');
            $al->abonnement_id = $req['idAbonnement'];

            if($req['type']==1){

                $al->ac = $req['ac'];
                $al->marches = $req['marche'];

            }elseif($req['type']==2){

                $al->marches = implode("-",$req['marche']);
                $al->ac = implode("-",$req['ac']);

            }
            $al->save();


        }else{

        }




        return redirect()->route('home');
        //return view('userView.alerte.create');
    }


    public function alerte(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'type_marche' => 'required|array', // Valide comme tableau
            'ac' => 'required|array', // Valide comme tableau
            'domaine_activite' => 'required|string', // Validation du domaine d'activité
        ]);
    
        // Récupération des objets associés à partir de la base de données
        $marches = Type::whereIn('id', $validated['type_marche'])->get();
        $acs = Autorite::whereIn('id', $validated['ac'])->get();
    
        // Sauvegarde de l'alerte dans la base de données
        $alerte = Alerte::updateOrCreate([
            'idUser' => auth()->id(),
        ], [
            'marches' => json_encode($validated['type_marche']), // Sauvegarde en format JSON
            'ac' => json_encode($validated['ac']), // Sauvegarde en format JSON
            'domaine_activity' => $validated['domaine_activite'], // Sauvegarde du domaine d'activité
            'details' => 'Alerte pour marchés: ' . implode(', ', $marches->pluck('title')->toArray()) . 
                         ' - AC: ' . implode(', ', $acs->pluck('name')->toArray()) . 
                         ' - Domaine d\'Activité: ' . $validated['domaine_activite'], // Ajout du domaine d'activité
            'abonnement_id' => 1,
            'dateDebut' => now(),
        ]);
    
        // Préparation des données pour l'email
        $domaine = Type::where('id', $validated['domaine_activite'])->get();
        $data = [
            'type_marches' => $marches, // Collection d'objets Type
            'categories_ac' => $acs, // Collection d'objets Autorite
            'domaine_activite' => $domaine, // Domaine d'activité pour l'email
            'user_name' => auth()->user()->nom . ' ' . auth()->user()->prenoms,
        ];
    
        // Envoi de l'email de notification à l'utilisateur
        Mail::send('emails.alerte_notification', $data, function ($message) use ($alerte) {
            $message->subject('Nouvelle Alerte Correspondante')
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->to(auth()->user()->email);
        });
    
        // Redirection avec un message de succès
        return redirect()->back()->with('success', 'Votre alerte a été enregistrée avec succès !');
    }
    

    public function alertePage() {
        $ac = Autorite::all();
        $marches = Type::all();
        $domainesActivite = Type::where('useFor', 'activite')->get();
        
        return view('emails.alerte')->with(compact('ac', 'marches', 'domainesActivite'));
    }
    
}
