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


    // Vérifier si l'utilisateur est connecté
    if (Auth::check()) {
        $user = Auth::user();

        // Vérifier si l'utilisateur a un abonnement actif
        $hasActiveSubscription = DB::table('abonnements')
            ->where('idUser', $user->id)
            ->where('dateFin', '>=', now())  // Vérifie si la date de fin est dans le futur
            ->where('stop', false)  // Vérifie que l'abonnement n'est pas arrêté
            ->exists();
    }

    // Requête pour récupérer les offres
    $offres = DB::table('offres')
        ->join('categories', 'offres.categ_id', '=', 'categories.id')
        ->join('autorites', 'offres.ac_id', '=', 'autorites.id')
        ->leftJoin('offre_type', 'offres.id', '=', 'offre_type.offre_id')
        ->leftJoin('types', 'offre_type.type_id', '=', 'types.id')
        ->where('offres.dateExpiration', '>=', date('Y-m-d'))
        ->limit(4)
        ->orderBy('offres.dateExpiration')
        ->get(['offres.*', 'types.title as typeTitle', 'categories.title as categTitle', 'autorites.name as autName', 'autorites.logo as logo', 'autorites.abreviation as autAbre']);

    $news = $this->getBeninNews(); // Appeler la méthode dans le même contrôleur

    return view('welcome', [
        'offres' => $offres,
        'types' => $types,
        'ac' => $ac,
        'hasActiveSubscription' => $hasActiveSubscription,
        'user' => $user,
        'news' => $news, // Passer les actualités à la vue
    ]);
}

function lesOffres()
{
    // Création d'une instance de QueryBuilder pour construire la requête
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
        ->groupBy('offres.id'); // Assurez-vous que les résultats sont correctement groupés

    // Appel à paginate sur l'instance de QueryBuilder
    $offres = $query->paginate(4);

    // Retourner la vue avec les résultats paginés
    return view('userView.offre', ['offres' => $offres]);
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
