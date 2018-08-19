<?php

use Illuminate\Database\Seeder;
use App\Projeto;
use App\PessoaFisica;
use App\PessoaJuridica;

class ProjetoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projeto1 = new Projeto();
        $projeto1->nome = 'Projeto 1';
        $projeto1->dt_inicio = '2018-01-01';
        $projeto1->dt_fim = '2018-02-28';
        $projeto1->criado_por = 'Eduardo Haddad';
        $projeto1->modificado_por = 'Eduardo Haddad';
        $projeto1->save();
        $projeto1->pessoas_fisicas()->attach(PessoaFisica::all()->first());
        $projeto1->pessoas_juridicas()->attach(PessoaJuridica::all()->first());
    }
}
