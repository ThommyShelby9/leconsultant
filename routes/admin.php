<?php
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

//use App\Http\Controllers\admin\CurrencyController as AdminCurrencyController;

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\AutoriteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\PageserviceController;
use App\Http\Controllers\OffreController as ControllersOffreController;


Route::prefix('admin')->name('admin.')->group(function(){

    //Route::get('/',[AdminController::class, 'dashBoard']   )->middleware('auth:admin');

    Route::get('home2/{id}', [UserController::class, 'home2'] )->name('home2');

    //Tableau de bord de l'admin
    Route::get('home', [AdminController::class, 'dashBoard']  )
        ->middleware('auth:admin')->name('home');

    //Login de l'admin
    Route::get('login', function(){ return view( 'adminView.login'); } )
        ->middleware('guest:admin')->name('login');

    //Verification du  login de l'admin
    $limiter = config('fortify.limiters.login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:admin',
            $limiter ? 'throttle:'.$limiter : null,
        ]))->name('login');

    //Deconnexion de l'admin
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');




    //Les catégorie d'AC
    Route::group(['prefix'=>'categories'], function(){

        Route::get('list', [CategorieController::class , 'store'] )
        ->middleware('auth:admin')
        ->name('categorie.list');

        Route::post('add', [CategorieController::class , 'add'] )
            ->middleware('auth:admin')
            ->name('categorie.add');

        Route::get('edit/{id}', [CategorieController::class , 'edit'] )
            ->middleware('auth:admin')
            ->name('categorie.edit')
            ->where("id","[0-9]+");

        Route::post('save', [CategorieController::class , 'edit_save'] )
            ->middleware('auth:admin')
            ->name('categorie.edit.save');

        Route::delete('admin/delete/{id}', [CategorieController::class, 'delete'])
        ->middleware('auth:admin')
        ->name('ca.delete');

    });

    //Les autorités contractantes
    Route::group(['prefix'=>'authority'], function(){

        Route::get('list', [AutoriteController::class , 'store'] )
            ->middleware('auth:admin')
            ->name('ac.list');


        Route::get('new', [AutoriteController::class , 'ajouter'] )
            ->middleware('auth:admin')
            ->name('ac.new');

        Route::post('add', [AutoriteController::class , 'add'] )
            ->middleware('auth:admin')
            ->name('ac.add');

        Route::get('edit/{id}', [AutoriteController::class , 'edit'] )
            ->middleware('auth:admin')
            ->name('ac.edit')
            ->where("id","[0-9]+");

        Route::post('save', [AutoriteController::class , 'edit_save'] )
            ->middleware('auth:admin')
            ->name('ac.edit.save');

        Route::get('see/{id}', [AutoriteController::class , 'voir'] )
            ->middleware('auth:admin')
            ->name('ac.see')
            ->where("id","[0-9]+");




        //Creer une direction ou services
        Route::get('services/new/{id}', [DirectionController::class , 'creerDirection'] )
            ->middleware('auth:admin')
            ->name('direction.new');

        Route::post('services/save', [DirectionController::class , 'saveDirection'] )
            ->middleware('auth:admin')
            ->name('direction.new.save');

    });

     //Liste des directions ou services
    Route::group(['prefix'=>'services'], function(){

        Route::get('list', [DirectionController::class , 'store'] )
        ->middleware('auth:admin')
        ->name('direction.list');

        Route::get('create', [DirectionController::class , 'createDirection'] )
        ->middleware('auth:admin')
        ->name('direction.create');

        Route::get('edit/{id}', [DirectionController::class , 'modifierDirection'] )
            ->middleware('auth:admin')
            ->name('direction.edit')
            ->where("id","[0-9]+");

        Route::post('save', [DirectionController::class , 'saveModif'] )
            ->middleware('auth:admin')
            ->name('direction.edit.save');
    });

    //Les utilisateurs
    Route::group(['prefix'=>'clients'], function(){

        Route::get('list', [UserController::class , 'store'] )
            ->middleware('auth:admin')
            ->name('client.list');

    });

    //Les administrateurs
    Route::group(['prefix'=>'collabo'], function(){

        Route::get('list', [AdminController::class , 'store'] )
            ->middleware('auth:admin')
            ->name('colab.list');

        Route::get('new', [AdminController::class , 'creer'] )
            ->middleware('auth:admin')
            ->name('colab.new');

        Route::post('save', [AdminController::class , 'saveColab'] )
            ->middleware('auth:admin')
            ->name('colab.save');

        Route::get('edit/{id}', [AdminController::class , 'modifier'] )
            ->middleware('auth:admin')
            ->name('colab.edit')
            ->where("id","[0-9]+");

        Route::post('edit-save',[AdminController::class , 'modifierSave'] )
            ->middleware('auth:admin')
            ->name('colab.edit.save');

        Route::get('block/{id}', [AdminController::class , 'block'] )
            ->middleware('auth:admin')
            ->name('colab.block')
            ->where("id","[0-9]+");

        Route::get('unblock/{id}', [AdminController::class , 'unblock'] )
            ->middleware('auth:admin')
            ->name('colab.unblock')
            ->where("id","[0-9]+");



    });

    //Les types
    Route::group(['prefix'=>'type'], function(){

        Route::get('list', [TypeController::class , 'store'] )
            ->middleware('auth:admin')
            ->name('type.list');

        Route::get('create', [TypeController::class , 'creer'] )
                ->middleware('auth:admin')
                ->name('type.new');

        Route::post('save', [TypeController::class , 'saveType'] )
                ->middleware('auth:admin')
                ->name('type.save');

        Route::get('edit/{id}', [TypeController::class , 'editer'] )
                ->middleware('auth:admin')
                ->name('type.edit')
                ->where("id","[0-9]+");

        Route::post('save/edit', [TypeController::class , 'saveEdit'] )
            ->middleware('auth:admin')
            ->name('type.save.edit');


        Route::delete('/admin/type/delete/{id}', [TypeController::class, 'delete'])
        ->middleware('auth:admin')
        ->name('da.delete');



    });

    //Les abonnements
    Route::group(['prefix'=>'pack'], function(){

        Route::get('list',[PackController::class, 'storePack'] )
            ->middleware('auth:admin')
            ->name('pack.list');

        Route::get('edit/{id}',[PackController::class, 'EditPack'] )
                ->middleware('auth:admin')
                ->name('pack.edit')
                ->where("id","[0-9]+");

        Route::get('new',[PackController::class, 'newPack'] )
                ->middleware('auth:admin')
                ->name('pack.new');

        Route::post('save/edit', [PackController::class , 'saveEdit'] )
                ->middleware('auth:admin')
            ->name('pack.edit.save');

    });

    //Les offres
    Route::group(['prefix'=>'offre'], function(){

        Route::get('list', [OffreController::class , 'storeOffre'] )
            ->middleware('auth:admin')
            ->name('offre.list');

        Route::get('publier', [OffreController::class , 'publierOffre'] )
                ->middleware('auth:admin')
                ->name('offre.new');

        Route::post('save', [OffreController::class , 'saveOffre'] )
                ->middleware('auth:admin')
                ->name('offre.save');

        Route::get('edit/{id}', [OffreController::class , 'editer'] )
                ->middleware('auth:admin')
                ->name('offre.edit')
                ->where("id","[0-9]+");

        Route::post('saveedit', [OffreController::class , 'saveEdit'] )
            ->middleware('auth:admin')
            ->name('offre.save.edit');

        Route::get('see/{id}', [OffreController::class , 'voir'] )
            ->middleware('auth:admin')
            ->name('offre.see')
            ->where("id","[0-9]+");
        
        Route::delete('/admin/offre/delete/{id}', [OffreController::class, 'delete'])
        ->middleware('auth:admin')
        ->name('offre.delete');


    });

    //Les formations
    Route::group(['prefix'=>'formations'],function(){

        Route::get('list',[FormationController::class , 'store'])
        ->middleware('auth:admin')
        ->name('formation.list');

        Route::get('new',[FormationController::class , 'publier'])
        ->middleware('auth:admin')
        ->name('formation.new');

        Route::post('save',[FormationController::class , 'enregistrer'])
        ->middleware('auth:admin')
        ->name('formation.save');

        Route::get('edit/{id}',[FormationController::class , 'editer'])
        ->middleware('auth:admin')
        ->name('formation.edit')
        ->where("id","[0-9]+");

        Route::post('save-edit',[FormationController::class , 'saveEdit'])
        ->middleware('auth:admin')
        ->name('formation.edit.save');

        Route::get('see/{id}',[FormationController::class , 'voir'])
        ->middleware('auth:admin')
        ->name('formation.see')
        ->where("id","[0-9]+");

        Route::get('participant/{id}',[FormationController::class , 'participant'])
        ->middleware('auth:admin')
        ->name('formation.participant')
        ->where("id","[0-9]+");

    });


});

