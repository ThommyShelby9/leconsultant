<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Autorite;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Offre;
use App\Models\Type;
use RealRashid\SweetAlert\Facades\Alert;

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
    if (!auth()->check()) {
        Alert::error('Non connecté', 'Vous devez vous connecter pour effectuer une recherche.');
        return redirect()->back();
    }

    $user = auth()->user();
    $has_valid_subscription = Abonnement::where('idUser', $user->id)
        ->where('dateFin', '>', now())
        ->exists();

    if (!$has_valid_subscription) { // ✅ Corrigé
        Alert::warning('Abonnement requis', 'Vous devez avoir un abonnement actif pour effectuer une recherche.');
        return redirect()->back();
    }

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
        ->join('types', 'offres.domaine_activity', '=', 'types.id')
        ->leftJoin('offre_type', 'offres.id', '=', 'offre_type.offre_id');

    // ✅ Corrigé : empty() gère null ET ""
    if (!empty($req['search'])) {
        $query->where('offres.titre', 'like', '%' . $req['search'] . '%');
    }

    if (!empty($req['categ']) && $req['categ'] > 0) {
        $query->where('offres.ac_id', '=', $req['categ']);
    }

    if (!empty($req['type']) && $req['type'] > 0) {
        $query->where('types.id', '=', $req['type']);
    }

    $query->orderByDesc('offres.id');
    $res = $query->paginate(4);

    $types = Type::where('useFor', 'activite')->get();
    $ac = Autorite::all();

    return view('userView.offreRecherche', [
        'offres' => $res,
        'search' => $req['search'],
        'categ'  => $req['categ'],
        'types'  => $types,
        'ac'     => $ac,
        'type'   => $req['type']
    ]);
}
    
public function getOfferDetails($id) {
    $offre = DB::table('offres')
        ->join('categories', 'offres.categ_id', 'categories.id')
        ->join('autorites', 'offres.ac_id', 'autorites.id')
        ->where('offres.id', $id)
        ->first([
            'offres.*', 
            'categories.title as categTitle', 
            'autorites.name as autName', 
            'autorites.abreviation as autAbre',
            'offres.fichier' // Ajoutez explicitement le champ file ici
        ]);

    if (!$offre) {
        return response()->json(['error' => 'Offre introuvable'], 404);
    }

    // Assurez-vous que le fichier existe dans l'enregistrement de l'offre
    $fileUrl = $offre->fichier ? route('voirFichier', ['file' => basename($offre->fichier)]) : null;

    return response()->json([
        'titre' => $offre->titre,
        'autName' => $offre->autName,
        'categTitle' => $offre->categTitle,
        'typeTitle' => $offre->typeTitle ?? 'Non spécifié',  // Si le type n'est pas spécifié
        'datePublication' => date('d M Y', strtotime($offre->datePublication)),
        'dateExpiration' => date('d M Y', strtotime($offre->dateExpiration)),
        'file' => $fileUrl
    ]);
}




    
}
