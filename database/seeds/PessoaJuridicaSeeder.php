<?php

use Illuminate\Database\Seeder;
use App\PessoaJuridica;
use App\Categoria;
use App\PessoaFisica;

class PessoaJuridicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pj = new PessoaJuridica();
        $pj->nome_fantasia = 'Estúdio Baile';
        $pj->razao_social = 'Estúdio Baile';
        $pj->cnpj = '00.000000/0001-00';
        $pj->website = 'http://estudiobaile.org';
        $pj->inscricao_municipal = '00000';
        $pj->inscricao_estadual = '00000';
        $pj->criado_por = 'Eduardo Haddad';
        $pj->modificado_por = 'Eduardo Haddad';
        $pj->save();
        $pj->pessoas_fisicas()->attach(PessoaFisica::find(1), ['cargo_id' => 1]);
        $pj2 = new PessoaJuridica();
        $pj2->nome_fantasia = 'Adomuka';
        $pj2->razao_social = 'Adomuka - Desenvolvimento e Tecnologia da Informação';
        $pj2->cnpj = '32.197.197/0001-97';
        $pj2->website = '';
        $pj2->inscricao_municipal = '';
        $pj2->inscricao_estadual = '';
        $pj2->criado_por = 'Eduardo Haddad';
        $pj2->modificado_por = 'Eduardo Haddad';
        $pj2->save();

    }
}
