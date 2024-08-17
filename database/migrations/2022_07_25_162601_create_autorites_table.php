<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorites', function (Blueprint $table) {

            $table->id();

            $table->bigInteger('categ_id')->unsigned();
            $table->foreign('categ_id')->references('id')->on('categories');

            $table->string('name');
            $table->string('abreviation');
            $table->string('localisation');
            $table->integer('contact')->unsigned();
            $table->string('email')->nullable();

            $table->string('logo')->nullable();


            $table->bigInteger('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('administrateurs');

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
        Schema::dropIfExists('autorites');
    }
}
