<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Offre;

class OffreController extends Controller
{
    function voirFichier($file){


        if( file_exists('upload_files/'.$file) ){

            // Type de contenu d'en-tête
            header("Content-type: application/pdf");

            header("Content-Length: " . filesize('upload_files/'.$file));

            // Envoyez le fichier au navigateur.
            readfile('upload_files/'.$file);

        }else{
            return back();
        }

    }

    function rechercher(Request $req ){
        //page":"offre","search":null,"
        //categ":"Toutes les Cat\u00e9gorie d'A.C","type":"Tous les Types d'offre"

        if($req['search']==null){

            if($req['categ']==0){

                if($req['type']==0){

                   // echo "Entrée vide, Toute categ , tous type";
                    $res = DB::table('offres')
                    ->select(['offres.*','autorites.logo as logo',  'types.title as typeTitle','categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre'])
                    ->join('categories', 'offres.categ_id', 'categories.id')
                    ->join('autorites', 'offres.ac_id', 'autorites.id')
                    ->join('types', 'types.id', 'offres.typeMar_id')
                    ->orderByDesc('offres.id')
                    ->paginate(4);

                }elseif($req['type']>=1){
                    //echo "Entrée vide, TOutes categ mais avec type";
                    $res = DB::table('offres')
                    ->select(['offres.*','autorites.logo as logo',  'types.title as typeTitle','categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre'])
                    ->join('categories', 'offres.categ_id', 'categories.id')
                    ->join('autorites', 'offres.ac_id', 'autorites.id')
                    ->join('types', 'types.id', 'offres.typeMar_id')
                    ->where('typeMar_id', $req['type'])
                    ->orderByDesc('offres.id')
                    ->paginate(4);


                }

            }elseif($req['categ']>=1){

                if($req['type']==0){

                   // echo "Entrée vide, Une categ , tous type";
                    $res = DB::table('offres')
                    ->select(['offres.*','autorites.logo as logo',  'types.title as typeTitle','categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre'])
                    ->join('categories', 'offres.categ_id', 'categories.id')
                    ->join('autorites', 'offres.ac_id', 'autorites.id')
                    ->join('types', 'types.id', 'offres.typeMar_id')
                    ->where('offres.categ_id', $req['categ'])
                    ->orderByDesc('offres.id')
                    ->paginate(4);

                }elseif($req['type']>=1){

                    //echo "Entrée vide, Une catge , un type";
                    $res = DB::table('offres')
                    ->select(['offres.*','autorites.logo as logo',  'types.title as typeTitle','categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre'])
                    ->join('categories', 'offres.categ_id', 'categories.id')
                    ->join('autorites', 'offres.ac_id', 'autorites.id')
                    ->join('types', 'types.id', 'offres.typeMar_id')
                    ->where('offres.categ_id', $req['categ'])
                    ->where('offres.typeMar_id', $req['type'])
                    ->orderByDesc('offres.id')
                    ->paginate(4);

                }

            }
        }else{

            if($req['categ']==0){

                if($req['type']==0){

                   // echo "Entrée non vide, Toute categ , tous type";

                    $res = DB::table('offres')
                    ->select(['offres.*','autorites.logo as logo',  'types.title as typeTitle','categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre'])
                    ->join('categories', 'offres.categ_id', 'categories.id')
                    ->join('autorites', 'offres.ac_id', 'autorites.id')
                    ->join('types', 'types.id', 'offres.typeMar_id')
                    ->where('offres.titre', 'like', '%'.$req['search'].'%')
                    ->orderByDesc('offres.id')
                     ->paginate(4);

                }elseif($req['type']>=1){

                   // echo "Entrée non vide, TOutes categ mais avec type";

                    $res = DB::table('offres')
                    ->select(['offres.*','autorites.logo as logo',  'types.title as typeTitle','categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre'])
                    ->join('categories', 'offres.categ_id', 'categories.id')
                     ->join('autorites', 'offres.ac_id', 'autorites.id')
                     ->join('types', 'types.id', 'offres.typeMar_id')
                     ->where('offres.titre', 'like', '%'.$req['search'].'%')
                    ->where('typeMar_id', $req['type'])
                    ->orderByDesc('offres.id')
                    ->paginate(4);

                }

            }elseif($req['categ']>=1){

                if($req['type']==0){

                    //echo "Entrée non vide, Une categ , tous type";
                    $res = DB::table('offres')
                    ->select(['offres.*',  'types.title as typeTitle','categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre'])
                    ->join('categories', 'offres.categ_id', 'categories.id')
                    ->join('autorites', 'offres.ac_id', 'autorites.id')
                    ->join('types', 'types.id', 'offres.typeMar_id')
                    ->where('offres.titre', 'like', '%'.$req['search'].'%')
                    ->where('offres.categ_id', $req['categ'])
                    ->orderByDesc('offres.id')
                    ->paginate(4);

                }elseif($req['type']>=1){

                    //echo "Entrée non vide, Une catge , un type";
                    $res = DB::table('offres')
                    ->select(['offres.*', 'types.title as typeTitle',  'categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre'])->select(['offres.*', 'categories.title as categTitle' ,'autorites.name as autName' , 'autorites.abreviation as autAbre'])
                    ->join('categories', 'offres.categ_id', 'categories.id')
                    ->join('autorites', 'offres.ac_id', 'autorites.id')
                    ->join('types', 'types.id', 'offres.typeMar_id')
                    ->where('offres.titre', 'like', '%'.$req['search'].'%')
                    ->where('offres.categ_id', $req['categ'])
                    ->where('typeMar_id', $req['type'])
                    ->orderByDesc('offres.id')
                     ->paginate(4);


                }

            }

        }

        return view('userView.offreRecherche',['offres'=>$res , 'search'=>$req['search'] , 'categ'=>$req['categ'], 'type'=>$req['type']]);
    }

    
}
