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

            // Vérifier si l'utilisateur est connecté
    if (!auth()->check()) {
        // Afficher une alerte SweetAlert pour inviter à se connecter
        Alert::error('Non connecté', 'Vous devez vous connecter pour effectuer une recherche.');
        return redirect()->back();
    }

    // Vérifier si l'utilisateur a un abonnement valide
    $user = auth()->user();
     // Vérifiez si l'utilisateur a un abonnement actif
     $has_valid_subscription = Abonnement::where('idUser', $user->id)
     ->where('dateFin', '>', now()) // Comparer la date de fin avec la date actuelle
     ->exists(); // Vérifie si un tel abonnement existe
    if (!$user->$has_valid_subscription) {
        // Afficher une alerte SweetAlert pour informer de l'abonnement nécessaire
        Alert::warning('Abonnement requis', 'Vous devez avoir un abonnement actif pour effectuer une recherche.');
        return redirect()->back();
    }
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
            ->join('types', 'offres.domaine_activity', '=', 'types.id') // Assurez-vous que cette colonne existe dans la table "offres"
            ->leftJoin('offre_type', 'offres.id', '=', 'offre_type.offre_id');
    
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
            $query->where('types.id', '=', $req['type']); // Modifié ici pour faire référence à la bonne table
        }
    
        // Tri des résultats par ordre décroissant d'ID
        $query->orderByDesc('offres.id');
    
        // Paginer les résultats
        $res = $query->paginate(4);
    
        // Retourner la vue avec les résultats de recherche
        $types = Type::where('useFor', 'activite')->get();
        $ac = Autorite::all();
        return view('userView.offreRecherche', [
            'offres' => $res,
            'search' => $req['search'],
            'categ' => $req['categ'],
            'types' => $types,
            'ac' => $ac,
            'type' => $req['type']
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
