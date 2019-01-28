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
        $pj->razao_social = 'Estúdio Baile Projetos Culturais Ltda.';
        $pj->cnpj = '30741796000102';
        $pj->website = 'http://estudiobaile.org';
        $pj->inscricao_municipal = '';
        $pj->inscricao_estadual = '';
        $pj->criado_por = 'Eduardo Haddad';
        $pj->modificado_por = 'Eduardo Haddad';
        $pj->save();
        $pj->pessoas_fisicas()->attach(PessoaFisica::find(1), ['tag_id' => 1]);
        $pj->pessoas_fisicas()->attach(PessoaFisica::find(2), ['tag_id' => 2]);
        $pj2 = new PessoaJuridica();
        $pj2->nome_fantasia = 'Adomuka';
        $pj2->razao_social = 'Adomuka - Desenvolvimento e Tecnologia da Informação';
        $pj2->cnpj = '32197197000197';
        $pj2->website = 'http://adomuka.com';
        $pj2->inscricao_municipal = '';
        $pj2->inscricao_estadual = '';
        $pj2->criado_por = 'Eduardo Haddad';
        $pj2->modificado_por = 'Eduardo Haddad';
        $pj2->save();
        $pj3 = new PessoaJuridica();
        $pj3->nome_fantasia = 'Videobrasil';
        $pj3->razao_social = 'Associação Cultural Videobrasil';
        $pj3->cnpj = '';
        $pj3->website = 'http://videobrasil.org.br';
        $pj3->inscricao_municipal = '';
        $pj3->inscricao_estadual = '';
        $pj3->criado_por = 'Eduardo Haddad';
        $pj3->modificado_por = 'Eduardo Haddad';
        $pj3->save();

    }
}
