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

    public function delete_offre($id)
    {
        // Trouver l'offre par son identifiant
        $offre = Offre::find($id);
    
        if ($offre) {
            // Supprimer les relations associées, si nécessaire
            // Exemple : supprimer les types de marché associés à l'offre
            // Vous devez adapter cette partie selon vos besoins spécifiques
            $offre->types()->detach(); // Détache les relations de type de marché
    
            // Supprimer le fichier associé, si nécessaire
            if (file_exists(storage_path('app/public/' . $offre->fichier))) {
                unlink(storage_path('app/public/' . $offre->fichier)); // Supprime le fichier du stockage
            }
    
            // Supprimer l'offre
            $offre->delete();
    
            // Rediriger ou retourner une réponse
            return redirect()->route('admin.offre.list')
                             ->with('msg-success', 'L\'offre a été supprimée avec succès.');
        } else {
            // Offres non trouvée
            return redirect()->route('admin.offre.list')
                             ->with('msg-error', 'L\'offre demandée n\'existe pas.');
        }
    }
    
}
