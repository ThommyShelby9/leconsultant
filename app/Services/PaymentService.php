<?php

namespace App\Services;

use App\Models\PaymentTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService
{
    protected $payPlusBaseUrl;
    protected $payPlusApiKey;
    protected $payPlusApiToken;

    public function __construct()
    {
        $this->payPlusBaseUrl = config('payplus.base_url');
        $this->payPlusApiKey = config('payplus.api_key');
        $this->payPlusApiToken = config('payplus.api_token');
    }

    /**
     * Initier un paiement pour un abonnement
     *
     * @param int $userId
     * @param float $amount
     * @param string $customerPhone
     * @param int|null $packId
     * @return array
     */
    public function initiateSubscriptionPayment($userId, $amount, $customerPhone, $packId = null)
    {
        return $this->initiatePayment($userId, $amount, $customerPhone, 'subscription', $packId);
    }

    /**
     * Initier un paiement pour une formation
     *
     * @param int $userId
     * @param float $amount
     * @param string $customerPhone
     * @param int|null $formationId
     * @return array
     */
    public function initiateFormationPayment($userId, $amount, $customerPhone, $formationId = null)
    {
        return $this->initiatePayment($userId, $amount, $customerPhone, 'formation', $formationId);
    }

    /**
     * Initier un paiement (méthode générique)
     *
     * @param int $userId
     * @param float $amount
     * @param string $customerPhone
     * @param string $type
     * @param int|null $relatedId
     * @return array
     */
    protected function initiatePayment($userId, $amount, $customerPhone, $type, $relatedId = null)
    {
        try {
            // 1. Récupérer l'utilisateur
            $user = User::find($userId);
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Utilisateur introuvable'
                ];
            }

            // 2. Créer une transaction en BDD
            $transactionId = (string) Str::uuid();
            $externalId = strtoupper($type[0]) . '-' . time() . '-' . substr($transactionId, 0, 8);

            $paymentTransaction = PaymentTransaction::create([
                'id' => $transactionId,
                'user_id' => $userId,
                'type' => $type,
                'amount' => $amount,
                'currency' => 'XOF',
                'status' => 'PENDING',
                'reference' => $externalId,
                'related_id' => $relatedId,
                'customer_phone' => $customerPhone,
                'expires_at' => Carbon::now()->addHour(),
            ]);

            // 3. Formater le numéro de téléphone (ajouter indicatif pays)
            $cleanPhone = preg_replace('/[^0-9]/', '', $customerPhone);
            if (!preg_match('/^(22[0-9]|23[0-9])/', $cleanPhone)) {
                $cleanPhone = '229' . $cleanPhone; // Ajouter 229 pour Bénin
            }

            // 4. Préparer le payload selon la documentation PayPlus
            $itemName = $type === 'subscription' ? 'Abonnement LeConsultant' : 'Formation LeConsultant';

            $payload = [
                'commande' => [
                    'invoice' => [
                        'items' => [
                            [
                                'name' => $itemName,
                                'quantity' => 1,
                                'unit_price' => $amount,
                                'total_price' => $amount
                            ]
                        ],
                        'total_amount' => $amount,
                        'devise' => 'XOF',
                        'customer' => $cleanPhone,
                        'customer_firstname' => $user->firstname ?? $user->nom ?? 'Client',
                        'customer_lastname' => $user->lastname ?? $user->prenom ?? 'LeConsultant',
                        'customer_email' => $user->email ?? 'client@leconsultant.bj',
                        'external_id' => $externalId,
                        'network' => '' // Laisser vide pour afficher tous les opérateurs
                    ],
                    'store' => [
                        'name' => config('payplus.store.name'),
                        'website_url' => config('payplus.store.website_url')
                    ],
                    'actions' => [
                        'cancel_url' => config('payplus.callbacks.cancel_url'),
                        'return_url' => route('payment.waiting', ['transaction' => $transactionId]),
                        'callback_url' => route('payment.callback', ['type' => $type, 'transaction' => $transactionId]),
                        'callback_url_method' => 'post_json'
                    ],
                    'custom_data' => [
                        'transaction_id' => $transactionId,
                        'user_id' => $userId,
                        'type' => $type,
                        'related_id' => $relatedId,
                    ]
                ]
            ];

            // 5. Enregistrer le payload
            $paymentTransaction->update(['payload' => json_encode(['type' => $type, 'data' => $payload])]);

            // 6. Envoyer la requête à PayPlus
            $endpoint = '/pay/v01/redirect/checkout-invoice/create';
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->payPlusApiToken,
                'Apikey' => $this->payPlusApiKey
            ];

            Log::info('PayPlus Request', [
                'endpoint' => $this->payPlusBaseUrl . $endpoint,
                'transaction_id' => $transactionId,
                'amount' => $amount
            ]);

            $response = Http::timeout(30)
                ->withHeaders($headers)
                ->post($this->payPlusBaseUrl . $endpoint, $payload);

            $responseData = $response->json();

            Log::info('PayPlus Response', [
                'transaction_id' => $transactionId,
                'response' => $responseData
            ]);

            // 7. Vérifier la réponse
            if (isset($responseData['response_code']) && $responseData['response_code'] === '00') {
                // Succès - Mettre à jour la transaction avec le token
                $paymentTransaction->update([
                    'payplus_token' => $responseData['token'] ?? null,
                    'gateway_response' => json_encode($responseData)
                ]);

                return [
                    'success' => true,
                    'message' => 'Redirection vers la passerelle de paiement',
                    'redirect_url' => $responseData['response_text'],
                    'transaction_id' => $transactionId,
                    'token' => $responseData['token'] ?? null,
                ];
            } else {
                // Échec
                $paymentTransaction->markAsFailed();

                return [
                    'success' => false,
                    'message' => $responseData['description'] ?? 'Erreur lors de l\'initialisation du paiement'
                ];
            }

        } catch (\Exception $e) {
            Log::error('PayPlus initiation error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'initialisation du paiement'
            ];
        }
    }

    /**
     * Traiter le callback de paiement
     *
     * @param string $transactionId
     * @param array $data
     * @return bool
     */
    public function processPaymentCallback($transactionId, $data)
    {
        try {
            Log::info('🔄 Processing payment callback', [
                'transaction_id' => $transactionId,
                'callback_data' => $data
            ]);

            $transaction = PaymentTransaction::find($transactionId);

            if (!$transaction) {
                Log::error('❌ Transaction not found in callback', [
                    'transaction_id' => $transactionId
                ]);
                return false;
            }

            Log::info('📦 Transaction found', [
                'transaction_id' => $transactionId,
                'current_status' => $transaction->status,
                'amount' => $transaction->amount,
                'user_id' => $transaction->user_id,
                'type' => $transaction->type
            ]);

            // Vérifier le statut du paiement
            if (isset($data['description']) && $data['description'] === 'completed') {
                Log::info('💰 Payment marked as completed by PayPlus', [
                    'transaction_id' => $transactionId,
                    'description' => $data['description'] ?? 'N/A',
                    'response_code' => $data['response_code'] ?? 'N/A'
                ]);

                // Paiement réussi
                $transaction->update([
                    'status' => 'COMPLETED',
                    'completed_at' => Carbon::now(),
                    'gateway_response' => json_encode($data)
                ]);

                Log::info('✅ Payment completed and saved to DB', [
                    'transaction_id' => $transactionId,
                    'amount' => $transaction->amount,
                    'type' => $transaction->type,
                    'user_id' => $transaction->user_id,
                    'completed_at' => Carbon::now()->toDateTimeString()
                ]);

                return true;
            } else {
                // Paiement échoué
                Log::warning('⚠️ Payment NOT completed', [
                    'transaction_id' => $transactionId,
                    'description' => $data['description'] ?? 'N/A',
                    'response_code' => $data['response_code'] ?? 'N/A',
                    'full_data' => $data
                ]);

                $transaction->markAsFailed();

                Log::info('❌ Payment marked as failed', [
                    'transaction_id' => $transactionId
                ]);

                return false;
            }

        } catch (\Exception $e) {
            Log::error('❌ Callback processing error', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }

    /**
     * Vérifier le statut d'une transaction auprès de PayPlus
     *
     * @param string $transactionId
     * @return array
     */
    public function checkTransactionStatus($transactionId)
    {
        try {
            $transaction = PaymentTransaction::find($transactionId);

            if (!$transaction) {
                return [
                    'success' => false,
                    'message' => 'Transaction not found'
                ];
            }

            $gatewayResponse = json_decode($transaction->gateway_response, true);
            $payPlusToken = $gatewayResponse['token'] ?? $transaction->payplus_token;

            if (!$payPlusToken) {
                return [
                    'success' => false,
                    'message' => 'Token PayPlus introuvable'
                ];
            }

            // Appeler l'API PayPlus pour vérifier le statut
            $endpoint = '/pay/v01/redirect/checkout-invoice/confirm';
            $url = $this->payPlusBaseUrl . $endpoint . '?invoiceToken=' . $payPlusToken;

            Log::info('🔍 Checking PayPlus transaction status', [
                'url' => $url,
                'token' => substr($payPlusToken, 0, 20) . '...'
            ]);

            $response = Http::timeout(15)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->payPlusApiToken,
                    'Apikey' => $this->payPlusApiKey
                ])
                ->get($url);

            Log::info('📥 PayPlus status response', [
                'status_code' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                $status = $responseData['description'] ?? 'unknown';

                Log::info('✅ PayPlus status check successful', [
                    'status' => $status,
                    'response_code' => $responseData['response_code'] ?? 'N/A'
                ]);

                return [
                    'success' => true,
                    'status' => $status,
                    'response_code' => $responseData['response_code'] ?? 'N/A',
                    'payplus_response' => $responseData,
                ];
            }

            Log::warning('⚠️ PayPlus status check failed', [
                'status_code' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'message' => 'Impossible de vérifier le statut',
                'http_status' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Status check error', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors de la vérification du statut'
            ];
        }
    }
}
