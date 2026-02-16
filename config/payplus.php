<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayPlus Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour l'intégration de PayPlus comme moyen de paiement
    | pour les abonnements et formations de LeConsultant.
    |
    */

    // URL de base de l'API PayPlus
    'base_url' => env('PAYPLUS_BASE_URL', 'https://app.payplus.africa'),

    // Identifiants API
    'api_key' => env('PAYPLUS_API_KEY', ''),
    'api_token' => env('PAYPLUS_API_TOKEN', ''),

    // Informations du marchand
    'store' => [
        'name' => env('PAYPLUS_STORE_NAME', 'LeConsultant'),
        'website_url' => env('APP_URL', 'https://leconsultant.bj'),
    ],

    // Limites de paiement (en FCFA)
    'limits' => [
        'subscription' => [
            'min' => env('PAYPLUS_MIN_SUBSCRIPTION', 1000),
            'max' => env('PAYPLUS_MAX_SUBSCRIPTION', 100000),
        ],
        'formation' => [
            'min' => env('PAYPLUS_MIN_FORMATION', 1000),
            'max' => env('PAYPLUS_MAX_FORMATION', 500000),
        ],
    ],

    // URLs de callback
    'callbacks' => [
        'subscription_success' => env('APP_URL') . '/payment/callback/subscription/{transaction}',
        'formation_success' => env('APP_URL') . '/payment/callback/formation/{transaction}',
        'return_url' => env('APP_URL') . '/payment/waiting/{transaction}',
        'cancel_url' => env('APP_URL') . '/compte?payment=cancelled',
    ],

    // Montants des packs (en FCFA)
    'packs' => [
        'essai' => 0,
        'mensuel' => 1490,
        '3_mois' => 4000,
        '6_mois' => 7500,
        '12_mois' => 14000,
    ],
];
