<?php

use Illuminate\Database\Seeder;
use App\PessoaJuridica;
use App\Categoria;

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
        $pj->categorias()->attach(Categoria::find(1));
        $pj2 = new PessoaJuridica();
        $pj2->nome_fantasia = 'Videobrasil';
        $pj2->razao_social = 'Associação Cultural Videobrasil';
        $pj2->cnpj = '01.000000/0001-00';
        $pj2->website = 'http://videobrasil.org.br';
        $pj2->inscricao_municipal = '00000';
        $pj2->inscricao_estadual = '00000';
        $pj2->criado_por = 'Eduardo Haddad';
        $pj2->modificado_por = 'Eduardo Haddad';
        $pj2->save();
        $pj2->categorias()->attach(Categoria::find(1));

    }
}
