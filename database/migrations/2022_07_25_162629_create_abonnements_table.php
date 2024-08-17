<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('idUser')->unsigned();
            $table->foreign('idUser')->references('id')->on('users');

            $table->bigInteger('typePack')->unsigned();
            $table->foreign('typePack')->references('id')->on('packs');


            $table->boolean('modeEssaie')->default(false);
            $table->date('dateDebut');
            $table->date('dateFin')->nullable();

            $table->string('transaction_id')->nullable();
            $table->boolean('stop')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonnements');
    }
}
