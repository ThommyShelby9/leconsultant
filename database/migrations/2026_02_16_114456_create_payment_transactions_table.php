<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('type'); // 'subscription' ou 'formation'
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('XOF');
            $table->string('status', 20)->default('PENDING'); // PENDING, COMPLETED, FAILED, CANCELLED
            $table->string('reference')->unique(); // Référence externe (DEP-xxx)
            $table->string('payplus_token')->nullable(); // Token retourné par PayPlus
            $table->unsignedBigInteger('related_id')->nullable(); // ID de l'abonnement ou formation
            $table->text('customer_phone')->nullable();
            $table->text('gateway_response')->nullable(); // Réponse JSON de PayPlus
            $table->text('payload')->nullable(); // Données envoyées à PayPlus
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['status', 'created_at']);
            $table->index('reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transactions');
    }
}
