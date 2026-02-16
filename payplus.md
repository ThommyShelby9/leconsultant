# 💳 Intégration PayPlus dans WhatsPay

## 📋 Table des matières

1. [Vue d'ensemble](#vue-densemble)
2. [Architecture](#architecture)
3. [Configuration](#configuration)
4. [Flux de dépôt](#flux-de-dépôt)
5. [Flux de retrait](#flux-de-retrait)
6. [Gestion des callbacks](#gestion-des-callbacks)
7. [Système de vérification automatique](#système-de-vérification-automatique)
8. [Exemples de code](#exemples-de-code)
9. [Tests et diagnostic](#tests-et-diagnostic)

---

## 🎯 Vue d'ensemble

PayPlus a été intégré dans WhatsPay comme **système de paiement mobile money** principal pour permettre aux utilisateurs de :
- **Recharger leur portefeuille** (dépôts via Mobile Money)
- **Retirer leurs gains** (retraits vers Mobile Money)

### Caractéristiques principales

- ✅ Support de plusieurs opérateurs Mobile Money (MTN, Moov, etc.)
- ✅ API officielle PayPlus avec authentification sécurisée
- ✅ Gestion des callbacks pour notification de paiement
- ✅ Système de vérification automatique des transactions en attente
- ✅ Historique complet des transactions
- ✅ Support des dépôts et retraits

---

## 🏗️ Architecture

### Structure du système

```
┌─────────────────────────────────────────────────────────────────┐
│                         Frontend (Views)                         │
│  - annonceur/wallet/index.blade.php (Interface portefeuille)    │
└────────────────────────────┬────────────────────────────────────┘
                             │
┌────────────────────────────▼────────────────────────────────────┐
│                    Controllers (HTTP Layer)                      │
│  - WalletController: Gestion du portefeuille utilisateur        │
│  - PaymentCallbackController: Traitement des callbacks PayPlus  │
└────────────────────────────┬────────────────────────────────────┘
                             │
┌────────────────────────────▼────────────────────────────────────┐
│                     Services (Business Logic)                    │
│  - PaymentService: Communication avec l'API PayPlus            │
│  - WalletService: Gestion du solde et transactions wallet      │
└────────────────────────────┬────────────────────────────────────┘
                             │
┌────────────────────────────▼────────────────────────────────────┐
│                      Models (Data Layer)                         │
│  - PaymentTransaction: Transactions avec PayPlus                │
│  - Wallet: Portefeuille utilisateur                             │
│  - WalletTransaction: Historique des mouvements                 │
└────────────────────────────┬────────────────────────────────────┘
                             │
┌────────────────────────────▼────────────────────────────────────┐
│                    API PayPlus (Externe)                         │
│  - Endpoints dépôt, retrait, vérification de statut            │
└─────────────────────────────────────────────────────────────────┘
```

### Fichiers principaux

| Fichier | Rôle |
|---------|------|
| `app/Services/PaymentService.php` | Service principal pour l'API PayPlus |
| `app/Http/Controllers/Web/WalletController.php` | Gestion du portefeuille utilisateur |
| `app/Http/Controllers/Web/PaymentCallbackController.php` | Traitement des callbacks PayPlus |
| `app/Models/PaymentTransaction.php` | Modèle des transactions de paiement |
| `config/payplus.php` | Configuration PayPlus |
| `routes/payment.php` | Routes pour les callbacks |
| `app/Console/Commands/CheckPendingTransactions.php` | Commande de vérification automatique |

---

## ⚙️ Configuration

### 1. Fichier de configuration `config/payplus.php`

```php
return [
    // URL de base de l'API PayPlus
    'base_url' => env('PAYPLUS_BASE_URL', 'https://app.payplus.africa'),

    // Identifiants API
    'api_key' => env('PAYPLUS_API_KEY', 'VOTRE_API_KEY'),
    'api_token' => env('PAYPLUS_API_TOKEN', 'VOTRE_TOKEN_JWT'),

    // Informations du marchand
    'store' => [
        'name' => env('PAYPLUS_STORE_NAME', 'WhatsPAY'),
        'website_url' => env('APP_URL', 'https://whatspay.com'),
    ],

    // Limites de paiement (en FCFA)
    'limits' => [
        'deposit' => [
            'min' => env('PAYPLUS_MIN_DEPOSIT', 1),
            'max' => env('PAYPLUS_MAX_DEPOSIT', 1000000),
        ],
        'withdrawal' => [
            'min' => env('PAYPLUS_MIN_WITHDRAWAL', 1),
            'max' => env('PAYPLUS_MAX_WITHDRAWAL', 500000),
        ],
    ],

    // URLs de callback
    'callbacks' => [
        'deposit_success' => env('APP_URL') . '/payment/callback/{transaction}',
        'withdrawal_success' => env('APP_URL') . '/payment/callback/withdrawal/{transaction}',
        'return_url' => env('APP_URL') . '/announcer/wallet?status=success',
        'cancel_url' => env('APP_URL') . '/announcer/wallet?status=cancelled',
    ],
];
```

### 2. Variables d'environnement (`.env`)

```bash
# Configuration PayPlus
PAYPLUS_BASE_URL=https://app.payplus.africa
PAYPLUS_API_KEY=votre_api_key
PAYPLUS_API_TOKEN=votre_api_token_jwt
PAYPLUS_STORE_NAME=WhatsPAY

# Limites de paiement
PAYPLUS_MIN_DEPOSIT=1
PAYPLUS_MAX_DEPOSIT=1000000
PAYPLUS_MIN_WITHDRAWAL=1
PAYPLUS_MAX_WITHDRAWAL=500000
```

### 3. Routes définies

```php
// routes/payment.php

// Callback pour dépôts (GET et POST pour compatibilité)
Route::match(['get', 'post'], 'callback/{transaction}',
    [PaymentCallbackController::class, 'handleDepositCallback'])
    ->name('payment.callback');

// Callback pour retraits
Route::match(['get', 'post'], 'callback/withdrawal/{transaction}',
    [PaymentCallbackController::class, 'handleWithdrawalCallback'])
    ->name('payment.callback.withdrawal');

// Vérification du statut
Route::get('status/{transaction}',
    [PaymentCallbackController::class, 'checkStatus'])
    ->name('payment.status');

// Endpoint de test
Route::get('callback/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'Callback endpoint accessible',
        'timestamp' => now()->toDateTimeString(),
    ]);
})->name('payment.callback.test');
```

---

## 💰 Flux de dépôt

### Schéma du flux

```
┌──────────┐        ┌──────────────┐       ┌──────────────┐       ┌──────────┐
│  Client  │───1───▶│ WhatsPay API │──2───▶│  PayPlus API │──3───▶│ Opérateur│
│ (Mobile) │        │   (Laravel)  │       │              │       │  Mobile  │
└──────────┘        └──────────────┘       └──────────────┘       └──────────┘
     ▲                     │                      │                     │
     │                     │                      │                     │
     └─────6. Wallet───────┴──────5. Callback────┴──────4. USSD────────┘
            crédité
```

### Étape 1 : Initiation du dépôt

**Fichier :** `app/Http/Controllers/Web/WalletController.php`

```php
public function addFunds(Request $request)
{
    // Validation
    $request->validate([
        'payment_method' => 'required|string',
        'amount' => 'required|numeric|min:1|max:1000000',
        'phone' => 'required|string|regex:/^[0-9+]{8,15}$/',
    ]);

    $userId = $request->session()->get('userid');
    $phone = preg_replace('/[^0-9+]/', '', $request->input('phone'));

    // Initier le dépôt via PayPlus
    $result = $this->paymentService->initiateDeposit(
        $userId,
        $request->input('amount'),
        $phone,
        true // useRedirect = true (flow avec redirection)
    );

    if ($result['success']) {
        // Rediriger vers la page PayPlus
        return redirect()->away($result['redirect_url']);
    }
}
```

### Étape 2 : Appel à l'API PayPlus

**Fichier :** `app/Services/PaymentService.php`

```php
public function initiateDeposit($userId, $amount, $customerPhone, $useRedirect = true)
{
    // 1. Créer une transaction en BDD
    $transactionId = $this->getId();
    $externalId = 'DEP-' . time() . '-' . substr($transactionId, 0, 8);

    $paymentTransaction = PaymentTransaction::create([
        'id' => $transactionId,
        'user_id' => $userId,
        'amount' => $amount,
        'currency' => 'XOF',
        'status' => 'PENDING',
        'reference' => $externalId,
        'expires_at' => Carbon::now()->addHour(),
    ]);

    // 2. Formater le numéro de téléphone (ajouter indicatif pays)
    $cleanPhone = preg_replace('/[^0-9]/', '', $customerPhone);
    if (!preg_match('/^(22[0-9]|23[0-9])/', $cleanPhone)) {
        $cleanPhone = '229' . $cleanPhone; // Ajouter 229 pour Bénin
    }

    // 3. Préparer le payload selon la documentation PayPlus
    $payload = [
        'commande' => [
            'invoice' => [
                'items' => [
                    [
                        'name' => 'Rechargement compte WhatsPAY',
                        'quantity' => 1,
                        'unit_price' => $amount,
                        'total_price' => $amount
                    ]
                ],
                'total_amount' => $amount,
                'devise' => 'XOF',
                'customer' => $cleanPhone,
                'customer_firstname' => $user->firstname ?? 'Client',
                'customer_lastname' => $user->lastname ?? 'WhatsPAY',
                'customer_email' => $user->email ?? 'client@whatspay.africa',
                'external_id' => $externalId,
                'network' => '' // Laisser vide pour afficher tous les opérateurs
            ],
            'store' => [
                'name' => 'WhatsPAY',
                'website_url' => config('app.url')
            ],
            'actions' => [
                'cancel_url' => route('announcer.wallet') . '?status=cancelled',
                'return_url' => route('announcer.wallet') . '?status=success',
                'callback_url' => route('payment.callback', ['transaction' => $transactionId]),
                'callback_url_method' => 'post_json'
            ],
            'custom_data' => [
                'transaction_id' => $transactionId,
                'user_id' => $userId,
            ]
        ]
    ];

    // 4. Envoyer la requête à PayPlus
    $endpoint = '/pay/v01/redirect/checkout-invoice/create';
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $this->payPlusApiToken,
        'Apikey' => $this->payPlusApiKey
    ];

    $response = Http::timeout(30)
        ->withHeaders($headers)
        ->post($this->payPlusBaseUrl . $endpoint, $payload);

    $responseData = $response->json();

    // 5. Vérifier la réponse
    if (isset($responseData['response_code']) && $responseData['response_code'] === '00') {
        // Succès - Retourner l'URL de redirection
        return [
            'success' => true,
            'message' => 'Redirection vers la passerelle de paiement',
            'redirect_url' => $responseData['response_text'],
            'transaction_id' => $transactionId,
            'token' => $responseData['token'] ?? null,
        ];
    } else {
        // Échec
        return [
            'success' => false,
            'message' => $responseData['description'] ?? 'Erreur lors de l\'initialisation'
        ];
    }
}
```

### Étape 3 : Page de paiement PayPlus

L'utilisateur est redirigé vers la page PayPlus où il peut :
- Choisir son opérateur mobile money (MTN, Moov, etc.)
- Confirmer le paiement via code USSD sur son téléphone

### Étape 4 : Callback de confirmation

**Fichier :** `app/Http/Controllers/Web/PaymentCallbackController.php`

```php
public function handleDepositCallback(Request $request, $transactionId)
{
    Log::info('PayPlus deposit callback received', [
        'transaction_id' => $transactionId,
        'data' => $request->all()
    ]);

    // Traiter le callback
    $success = $this->paymentService->processDepositCallback(
        $transactionId,
        $request->all()
    );

    if ($success) {
        return response()->json([
            'status' => 'success',
            'message' => 'Callback processed successfully'
        ], 200);
    }
}
```

**Fichier :** `app/Services/PaymentService.php`

```php
public function processDepositCallback($transactionId, $data)
{
    $transaction = PaymentTransaction::find($transactionId);

    // Vérifier le statut du paiement
    if (isset($data['description']) && $data['description'] === 'completed') {
        // Paiement réussi
        $transaction->update([
            'status' => 'COMPLETED',
            'completed_at' => Carbon::now(),
            'gateway_response' => json_encode($data)
        ]);

        // Créditer le wallet de l'utilisateur
        $this->walletService->addFunds(
            $transaction->user_id,
            $transaction->amount,
            $transaction->id,
            'Dépôt PayPlus - ' . $transaction->reference
        );

        Log::info('✅ Deposit completed', [
            'transaction_id' => $transactionId,
            'amount' => $transaction->amount
        ]);

        return true;
    } else {
        // Paiement échoué
        $transaction->update(['status' => 'FAILED']);
        return false;
    }
}
```

### Exemple complet de dépôt

```php
// 1. L'utilisateur remplit le formulaire
POST /announcer/wallet/add-funds
{
    "amount": 5000,
    "phone": "97000000",
    "payment_method": "mobile_money"
}

// 2. WhatsPay appelle PayPlus
POST https://app.payplus.africa/pay/v01/redirect/checkout-invoice/create
{
    "commande": {
        "invoice": {
            "total_amount": 5000,
            "customer": "22997000000",
            ...
        }
    }
}

// 3. PayPlus retourne une URL de redirection
{
    "response_code": "00",
    "response_text": "https://app.payplus.africa/checkout/abc123",
    "token": "xyz789"
}

// 4. Utilisateur redirigé et paie via Mobile Money

// 5. PayPlus envoie un callback
POST https://whatspay.com/payment/callback/uuid-transaction-id
{
    "response_code": "00",
    "description": "completed",
    "transaction_id": "DEP-1637895612-abc",
    "amount": 5000
}

// 6. WhatsPay crédite le wallet
✅ Wallet de l'utilisateur crédité de 5000 FCFA
```

---

## 💸 Flux de retrait

### Schéma du flux

```
┌──────────┐        ┌──────────────┐       ┌──────────────┐       ┌──────────┐
│Influenceur│───1───▶│ WhatsPay API │──2───▶│  PayPlus API │──3───▶│ Opérateur│
│ (demande)│        │   (Laravel)  │       │              │       │  Mobile  │
└──────────┘        └──────────────┘       └──────────────┘       └──────────┘
     │                     │                      │                     │
     │                     │                      │                     │
     └─────6. Fonds───────┴──────5. Callback────┴──────4. Envoi────────┘
            reçus                                        Mobile Money
```

### Initiation du retrait

**Fichier :** `app/Services/PaymentService.php`

```php
public function initiateWithdrawal($userId, $amount, $customerPhone, $useInternalWallet = false)
{
    // 1. Vérifier le solde disponible
    $balance = $this->walletService->getBalance($userId);
    if ($balance < $amount) {
        return [
            'success' => false,
            'message' => 'Solde insuffisant'
        ];
    }

    // 2. Créer une transaction en BDD
    $transactionId = $this->getId();
    $externalId = 'WTH-' . time() . '-' . substr($transactionId, 0, 8);

    PaymentTransaction::create([
        'id' => $transactionId,
        'user_id' => $userId,
        'amount' => -$amount, // Négatif pour retrait
        'currency' => 'XOF',
        'status' => 'PENDING',
        'reference' => $externalId,
    ]);

    // 3. Formater le numéro de téléphone
    $cleanPhone = preg_replace('/[^0-9]/', '', $customerPhone);
    if (!preg_match('/^(22[0-9])/', $cleanPhone)) {
        $cleanPhone = '229' . $cleanPhone;
    }

    // 4. Préparer le payload
    $payload = [
        'commande' => [
            'amount' => (int) $amount,
            'customer' => $cleanPhone,
            'custom_data' => [
                'transaction_id' => $transactionId,
                'user_id' => $userId,
            ],
            'callback_url' => route('payment.callback.withdrawal', ['transaction' => $transactionId]),
            'callback_url_method' => 'post_json',
            'external_id' => $externalId,
            'network' => ''
        ]
    ];

    // 5. Appeler l'API PayPlus
    $endpoint = '/pay/v01/straight/payout';
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $this->payPlusApiToken,
        'Apikey' => $this->payPlusApiKey
    ];

    $response = Http::timeout(30)
        ->withHeaders($headers)
        ->post($this->payPlusBaseUrl . $endpoint, $payload);

    $responseData = $response->json();

    // 6. Vérifier la réponse
    if (isset($responseData['response_code']) && $responseData['response_code'] === '00') {
        // Déduire immédiatement du wallet
        $this->walletService->deductFunds(
            $userId,
            $amount,
            'Retrait vers ' . $customerPhone,
            $transactionId
        );

        return [
            'success' => true,
            'message' => 'Demande de retrait initiée',
            'transaction_id' => $transactionId,
        ];
    }

    return [
        'success' => false,
        'message' => $responseData['description'] ?? 'Erreur lors du retrait'
    ];
}
```

### Callback de retrait

```php
public function processWithdrawalCallback($transactionId, $data)
{
    $transaction = PaymentTransaction::find($transactionId);

    if (isset($data['description']) && $data['description'] === 'completed') {
        // Retrait réussi
        $transaction->update([
            'status' => 'COMPLETED',
            'completed_at' => Carbon::now()
        ]);

        Log::info('✅ Withdrawal completed', [
            'transaction_id' => $transactionId,
            'amount' => abs($transaction->amount)
        ]);

        return true;
    } else {
        // Retrait échoué - Rembourser le wallet
        $transaction->update(['status' => 'FAILED']);

        $this->walletService->addFunds(
            $transaction->user_id,
            abs($transaction->amount),
            $transaction->id,
            'Remboursement retrait échoué - ' . $transaction->reference
        );

        Log::info('Wallet refunded for failed withdrawal', [
            'transaction_id' => $transactionId
        ]);

        return false;
    }
}
```

---

## 🔔 Gestion des callbacks

### Problématique

Parfois, les callbacks de PayPlus ne parviennent pas au serveur WhatsPay pour diverses raisons :
- Problème réseau
- Serveur temporairement inaccessible
- Erreur de configuration DNS/Firewall
- Timeout

**Conséquence :** L'utilisateur a payé mais son wallet n'est jamais crédité.

### Solution : Vérification automatique

**Commande artisan :** `CheckPendingTransactions`

Cette commande s'exécute automatiquement **toutes les 5 minutes** via le scheduler Laravel.

**Fichier :** `app/Console/Commands/CheckPendingTransactions.php`

```php
public function handle()
{
    // 1. Récupérer les transactions en attente depuis > 5 minutes
    $pendingTransactions = PaymentTransaction::where('status', 'PENDING')
        ->where('created_at', '<=', Carbon::now()->subMinutes(5))
        ->where('expires_at', '>', Carbon::now())
        ->limit(50)
        ->get();

    foreach ($pendingTransactions as $transaction) {
        // 2. Vérifier le statut avec PayPlus API
        $statusCheck = $this->paymentService->checkTransactionStatus($transaction->id);

        if ($statusCheck['success']) {
            $payPlusStatus = $statusCheck['status'];

            if ($payPlusStatus === 'completed') {
                // 3. La transaction est complétée chez PayPlus mais pas chez nous
                // => Traiter le callback manuellement

                $callbackData = [
                    'response_code' => '00',
                    'description' => 'completed',
                    'transaction_id' => $transaction->reference,
                    'amount' => abs($transaction->amount),
                    'auto_checked' => true,
                ];

                $payload = json_decode($transaction->payload, true);
                $type = $payload['type'] ?? 'deposit';

                if ($type === 'withdrawal') {
                    $this->paymentService->processWithdrawalCallback(
                        $transaction->id,
                        $callbackData
                    );
                } else {
                    $this->paymentService->processDepositCallback(
                        $transaction->id,
                        $callbackData
                    );
                }

                Log::info('✅ Auto-completed pending transaction', [
                    'transaction_id' => $transaction->id,
                    'type' => $type
                ]);
            }

            if ($payPlusStatus === 'failed' || $payPlusStatus === 'notcompleted') {
                // Marquer comme échouée
                $transaction->update(['status' => 'FAILED']);
            }
        }
    }
}
```

### Vérification du statut avec PayPlus

```php
public function checkTransactionStatus($transactionId)
{
    $transaction = PaymentTransaction::find($transactionId);
    $gatewayResponse = json_decode($transaction->gateway_response, true);
    $payPlusToken = $gatewayResponse['token'] ?? null;

    // Déterminer l'endpoint selon le type
    $payload = json_decode($transaction->payload, true);
    $isWithdrawal = $payload['type'] === 'withdrawal';

    $endpoint = $isWithdrawal ?
        '/pay/v01/withdrawal/confirm' :
        '/pay/v01/redirect/checkout-invoice/confirm';

    $paramName = $isWithdrawal ? 'withdrawalToken' : 'invoiceToken';

    // Appeler l'API PayPlus
    $response = Http::timeout(15)
        ->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->payPlusApiToken,
            'Apikey' => $this->payPlusApiKey
        ])
        ->get($this->payPlusBaseUrl . $endpoint, [
            $paramName => $payPlusToken
        ]);

    if ($response->successful()) {
        $responseData = $response->json();
        $status = $responseData['description'] ?? 'unknown';
        // Status possibles: "pending", "completed", "notcompleted", "failed"

        return [
            'success' => true,
            'status' => $status,
            'response_code' => $responseData['response_code'] ?? 'N/A',
            'payplus_response' => $responseData,
        ];
    }

    return [
        'success' => false,
        'message' => 'Impossible de vérifier le statut'
    ];
}
```

### Programmation du scheduler

**Fichier :** `app/Console/Kernel.php`

```php
protected function schedule(Schedule $schedule)
{
    // Vérifier les transactions en attente toutes les 5 minutes
    $schedule->command('payments:check-pending')
        ->everyFiveMinutes()
        ->withoutOverlapping()
        ->appendOutputTo(storage_path('logs/check-pending-transactions.log'));
}
```

### Activation du scheduler (Production)

```bash
# Ajouter au crontab
* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1
```

---

## 💻 Exemples de code

### Exemple 1 : Effectuer un dépôt depuis le frontend

**Vue Blade :**

```html
<!-- annonceur/wallet/index.blade.php -->
<form action="{{ route('announcer.wallet.add-funds') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Montant (FCFA)</label>
        <input type="number" name="amount" class="form-control"
               min="1" max="1000000" required>
    </div>

    <div class="form-group">
        <label>Numéro de téléphone</label>
        <input type="text" name="phone" class="form-control"
               placeholder="Ex: 97000000" required>
        <small>Format: 8 à 15 chiffres</small>
    </div>

    <input type="hidden" name="payment_method" value="mobile_money">

    <button type="submit" class="btn btn-primary">
        Recharger mon compte
    </button>
</form>
```

### Exemple 2 : Effectuer un retrait

```php
// Route
Route::post('/wallet/withdraw', [WalletController::class, 'initiateWithdrawal'])
    ->name('wallet.withdraw');

// Controller
public function initiateWithdrawal(Request $request)
{
    $userId = $request->session()->get('userid');

    $request->validate([
        'amount' => 'required|numeric|min:1000|max:500000',
        'phone' => 'required|string|regex:/^[0-9]{8,15}$/',
    ]);

    $result = $this->paymentService->initiateWithdrawal(
        $userId,
        $request->input('amount'),
        $request->input('phone'),
        false // Direct mobile money
    );

    return response()->json($result);
}
```

### Exemple 3 : Vérifier le solde avant une opération

```php
use App\Services\WalletService;

class CampaignController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function createCampaign(Request $request)
    {
        $userId = $request->session()->get('userid');
        $campaignCost = $request->input('budget');

        // Vérifier le solde disponible
        $balance = $this->walletService->getBalance($userId);

        if ($balance < $campaignCost) {
            return redirect()->back()->with([
                'type' => 'danger',
                'message' => 'Solde insuffisant. Rechargez votre compte.'
            ]);
        }

        // Créer la campagne...
    }
}
```

### Exemple 4 : Historique des transactions

```php
// Controller
public function transactionHistory(Request $request)
{
    $userId = $request->session()->get('userid');

    // Récupérer les transactions paginées
    $transactions = $this->walletService->getPaginatedTransactions($userId, 25);

    // Statistiques
    $stats = $this->walletService->getTransactionStats($userId);

    return view('wallet.history', [
        'transactions' => $transactions,
        'stats' => $stats,
    ]);
}

// Vue
@foreach($transactions as $transaction)
    <tr>
        <td>{{ $transaction->reference }}</td>
        <td>{{ $transaction->amount }} FCFA</td>
        <td>
            <span class="badge badge-{{ $transaction->status === 'COMPLETED' ? 'success' : 'warning' }}">
                {{ $transaction->status }}
            </span>
        </td>
        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
    </tr>
@endforeach
```

---

## 🧪 Tests et diagnostic

### Script de test de dépôt

**Fichier :** `test_payplus_deposit.php`

```php
<?php
require __DIR__ . '/vendor/autoload.php';

// Charger l'environnement Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\PaymentService;
use App\Services\WalletService;

// Configuration test
$testUserId = '01b89be1-aa50-4720-a612-23f76cba0e60';
$testPhone = '22997000000'; // ⚠️ METTEZ VOTRE VRAI NUMÉRO ICI
$testAmount = 100;

echo "========================================\n";
echo "TEST DÉPÔT PAYPLUS\n";
echo "========================================\n\n";

echo "Configuration:\n";
echo "  - User ID: $testUserId\n";
echo "  - Téléphone: $testPhone\n";
echo "  - Montant: $testAmount FCFA\n\n";

// Tester la connexion
$walletService = app(WalletService::class);
$paymentService = app(PaymentService::class);

try {
    echo "🔄 Initiation du dépôt...\n";

    $result = $paymentService->initiateDeposit(
        $testUserId,
        $testAmount,
        $testPhone,
        true
    );

    if ($result['success']) {
        echo "\n✅ SUCCÈS!\n";
        echo "  - Transaction ID: " . $result['transaction_id'] . "\n";
        echo "  - Redirect URL: " . $result['redirect_url'] . "\n\n";
        echo "👉 Ouvrez cette URL dans votre navigateur:\n";
        echo "   " . $result['redirect_url'] . "\n\n";
    } else {
        echo "\n❌ ÉCHEC\n";
        echo "  - Message: " . $result['message'] . "\n\n";
    }

} catch (\Exception $e) {
    echo "\n❌ ERREUR CRITIQUE\n";
    echo "  - Message: " . $e->getMessage() . "\n";
    echo "  - Fichier: " . $e->getFile() . "\n";
    echo "  - Ligne: " . $e->getLine() . "\n\n";
}
```

**Exécution :**

```bash
php test_payplus_deposit.php
```

### Test du callback endpoint

```bash
# Test simple
curl https://app-dev.whatspay.africa/payment/callback/test

# Réponse attendue:
{
  "success": true,
  "message": "Callback endpoint accessible",
  "timestamp": "2025-11-20 16:30:00"
}
```

### Vérification manuelle des transactions

```bash
# Afficher les transactions en attente
php artisan tinker
>>> PaymentTransaction::where('status', 'PENDING')->get()

# Vérifier une transaction spécifique
>>> $transaction = PaymentTransaction::find('uuid-ici')
>>> $transaction->status
>>> json_decode($transaction->gateway_response, true)

# Exécuter manuellement la commande de vérification
php artisan payments:check-pending

# Voir les logs
tail -f storage/logs/laravel.log | grep -i payplus
tail -f storage/logs/check-pending-transactions.log
```

### Diagnostic des erreurs courantes

| Code erreur | Signification | Solution |
|-------------|---------------|----------|
| `01` | Transaction refusée | Vérifier les credentials, le numéro, l'opérateur activé |
| `400` | Données invalides | Vérifier le format du numéro et du montant |
| `401` | Authentification échouée | Vérifier API Key et Token dans `.env` |
| `404` | Endpoint non trouvé | Vérifier l'URL de base PayPlus |
| `Code14` | IP non autorisée (retrait) | Ajouter l'IP du serveur dans le dashboard PayPlus |

---

## 📚 Résumé

### Ce qui a été implémenté

✅ **Service de paiement complet** avec l'API officielle PayPlus
✅ **Gestion des dépôts** (recharges de portefeuille)
✅ **Gestion des retraits** (vers Mobile Money)
✅ **Système de callbacks** pour les notifications de paiement
✅ **Vérification automatique** des transactions en attente (toutes les 5 min)
✅ **Historique des transactions** pour chaque utilisateur
✅ **Scripts de diagnostic** pour tester et déboguer
✅ **Gestion des erreurs** et logs détaillés
✅ **Support multi-opérateurs** (MTN, Moov, etc.)

### Flux de données

```
Utilisateur → WalletController → PaymentService → API PayPlus → Opérateur Mobile Money
                     ↓                   ↓              ↓               ↓
              Base de données ← WalletService ← Callback ← Confirmation USSD
```

### Fichiers clés

1. **`config/payplus.php`** - Configuration centrale
2. **`app/Services/PaymentService.php`** - Logique PayPlus
3. **`app/Services/WalletService.php`** - Gestion du portefeuille
4. **`app/Http/Controllers/Web/WalletController.php`** - Interface utilisateur
5. **`app/Http/Controllers/Web/PaymentCallbackController.php`** - Callbacks
6. **`app/Console/Commands/CheckPendingTransactions.php`** - Vérification auto
7. **`routes/payment.php`** - Routes callbacks
8. **`app/Models/PaymentTransaction.php`** - Modèle de transaction

---

## 🚀 Pour aller plus loin

### Améliorations possibles

1. **Webhooks sécurisés** : Valider la signature des callbacks PayPlus
2. **Retry automatique** : Réessayer les paiements échoués
3. **Notifications** : Envoyer des SMS/emails de confirmation
4. **Dashboard analytics** : Statistiques des transactions
5. **Multi-devises** : Support d'autres devises que XOF
6. **Cashback/Promotions** : Système de récompenses

### Monitoring

```bash
# Surveiller les logs en temps réel
tail -f storage/logs/laravel.log | grep -E 'PayPlus|payment|deposit|withdrawal'

# Statistiques des transactions
php artisan tinker
>>> PaymentTransaction::where('status', 'COMPLETED')->whereDate('created_at', today())->count()
>>> PaymentTransaction::where('status', 'PENDING')->count()

# Vérifier le scheduler
php artisan schedule:list
```

---

**Documentation créée le 16 février 2026**
**Projet WhatsPay - Intégration PayPlus**
