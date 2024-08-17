<?php

namespace App\Http\Controllers\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Offre;
use App\Models\Pageservice;
use App\Models\Formation;

class PageController extends Controller
{
    function welcome() {

        $offre = DB::table('offres')
        ->join('categories', 'offres.categ_id', 'categories.id')
        ->join('autorites', 'offres.ac_id', 'autorites.id')
        ->join('types', 'types.id', 'offres.typeMar_id')
        ->where('offres.dateExpiration', '>=', date('Y-m-d'))
        ->limit(4)
        ->orderBy('offres.dateExpiration')
        ->get(['offres.*', 'types.title as typeTitle','categories.title as categTitle' ,'autorites.name as autName', 'autorites.logo as logo' , 'autorites.abreviation as autAbre']);

        return view('welcome',['offres'=>$offre]);
    }

    function lesOffres(){

        $offre = DB::table('offres')
        ->select(['offres.*','types.title as typeTitle', 'categories.title as categTitle' ,'autorites.logo as logo' ,'autorites.name as autName' , 'autorites.abreviation as autAbre'])
        ->join('categories', 'offres.categ_id', 'categories.id')
        ->join('autorites', 'offres.ac_id', 'autorites.id')
        ->join('types', 'types.id', 'offres.typeMar_id')
        ->where('offres.dateExpiration', '>=', date('Y-m-d'))
        ->orderBy('offres.dateExpiration')
        ->paginate(4);

        return view('userView.offre',['offres'=>$offre]);
    }

    function lesServices(){

        $serv = Db::table('pageservices')->where('statut',1)->get();

        return view('servicesPage',['services'=>$serv]);
    }

    function lesFormations(){
        $form = DB::table('formations')
        ->paginate(4);

        //$form = Formation::all();

        return view('formationsPage',['formations'=>$form]);
    }

    function recherche(Request $req){
        //le search ; categorie ; ac

        //cas où on a le seach
        if($req['search'] != null){

            if($req['categorie']==0){
                //Toutes les categories

                if($req['typeMar'] == 0){

                    $req = DB::table('offres')
                    ->where('titre', 'like' , '%'.$req['search'].'%')
                    ->get();

                }elseif($req['typeMar'] >= 1){

                    $req = DB::table('offres')
                    ->where('titre', 'like' , '%'.$req['search'].'%')
                    ->where('typeMar_id', $req['typeMar'])
                    ->get();

                }


            }elseif($req['categorie'] >= 1){
                //Une seule categorie


                if($req['autorite'] ==0){



                    if($req['typeMar'] == 0){

                        $req = DB::table('offres')
                        ->where('titre', 'like' , '%'.$req['search'].'%')
                        ->where('categ_id', $req['categorie'])
                        ->get();

                    }elseif($req['typeMar'] >= 1){

                        $req = DB::table('offres')
                        ->where('titre', 'like' , '%'.$req['search'].'%')
                        ->where('categ_id', $req['categorie'])
                        ->where('typeMar_id', $req['typeMar'])
                        ->get();

                    }


                }elseif($req['autorite'] >=1 ){

                    if($req['typeMar'] == 0){

                        $req = DB::table('offres')
                        ->where('titre', 'like' , '%'.$req['search'].'%')
                        ->where('categ_id', $req['categorie'])
                        ->get();

                    }elseif($req['typeMar'] >= 1){

                        $req = DB::table('offres')
                        ->where('titre', 'like' , '%'.$req['search'].'%')
                        ->where('categ_id', $req['categorie'])
                        ->where('typeMar_id', $req['typeMar'])
                        ->get();

                    }

                }
            }

        }elseif( $req['search'] == null ){

            if($req['categorie']==0){
                //Toutes les categories
                $req = DB::table('offres')
                ->get();


            }elseif($req['categorie'] >= 1){
                //Une seule categorie


                if($req['autorite'] ==0){

                    $req = DB::table('offres')
                    ->where('categ_id', $req['categorie'])
                    ->get();

                }elseif($req['autorite'] >=1 ){

                    $req = DB::table('offres')
                    ->where('categ_id', $req['categorie'])
                    ->get();

                }
            }

        }
    }


    function voirFormation($id , $name){
        $form = Formation::find($id);
        return view('formationItem',['formation'=>$form]);
    }


}
