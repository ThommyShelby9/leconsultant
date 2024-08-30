<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('idUser')->unsigned();
            $table->foreign('idUser')->references('id')->on('users');


            $table->string('details');

            $table->string('marches');
            $table->string('ac');
            $table->string('domaine_activity');


            $table->date('dateDebut');

            $table->string('abonnement_id');
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
        Schema::dropIfExists('alertes');
    }
}
