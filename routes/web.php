<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\CategorieController;
use Illuminate\Support\Facades\Route;
use App\Providers\FortifyServiceProvider;

use App\Http\Controllers\user\PageController as PageController;
use App\Http\Controllers\user\AlerteController as AlerteController;
use App\Http\Controllers\user\OffreController as OffreController;
use App\Http\Controllers\user\CompteController as CompteController;
use App\Http\Controllers\user\AbonnementController as AbonnementController;

use App\Http\Controllers\user\FTController as FTController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/email',function(){ return view('component.emails.offreNotification');});

Route::get('/exemple',function(){ return view('component.testPDF');});

Route::get('/', [PageController::class, 'welcome'])
->name('welcome');

Route::post('/register', [UserController::class, 'create'])
    ->name('registration');


Route::group(['prefix'=>'register' , 'middleware'=>'verAuthGroup' ], function(){

    //Inscription des personnes physique
    Route::get('physique', function(){ return view('auth.registerPhysique'); })
    ->name('register.physique');

    //Inscription des personnes morales
    Route::get('morale', function(){ return view('auth.registerMoral'); })
    ->name('register.morale');

});

Route::get('abo', [AbonnementController::class , 'mesAbonnementsPage']);

Route::get('appels-d-offres', [PageController::class, 'lesOffres'])
    ->name('offre')->middleware('auth');


Route::get('nos-services', [PageController::class, 'lesServices'])
    ->name('pageService');

Route::get('les-formations', [PageController::class, 'lesFormations'])
    ->name('pageFormation');

Route::get('les-formations/{id}/{name}', [PageController::class, 'voirFormation'])
    ->name('formation.item');

Route::post('apels-doffres-filtres',[ OffreController::class, 'rechercher'])
    ->name('offre.recherche');

//Route::get('home', function(){ return view('userView.home'); })->middleware(['auth:web', 'verified']);

Route::middleware(['auth:web' ])->group(function() {

    Route::get('home', [PageController::class, 'welcome'] )
    ->name('home');

    Route::get('creation-alerte', [AlerteController::class, 'pageAlerte'] )
    ->name('alerte.page');

    Route::post('alerte/prendre/{type}', [AlerteController::class, 'alerteCreer'])
    ->name('alerte.subscription');

    Route::post('alerte/save', [AlerteController::class, 'alerte'])
    ->name('alerte.save');

    Route::get('/compte',[CompteController::class , 'account'])->name('moncompte');

    Route::get('/compte-modifier',[CompteController::class , 'editAccount'])
    ->name('moncompte.edit');

    Route::post('/compte',[CompteController::class , 'saveEdit'])
    ->name('save.edit.compte');


    Route::get('/picture-modifier',[CompteController::class , 'photo'])
    ->name('moncompte.photo');

    Route::post('/picture-modifier',[CompteController::class , 'savePhoto'])
    ->name('moncompte.photo.save');

    Route::get('/picture-delete',[CompteController::class , 'deletePhoto'])
    ->name('moncompte.photo.delete');


    Route::get('/description-modifier',[CompteController::class , 'surMoi'])
    ->name('moncompte.surmoi');

    Route::post('/description-save',[CompteController::class , 'surMoiSave'])
    ->name('moncompte.surMoi.save');

    Route::get('/create_alerte',[AlerteController::class , 'alertePage'])
    ->name('alerte');





    Route::get('/mes-abonnements',[AbonnementController::class , 'mesAbonnements'])
    ->name('mesAbonnements');


    Route::post('profitez-des-14jsrs-dessaie',[AbonnementController::class, 'essaieSubscription'] )
    ->name('pack.essaie');

    Route::post('stop-dessaie',[AbonnementController::class, 'EssaieStop'] )
    ->name('essaie.stop');


    Route::get('subscription/{type}', [AbonnementController::class, 'packSubscription'])
    ->name('pack.payant');



    Route::get('/ticket-formation/{id}',[ FTController::class, 'ticketFormation'])
    ->name('ticket.formation');

    Route::post('/telecharger-ticket',[FTController::class, 'DownTicket'])
    ->name('DownTicket');

    Route::get('/mes-formations',[FTController::class , 'mesFormations'])
    ->name('mesformations');

    //Voir les pdf
    Route::get('voir-fichier/{file}', [OffreController::class, 'voirFichier'])
    ->name('voirFichier');



    Route::get('/settings',[CompteController::class , 'mesSettings'])
    ->name('mesSetting');


    Route::post('/save-transaction', [AbonnementController::class, 'handleCallback'])->name('save-transaction');


    Route::delete('admin/delete/{id}', [CategorieController::class, 'delete'])->name('admin.ca.delete');

    Route::get('/offre/details/{id}', [OffreController::class, 'getOfferDetails']);


});

Route::get('/email/verify/{email}', [CreateNewUser::class, 'verify'])->name('email_verified');


require __DIR__.'/admin.php';



    /*Route::middleware('is_admin')->prefix('admin')->group(function() {
            Route::get(...)
    });

    Route::middleware('is_user')->prefix('user')->group(function() {
        Route::get(...)
    });*/
