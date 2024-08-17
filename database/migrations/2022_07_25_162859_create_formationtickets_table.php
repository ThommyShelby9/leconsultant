<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationticketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formationtickets', function (Blueprint $table) {

            $table->id();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('formation_id')->unsigned();
            $table->foreign('formation_id')->references('id')->on('formations');

            $table->string('idTransaction');
            $table->date('dateTicket');

            $table->boolean('statut')->default(False);
            $table->string('description')->nullable();

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
        Schema::dropIfExists('formationtickets');
    }
}
