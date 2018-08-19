<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PessoaFisicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoa_fisica', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('nome_adotado')->nullable();
            $table->string('cpf')->nullable();
            $table->date('dt_nascimento')->nullable();
            $table->string('criado_por');
            $table->string('modificado_por');
            //$table->integer('pessoa_juridica_id')->unsigned();
            $table->timestamps();
        });

        // Schema::table('pessoa_fisica', function (Blueprint $table) {
        //     $table->foreign('pessoa_juridica_id')->references('id')->on('pessoa_juridica');

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoa_fisica');
    }
}
