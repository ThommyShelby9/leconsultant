<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Categorie;

use App\Models\Autorite;
use App\Models\Direction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale('fr');

        view()->composer([ 'welcome', 'adminView.autorite.*' , 'adminView.direction.*' , 'adminView.offre.*' , 'userView.alerte.create' , 'userView.offre' ,  'userView.offreRecherche' ], function ($view)
        {
            $categ = Categorie::all();
            $view->with('les_categories', $categ );
        });

        view()->composer(['welcome','adminView.offre.*' , 'userView.alerte.create' , 'userView.offre' ,  'userView.offreRecherche'], function ($view)
        {
            $mar = DB::table('types')->where('useFor','marche')->get(['id', 'title']);
            $view->with('les_types_marches', $mar );
        });

        view()->composer(['component.packs' , 'userView.abonnement' ], function ($view)
        {
            $pack = DB::table('packs')->where('payant',True)->get();
            $view->with('les_packs', $pack );
        });



    }
}
