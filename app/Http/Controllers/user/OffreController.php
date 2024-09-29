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

    
    public function rechercher(Request $req)
{
    // Initialisation de la requête de base
    $query = DB::table('offres')
        ->select([
            'offres.*',
            'autorites.logo as logo',
            'types.title as typeTitle',
            'categories.title as categTitle',
            'autorites.name as autName',
            'autorites.abreviation as autAbre'
        ])
        ->join('categories', 'offres.categ_id', '=', 'categories.id')
        ->join('autorites', 'offres.ac_id', '=', 'autorites.id')
        ->leftJoin('offre_type', 'offres.id', '=', 'offre_type.offre_id')
        ->leftJoin('types', 'offre_type.type_id', '=', 'types.id');

    // Filtrer par titre si la recherche n'est pas vide
    if ($req['search'] !== null) {
        $query->where('offres.titre', 'like', '%' . $req['search'] . '%');
    }

    // Filtrer par autorité contractante si un type spécifique est sélectionné
    if ($req['categ'] > 0) {
        $query->where('offres.ac_id', '=', $req['categ']);
    }

    // Filtrer par domaine d'activité (type d'offre) si un type spécifique est sélectionné
    if ($req['type'] > 0) {
        $query->where('offre_type.type_id', '=', $req['type']);
    }

    // Tri des résultats par ordre décroissant d'ID
    $query->orderByDesc('offres.id');

    // Paginer les résultats
    $res = $query->paginate(4);

    // Retourner la vue avec les résultats de recherche
    return view('userView.offreRecherche', [
        'offres' => $res,
        'search' => $req['search'],
        'categ' => $req['categ'],
        'type' => $req['type']
    ]);
}


    
}
