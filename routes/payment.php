<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentCallbackController;

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
|
| Routes pour gérer les callbacks de PayPlus et les vérifications de statut
|
*/

// Page d'attente de confirmation de paiement
Route::get('waiting/{transaction}',
    [PaymentCallbackController::class, 'waitingPage'])
    ->name('payment.waiting');

// Callback pour les paiements (GET et POST pour compatibilité)
Route::match(['get', 'post'], 'callback/{type}/{transaction}',
    [PaymentCallbackController::class, 'handleCallback'])
    ->name('payment.callback');

// Vérification du statut d'une transaction
Route::get('status/{transaction}',
    [PaymentCallbackController::class, 'checkStatus'])
    ->name('payment.status');

// Endpoints de test pour vérifier l'accessibilité
Route::get('callback/test', [PaymentCallbackController::class, 'testCallback'])
    ->name('payment.callback.test');

Route::get('test-json', [PaymentCallbackController::class, 'testJson'])
    ->name('payment.test.json');
