<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJuegosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juegos', function (Blueprint $table) {
            $table->increments('id_ju');
            $table->unsignedInteger('id_us');
            $table->unsignedInteger('id_ti');
            $table->boolean('estado_ju')->default(true);
            $table->timestamps();
            $table->foreign('id_us')->references('id')->on('users');
            $table->foreign('id_ti')->references('id_ti')->on('tipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('juegos');
    }
}
