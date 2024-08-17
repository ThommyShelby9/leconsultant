<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();

            //Pour le compte
            $table->bigInteger('typeActor')->unsigned(); //1: Physique ; 2: Morale
            $table->boolean('isActif')->default(true);
            $table->boolean('isParam')->default(false);
            $table->string('logo')->nullable();


            //Pour les personnes morale
            $table->string('typeSociete')->nullable();
            $table->string('nomSociete')->nullable();
            $table->string('telephoneSociete')->nullable();
            $table->string('adresseSociete')->nullable();

            //Pour les personnes physique
            $table->string('nom')->nullable();
            $table->string('prenoms')->nullable();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();

            $table->string('situation');
            $table->text('surmoi')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
