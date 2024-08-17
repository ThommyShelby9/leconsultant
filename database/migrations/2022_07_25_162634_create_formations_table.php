<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();

            $table->string('niveau');
            $table->string('titre');
            $table->text('description');
            $table->text('competence')->nullable();
            $table->bigInteger('dureeNbre')->unsigned();
            $table->string('dureeMode');
            $table->date('firstDate');
            $table->string('firstTime');
            $table->string('lieu');
            $table->integer('prix')->unsigned();
            $table->integer('nbrePlace')->unsigned();
            $table->date('dateExpiration');
            $table->text('contenu');
            $table->string('confName')->nullable();
            $table->string('confPost')->nullable();
            $table->string('source');
            $table->string('imageForm');

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
        Schema::dropIfExists('formations');
    }
}
