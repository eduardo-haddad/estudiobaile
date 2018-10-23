<?php

use Illuminate\Database\Seeder;
use App\Projeto;
use App\PessoaFisica;
use App\PessoaJuridica;
use App\Cargo;

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
        $cargo1 = Cargo::find(1);
        $projeto1->pessoas_fisicas()->attach(PessoaFisica::find(1), ['cargo_id' => $cargo1->id]);
        $projeto1->pessoas_fisicas()->attach(PessoaFisica::find(2), ['cargo_id' => ($cargo1->id + 1)]);
        $projeto1->pessoas_juridicas()->attach(PessoaJuridica::find(1));
        $projeto2 = new Projeto();
        $projeto2->nome = 'Projeto 2';
        $projeto2->dt_inicio = '2018-01-01';
        $projeto2->dt_fim = '2018-02-28';
        $projeto2->criado_por = 'Eduardo Haddad';
        $projeto2->modificado_por = 'Eduardo Haddad';
        $projeto2->save();
        $cargo2 = Cargo::find(3);
        $projeto2->pessoas_fisicas()->attach(PessoaFisica::find(2), ['cargo_id' => $cargo2->id]);
        $projeto2->pessoas_juridicas()->attach(PessoaJuridica::find(1));
    }
}
