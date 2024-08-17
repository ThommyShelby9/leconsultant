<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Alerte;

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
}
