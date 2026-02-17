<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\Abonnement;
use App\Models\Formationticket;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentCallbackController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Gérer le callback de paiement (abonnements et formations)
     */
    public function handleCallback(Request $request, $type, $transactionId)
    {
        Log::info('🔔 PayPlus callback received', [
            'type' => $type,
            'transaction_id' => $transactionId,
            'data' => $request->all(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Traiter le callback
        $success = $this->paymentService->processPaymentCallback(
            $transactionId,
            $request->all()
        );

        if ($success) {
            Log::info('✅ Callback processed successfully', [
                'transaction_id' => $transactionId
            ]);

            // Récupérer la transaction
            $transaction = PaymentTransaction::find($transactionId);

            if ($transaction && $transaction->isCompleted()) {
                Log::info('🎯 Transaction completed, activating service', [
                    'transaction_id' => $transactionId,
                    'type' => $type
                ]);

                // Activer l'abonnement ou la formation selon le type
                if ($type === 'subscription') {
                    $this->activateSubscription($transaction);
                } elseif ($type === 'formation') {
                    $this->activateFormation($transaction);
                }
            } else {
                Log::warning('⚠️ Transaction not completed after callback', [
                    'transaction_id' => $transactionId,
                    'status' => $transaction ? $transaction->status : 'NOT_FOUND'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Callback processed successfully'
            ], 200);
        }

        Log::error('❌ Callback processing failed', [
            'transaction_id' => $transactionId
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Callback processing failed'
        ], 400);
    }

    /**
     * Activer un abonnement après paiement réussi
     */
    protected function activateSubscription(PaymentTransaction $transaction)
    {
        try {
            $packId = $transaction->related_id;
            $userId = $transaction->user_id;

            Log::info('🚀 Starting subscription activation', [
                'transaction_id' => $transaction->id,
                'user_id' => $userId,
                'pack_id' => $packId,
                'amount' => $transaction->amount
            ]);

            // Calculer les dates selon le pack
            $dateDebut = Carbon::now();
            $dateFin = $this->calculateSubscriptionEnd($packId);

            Log::info('📅 Subscription dates calculated', [
                'dateDebut' => $dateDebut->toDateTimeString(),
                'dateFin' => $dateFin->toDateTimeString(),
                'pack_id' => $packId
            ]);

            // Créer ou mettre à jour l'abonnement
            $abonnement = Abonnement::create([
                'idUser' => $userId,
                'idPack' => $packId,
                'montant' => $transaction->amount,
                'dateDebut' => $dateDebut,
                'dateFin' => $dateFin,
                'stop' => false,
                'transaction_id' => $transaction->id,
            ]);

            Log::info('✅ Subscription activated successfully', [
                'transaction_id' => $transaction->id,
                'user_id' => $userId,
                'pack_id' => $packId,
                'abonnement_id' => $abonnement->id ?? 'N/A',
                'dateDebut' => $dateDebut->toDateString(),
                'dateFin' => $dateFin->toDateString()
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Subscription activation failed', [
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id ?? 'N/A',
                'pack_id' => $transaction->related_id ?? 'N/A',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Activer une formation après paiement réussi
     */
    protected function activateFormation(PaymentTransaction $transaction)
    {
        try {
            $formationId = $transaction->related_id;
            $userId = $transaction->user_id;

            // Créer le ticket de formation
            Formationticket::create([
                'user_id' => $userId,
                'formation_id' => $formationId,
                'transaction_id' => $transaction->id,
                'status' => 'active',
            ]);

            Log::info('✅ Formation ticket created', [
                'transaction_id' => $transaction->id,
                'user_id' => $userId,
                'formation_id' => $formationId
            ]);

        } catch (\Exception $e) {
            Log::error('Formation activation failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Calculer la date de fin d'abonnement selon le pack
     */
    protected function calculateSubscriptionEnd($packId)
    {
        // Mapper les IDs de pack avec les durées
        $durations = [
            10 => 1,  // 1 mois
            11 => 3,  // 3 mois
            12 => 6,  // 6 mois
            13 => 12, // 12 mois
        ];

        $months = $durations[$packId] ?? 1;

        return Carbon::now()->addMonths($months);
    }

    /**
     * Page d'attente de confirmation de paiement
     */
    public function waitingPage($transactionId)
    {
        $transaction = PaymentTransaction::find($transactionId);

        if (!$transaction) {
            Log::error('❌ Transaction not found in waiting page', [
                'transaction_id' => $transactionId
            ]);
            return redirect()->route('moncompte')
                ->with('error', 'Transaction introuvable');
        }

        Log::info('📄 User on waiting page', [
            'transaction_id' => $transactionId,
            'status' => $transaction->status,
            'user_id' => $transaction->user_id
        ]);

        return view('payment.waiting', [
            'transaction' => $transaction
        ]);
    }

    /**
     * Endpoint de test pour vérifier que les callbacks sont accessibles
     */
    public function testCallback()
    {
        return response()->json([
            'success' => true,
            'message' => 'Callback endpoint accessible',
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Test simple pour vérifier le routage JSON
     */
    public function testJson()
    {
        return response()->json([
            'success' => true,
            'message' => 'JSON endpoint works',
            'timestamp' => now()->toDateTimeString(),
        ], 200);
    }

    /**
     * Vérifier le statut d'une transaction
     */
    public function checkStatus($transactionId)
    {
        // Force JSON response headers
        header('Content-Type: application/json');

        try {
            Log::info('🔍 Checking transaction status', [
                'transaction_id' => $transactionId
            ]);

            $transaction = PaymentTransaction::find($transactionId);

            if (!$transaction) {
                Log::warning('❌ Transaction not found for status check', [
                    'transaction_id' => $transactionId
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found'
                ], 404);
            }

            Log::info('📊 Transaction found', [
                'status' => $transaction->status,
                'amount' => $transaction->amount
            ]);

            // Vérifier auprès de PayPlus si la transaction est en attente
            if ($transaction->isPending()) {
                Log::info('⏳ Transaction is pending, checking with PayPlus', [
                    'transaction_id' => $transactionId
                ]);

                try {
                    $statusCheck = $this->paymentService->checkTransactionStatus($transactionId);

                    Log::info('🔎 PayPlus status check result', [
                        'transaction_id' => $transactionId,
                        'status_check' => $statusCheck
                    ]);

                    if ($statusCheck['success'] && isset($statusCheck['status']) && $statusCheck['status'] === 'completed') {
                        Log::info('✅ PayPlus confirms completion, processing callback', [
                            'transaction_id' => $transactionId
                        ]);

                        // La transaction est complétée chez PayPlus mais pas chez nous
                        // Traiter le callback manuellement
                        $this->paymentService->processPaymentCallback($transactionId, [
                            'response_code' => '00',
                            'description' => 'completed',
                            'auto_checked' => true,
                        ]);

                        // Recharger la transaction
                        $transaction->refresh();
                    } else {
                        Log::info('⏳ PayPlus says transaction still pending or failed', [
                            'transaction_id' => $transactionId,
                            'payplus_status' => $statusCheck['status'] ?? 'unknown'
                        ]);
                    }
                } catch (\Exception $payPlusError) {
                    Log::warning('⚠️ Error checking with PayPlus', [
                        'error' => $payPlusError->getMessage(),
                        'trace' => $payPlusError->getTraceAsString()
                    ]);
                    // Continue même si PayPlus check échoue
                }
            }

            return response()->json([
                'success' => true,
                'transaction' => [
                    'id' => $transaction->id,
                    'status' => $transaction->status,
                    'amount' => $transaction->amount,
                    'type' => $transaction->type,
                    'created_at' => $transaction->created_at ? $transaction->created_at->toDateTimeString() : null,
                    'completed_at' => $transaction->completed_at ? $transaction->completed_at->toDateTimeString() : null,
                ]
            ], 200);

        } catch (\Throwable $e) {
            Log::error('❌ Error in checkStatus', [
                'transaction_id' => $transactionId ?? 'N/A',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la vérification du statut',
                'error' => $e->getMessage(),
                'debug' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }
}
