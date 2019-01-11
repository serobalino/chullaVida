<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->unsignedInteger('id_ju');
            $table->unsignedInteger('id_re');
            $table->longText('instruccion_re');
            $table->foreign('id_ju')->references('id_ju')->on('juegos');
            $table->foreign('id_re')->references('id_re')->on('reglas');
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
        Schema::dropIfExists('log');
    }
}
