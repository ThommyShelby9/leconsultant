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
        Log::info('PayPlus callback received', [
            'type' => $type,
            'transaction_id' => $transactionId,
            'data' => $request->all()
        ]);

        // Traiter le callback
        $success = $this->paymentService->processPaymentCallback(
            $transactionId,
            $request->all()
        );

        if ($success) {
            // Récupérer la transaction
            $transaction = PaymentTransaction::find($transactionId);

            if ($transaction && $transaction->isCompleted()) {
                // Activer l'abonnement ou la formation selon le type
                if ($type === 'subscription') {
                    $this->activateSubscription($transaction);
                } elseif ($type === 'formation') {
                    $this->activateFormation($transaction);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Callback processed successfully'
            ], 200);
        }

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

            // Calculer les dates selon le pack
            $dateDebut = Carbon::now();
            $dateFin = $this->calculateSubscriptionEnd($packId);

            // Créer ou mettre à jour l'abonnement
            Abonnement::create([
                'idUser' => $userId,
                'idPack' => $packId,
                'montant' => $transaction->amount,
                'dateDebut' => $dateDebut,
                'dateFin' => $dateFin,
                'stop' => false,
                'transaction_id' => $transaction->id,
            ]);

            Log::info('✅ Subscription activated', [
                'transaction_id' => $transaction->id,
                'user_id' => $userId,
                'pack_id' => $packId
            ]);

        } catch (\Exception $e) {
            Log::error('Subscription activation failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
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
     * Vérifier le statut d'une transaction
     */
    public function checkStatus($transactionId)
    {
        $transaction = PaymentTransaction::find($transactionId);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404);
        }

        // Vérifier auprès de PayPlus si la transaction est en attente
        if ($transaction->isPending()) {
            $statusCheck = $this->paymentService->checkTransactionStatus($transactionId);

            if ($statusCheck['success'] && $statusCheck['status'] === 'completed') {
                // La transaction est complétée chez PayPlus mais pas chez nous
                // Traiter le callback manuellement
                $this->paymentService->processPaymentCallback($transactionId, [
                    'response_code' => '00',
                    'description' => 'completed',
                    'auto_checked' => true,
                ]);

                // Recharger la transaction
                $transaction->refresh();
            }
        }

        return response()->json([
            'success' => true,
            'transaction' => [
                'id' => $transaction->id,
                'status' => $transaction->status,
                'amount' => $transaction->amount,
                'type' => $transaction->type,
                'created_at' => $transaction->created_at,
                'completed_at' => $transaction->completed_at,
            ]
        ]);
    }
}
