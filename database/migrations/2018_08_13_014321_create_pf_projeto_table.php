<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePfProjetoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pf_projeto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pessoa_fisica_id')->unsigned();
            $table->integer('projeto_id')->unsigned();
        });

        Schema::table('pf_projeto', function (Blueprint $table) {
            $table->foreign('pessoa_fisica_id')->references('id')->on('pessoa_fisica');
            $table->foreign('projeto_id')->references('id')->on('projetos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pf_projeto');
    }
}
