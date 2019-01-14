<?php

use Illuminate\Database\Seeder;
use App\PessoaFisica;
use App\PessoaJuridica;
use App\Projeto;
use App\Categoria;
use App\Endereco;
use App\Genero;
use App\EstadoCivil;
use App\DadoBancario;
use App\Tag;
use App\Chancela;

class PessoaFisicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pf1 = new PessoaFisica();
        $pf1->nome = 'Eduardo Alfredo Bozza Haddad Junior';
        $pf1->nome_adotado = 'Eduardo Haddad';
        $pf1->cpf = '369.653.038-75';
        $pf1->rg = '24.896.342-9';
        $pf1->passaporte = '';
        $pf1->dt_nascimento = '1987-03-26';
        $pf1->nacionalidade = 'Brasileiro';
        $pf1->naturalidade = 'São Paulo, SP';
        $pf1->website = '';
        $pf1->criado_por = 'Eduardo Haddad';
        $pf1->modificado_por = 'Eduardo Haddad';
        $pf1->genero = 'Masculino';
        $pf1->estado_civil_id = EstadoCivil::find(2)->id;
        $pf1->save();

        $pf1->enderecos()->attach(Endereco::find(1)->id);
        $pf1->dados_bancarios()->attach([DadoBancario::find(1)->id]);
        $pf1->tags()->attach([Tag::find(1)->id, Tag::find(2)->id, Tag::find(3)->id]);

//        for($i=0;$i<5000;$i++){
//            $pf = "pf$i";
//            $$pf = new PessoaFisica();
//            $$pf->nome_adotado = "Nome $i";
//            $$pf->criado_por = 'Eduardo Haddad';
//            $$pf->modificado_por = 'Eduardo Haddad';
//            $$pf->save();
//        }

    }
}
