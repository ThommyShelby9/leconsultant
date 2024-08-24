<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->id();

            $table->text('titre');
            $table->string('reference');
            $table->string('lieu_depot');
            $table->string('fichier');

            $table->date('datePublication');
            $table->date('dateExpiration');
            $table->date('dateOuverture');
            $table->string('heureOuverture');

            //Categorie
            $table->bigInteger('categ_id')->unsigned();
            $table->foreign('categ_id')->references('id')->on('categories');

            //AC
            $table->bigInteger('ac_id')->unsigned();
            $table->foreign('ac_id')->references('id')->on('autorites');

            //Service
            $table->string('service');

            $table->boolean('isPub')->default(True);

            $table->bigInteger('writeBy')->unsigned();

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
        Schema::dropIfExists('offres');
    }
}
