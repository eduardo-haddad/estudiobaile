<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaJuridicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoa_juridica', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_fantasia');
            $table->string('razao_social')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('website')->nullable();
            $table->text('dados_bancarios')->nullable();
            $table->string('criado_por');
            $table->string('modificado_por');
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
        Schema::dropIfExists('pessoa_juridica');
    }
}
