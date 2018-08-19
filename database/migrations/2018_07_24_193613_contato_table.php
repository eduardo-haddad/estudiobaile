<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContatoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contato', function (Blueprint $table) {
            $table->increments('id');
            $table->string('valor');
            $table->integer('tipo_contato_id')->unsigned();
            $table->integer('pessoa_fisica_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('contato', function (Blueprint $table) {
            $table->foreign('tipo_contato_id')->references('id')->on('tipo_contato');
            $table->foreign('pessoa_fisica_id')->references('id')->on('pessoa_fisica');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contato');
    }
}
