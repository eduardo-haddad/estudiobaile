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
        $pj->dados_bancarios = 'Banco do Brasil';
        $pj->criado_por = 'Eduardo Haddad';
        $pj->modificado_por = 'Eduardo Haddad';
        $pj->save();
        $pj->categorias()->attach(Categoria::find(1));

    }
}
