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
use App\Models\Autorite;
use App\Models\Offre;
use App\Models\Type;
use App\Models\Type_Offre;
use App\Models\User;
use App\Notifications\OffreCorrespondante;

class OffreController extends Controller
{
    ///LEs offres
    function storeOffre()
    {
        $offres = DB::table('offres')
            ->join('categories', 'offres.categ_id', '=', 'categories.id')
            ->join('autorites', 'offres.ac_id', '=', 'autorites.id')
            ->orderBy('offres.datePublication', 'desc') // Tri par la date de publication la plus récente
            ->get(['offres.*', 'categories.title as categTitle', 'autorites.name as autName', 'autorites.abreviation as autAbre']);

        return view('adminView.offre.liste', ['offres' => $offres]);
    }



    function publierOffre()
    {
        // Récupérer les données de la table types où useFor = 'activite'
        $types = Type::where('useFor', 'activite')->get();
    
        // Passer les données à la vue
        return view('adminView.offre.create', compact('types'));
    }

    public function saveOffre(Request $req)
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
        'dateOuv' => ['required', 'date'],
        'heureOuv' => ['required', 'date_format:H:i'],
        'dateExp' => ['required', 'date'],
        'fichier' => 'required|file|mimes:pdf|max:5000',
        'domaineActivite' => ['required', 'exists:types,id'], // Validation du domaine d'activité
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
    $offre->domaine_activity = $req['domaineActivite']; // Enregistrement du domaine d'activité par ID
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

    // Notification des utilisateurs
    $users = User::whereHas('alertes', function ($query) use ($offre) {
        $typeMarIds = $offre->types->pluck('id'); // Obtenir les IDs des types de marché
        $acId = $offre->ac_id;

        $query->whereIn('marches', $typeMarIds)
              ->where('ac', $acId);
    })->get();

    // Récupération du nom de l'autorité contractante
    $autorite = Autorite::find($offre->ac_id)->name;

    foreach ($users as $user) {
        $data = [
            'offre' => $offre,
            'user' => $user,
            'autorite' => $autorite, // Ajouter le nom de l'autorité contractante
            'lien_offre' => url('/appels-d-offres/' . $offre->id),
            'fichier_offre' => url('storage/' . $offre->fichier), // Génère le lien de téléchargement du fichier
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

    function editer($id)
    {
        $types = Type::where('useFor', 'activite')->get();

        return view('adminView.offre.edit', ['offre' => Offre::find($id)], compact("types"));
    }

    public function saveEdit(Request $req)
    {
        // Validation des données
        $req->validate([
            'id' => ['required', 'numeric'],
            'reference' => ['required', 'string', 'max:15'],
            'titre' => ['required', 'string'],
            'depot' => ['required', 'string'],
            'categorie' => ['required', 'numeric'],
            'autorite' => ['required', 'numeric'],
            'service' => ['required'],
            'marche' => ['required', 'array'], // Valider comme un tableau
            'marche.*' => ['numeric'], // Chaque élément du tableau doit être un nombre
            'dateOuv' => ['required', 'date'],
            'heureOuv' => ['required', 'date_format:H:i'],
            'dateExp' => ['required', 'date'],
            'fichier' => 'nullable|file|mimes:pdf|max:5000',
            'domaineActivite' => ['required', 'exists:types,id'], // Validation du domaine d'activité
        ]);
    
        // Récupérer l'offre existante
        $offre = Offre::find($req['id']);
    
        if (!$offre) {
            return redirect()->back()->withErrors("L'offre n'existe pas.");
        }
    
        // Mise à jour des champs
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
        $offre->domaine_activity = $req['domaineActivite']; // Mise à jour du domaine d'activité
    
        // Gestion du fichier (si un nouveau fichier est téléchargé)
        if ($req->hasFile('fichier')) {
            // Suppression de l'ancien fichier
            if ($offre->fichier && file_exists(storage_path('app/public/' . $offre->fichier))) {
                unlink(storage_path('app/public/' . $offre->fichier));
            }
    
            // Stockage du nouveau fichier
            $chemin = $req->file('fichier')->store('upload_files', 'public');
            $offre->fichier = $chemin;
        }
    
        // Sauvegarder l'offre
        $offre->save();
    
        // Mise à jour des types de marché dans la table pivot
        DB::table('offre_type')->where('offre_id', $offre->id)->delete(); // Suppression des anciennes relations
        foreach ($req['marche'] as $typeId) {
            DB::table('offre_type')->insert([
                'offre_id' => $offre->id,
                'type_id' => $typeId,
            ]);
        }
    
        return redirect()->route('admin.offre.list')
            ->with('msg-success', "Offre bien modifiée.");
    }
    

    function voir($id)
    {

        $offre = DB::table('offres')
            ->join('categories', 'offres.categ_id', 'categories.id')
            ->join('autorites', 'offres.ac_id', 'autorites.id')
            ->where('offres.id', $id)
            ->get(['offres.*', 'categories.title as categTitle', 'autorites.name as autName', 'autorites.abreviation as autAbre']);

        return view('adminView.offre.voir', ['offre' => $offre]);
    }

    public function delete_offre($id)
    {
        // Trouver l'offre par son ID
        $offre = Offre::findOrFail($id);

        // Supprimer l'offre
        $offre->delete();

        // Rediriger avec un message de succès
        return redirect()->route('admin.offre.list')->with('msg-success', 'L\'offre a été supprimée avec succès.');
    }

    public function getOfferDetails($id) {
        $offre = Offre::find($id);
    
        if (!$offre) {
            return response()->json(['error' => 'Offre introuvable'], 404);
        }
    
        return response()->json([
            'titre' => $offre->titre,
            'autName' => $offre->autName,
            'categTitle' => $offre->categTitle,
            'typeTitle' => $offre->typeTitle,
            'datePublication' => date('d M Y', strtotime($offre->datePublication)),
            'dateExpiration' => date('d M Y', strtotime($offre->dateExpiration)),
            'fileUrl' => route('voirFichier', $offre->file) // URL pour télécharger l'offre
        ]);
    }
    
}