Route::prefix('admin/site-web')->name('adminSite.')->group(function(){

    Route::get('services/list',[PageserviceController::class, 'store'])
    ->middleware('auth:admin')
    ->name('services.list');

    Route::get('services/create',function(){ return view('adminView.site_web.services.create') ;})
    ->middleware('auth:admin')
    ->name('services.new');

    Route::post('services/save',[PageserviceController::class, 'enregistrer'])
    ->middleware('auth:admin')
    ->name('services.save');

    Route::get('services/edit/{id}',[PageserviceController::class, 'editer'])
    ->middleware('auth:admin')->where('id',"[1-9]+")
    ->name('services.edit');

    Route::post('services/save-edit',[PageserviceController::class, 'saveEdit'])
    ->middleware('auth:admin')
    ->name('services.edit.save');

    Route::get('/hidden-service/{id}', [PageserviceController::class, 'cacher'] )
    ->middleware('auth:admin')
    ->name('hide.service');

    Route::get('/show-service/{id}', [PageserviceController::class, 'montrer'] )
    ->middleware('auth:admin')
    ->name('show.service');

});


Route::post('/ajax-ac',[AjaxController::class , 'afficher_autorite']  )
->name('ajax-ac');

Route::post('/ajax-direction',[AjaxController::class , 'afficher_direction']  )
->name('afficher-direction');

?>
