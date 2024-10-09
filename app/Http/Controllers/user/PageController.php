<?php

namespace App\Http\Controllers\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Autorite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Offre;
use App\Models\Pageservice;
use App\Models\Formation;
use App\Models\Type;
use GoogleSearchResults;
use Illuminate\Support\Facades\Log;
use jcobhams\NewsApi\NewsApi;

class PageController extends Controller
{


    public function getBeninNews()
    {
        $newsapi = new NewsApi('a9fa759e6b5a460e97dd4c90992ca6f4');
    
        $params = [
            'q' => 'Bénin',
            'language' => 'fr',
            'country' => 'bj', // Code pays pour le Bénin
            'pageSize' => 10,
        ];
    
        try {
            $top_headlines = $newsapi->getTopHeadlines(
                $params['q'],
                null,
                $params['country'],
                null,
                $params['pageSize'],
                1
            );
    
            if (isset($top_headlines->articles) && !empty($top_headlines->articles)) {
                return $top_headlines->articles;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            // Gérer l'erreur ici, par exemple en la journalisant
            Log::error('Erreur lors de la récupération des actualités: ' . $e->getMessage());
            return [];
        }
    }
    public function welcome()
    {
        $user = null;
        $hasActiveSubscription = false;
        $types = Type::where('useFor', 'activite')->get();
        $ac = Autorite::all();
    
        if (Auth::check()) {
            $user = Auth::user();
            $hasActiveSubscription = DB::table('abonnements')
                ->where('idUser', $user->id)
                ->where('dateFin', '>=', now())
                ->where('stop', false)
                ->exists();
        }
    
        // Récupérer toutes les offres
        $allOffres = DB::table('offres')
            ->join('categories', 'offres.categ_id', '=', 'categories.id')
            ->join('autorites', 'offres.ac_id', '=', 'autorites.id')
            ->leftJoin('offre_type', 'offres.id', '=', 'offre_type.offre_id')
            ->leftJoin('types', 'offre_type.type_id', '=', 'types.id')
            ->where('offres.dateExpiration', '>=', date('Y-m-d'))
            ->orderBy('offres.dateExpiration')
            ->get(['offres.*', 'types.title as typeTitle', 'categories.title as categTitle', 'autorites.name as autName', 'autorites.logo as logo', 'autorites.abreviation as autAbre']);
    
        // Limiter l'affichage à 4 offres pour le premier affichage
        $offresAffichees = $allOffres->take(4);
    
        $news = $this->getBeninNews(); 
    
        return view('welcome', [
            'offres' => $offresAffichees,
            'allOffres' => $allOffres, // Passer toutes les offres à la vue
            'types' => $types,
            'ac' => $ac,
            'hasActiveSubscription' => $hasActiveSubscription,
            'user' => $user,
            'news' => $news,
            'totalOffres' => $allOffres->count(), // Passer le nombre total d'offres
        ]);
    }
    
    function lesOffres()
    {

            // Vérifiez si l'utilisateur est authentifié
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
    }

    // Récupérer l'utilisateur authentifié
    $user = auth()->user();

    // Vérifiez si l'utilisateur a un abonnement actif
    $has_valid_subscription = Abonnement::where('idUser', auth()->id())
    ->where('dateFin', '>', now()) // Comparer la date de fin avec la date actuelle
    ->exists(); // Vérifie si un tel abonnement existe


    if (!$has_valid_subscription) {
        return redirect()->route('home')->with('error', 'Vous devez avoir un abonnement actif pour accéder à cette page.');
    }

        // Construction de la requête
        $query = DB::table('offres')
            ->select([
                'offres.id',
                'offres.titre',
                'offres.reference',
                'offres.lieu_depot',
                'offres.datePublication',
                'offres.dateExpiration',
                'offres.dateOuverture',
                'offres.heureOuverture',
                'offres.categ_id',
                'offres.ac_id',
                'offres.service',
                'offres.writeBy',
                'offres.fichier',
                'categories.title as categTitle',
                'autorites.logo as logo',
                'autorites.name as autName',
                'types.title as typeTitle'
            ])
            ->join('categories', 'offres.categ_id', '=', 'categories.id')
            ->join('autorites', 'offres.ac_id', '=', 'autorites.id')
            ->leftJoin('offre_type', 'offres.id', '=', 'offre_type.offre_id')
            ->leftJoin('types', 'offre_type.type_id', '=', 'types.id')
            ->where('offres.dateExpiration', '>=', date('Y-m-d'))
            ->orderBy('offres.dateExpiration')
            ->groupBy('offres.id'); // Groupe par id pour éviter les duplications
    
        // Paginer les offres
        $offres = $query->paginate(4);
        $types = Type::where('useFor', 'activite')->get();
        $ac = Autorite::all();
    
        // Retourner la vue avec les données
        return view('userView.offre', [
            'offres' => $offres,
            'types' => $types,
            'ac' => $ac,
        ]);
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

    public function recherche(Request $req)
{
    // Initialisation de la requête de base
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
    }

    // Récupérer l'utilisateur authentifié
    $user = auth()->user();

    // Vérifiez si l'utilisateur a un abonnement actif
    $has_valid_subscription = Abonnement::where('idUser', $user->id)
    ->where('dateFin', '>', now()) // Comparer la date de fin avec la date actuelle
    ->exists(); // Vérifie si un tel abonnement existe


    if (!$has_valid_subscription) {
        return redirect()->route('home')->with('error', 'Vous devez avoir un abonnement actif pour accéder à cette page.');
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
        ->join('autorites', 'offres.autorite_id', '=', 'autorites.id') // Assurez-vous que c'est le bon champ pour l'autorité
        ->join('types', 'offres.domaine_activity', '=', 'types.id'); // Assurez-vous que c'est le bon champ pour le type de marché

    // Filtrer par titre si la recherche n'est pas vide
    if ($req['search'] != null) {
        $query->where('offres.titre', 'like', '%' . $req['search'] . '%');
    }

    // Filtrer par catégorie si une catégorie spécifique est sélectionnée
    if ($req['categorie'] > 0) {
        $query->where('offres.categ_id', '=', $req['categorie']);
    }

    // Filtrer par autorité si une autorité spécifique est sélectionnée
    if ($req['autorite'] > 0) {
        $query->where('offres.autorite_id', '=', $req['autorite']);
    }

    // Filtrer par domaine d'activité (typeMar) si un type spécifique est sélectionné
    if ($req['typeMar'] > 0) {
        $query->where('types.id', '=', $req['typeMar']);
    }

    // Tri des résultats par ordre décroissant d'ID
    $query->orderByDesc('offres.id');

    // Paginer les résultats
    $resultats = $query->paginate(4);

    // Récupérer les types et les autorités pour la vue
    $types = Type::where('useFor', 'activite')->get();
    $ac = Autorite::all();

    // Retourner la vue avec les résultats de recherche
    return view('resultats', [
        'offres' => $resultats,
        'search' => $req['search'],
        'categ' => $req['categorie'],
        'types' => $types,
        'ac' => $ac,
        'type' => $req['typeMar'],
    ]);
}

    

    function voirFormation($id , $name){
        $form = Formation::find($id);
        return view('formationItem',['formation'=>$form]);
    }


}
