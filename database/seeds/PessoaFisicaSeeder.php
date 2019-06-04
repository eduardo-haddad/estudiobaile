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
        $pf1->nome = 'Thereza Oliveira Farkas';
        $pf1->nome_adotado = 'Thereza Farkas';
        $pf1->cpf = '321.204.388-11';
        $pf1->rg = '43.665.460-X';
        $pf1->passaporte = '';
        $pf1->dt_nascimento = '1984-04-29';
        $pf1->nacionalidade = 'Brasileira';
        $pf1->naturalidade = 'Brasileira';
        $pf1->website = '';
        $pf1->criado_por = 'Eduardo Haddad';
        $pf1->modificado_por = 'Eduardo Haddad';
        $pf1->genero = 'Feminino';
        $pf1->estado_civil_id = EstadoCivil::find(1)->id;
        $pf1->save();
        $pf1->enderecos()->attach(Endereco::find(1)->id);
        $pf1->dados_bancarios()->attach([DadoBancario::find(1)->id]);
        //$pf1->tags()->attach([Tag::find(1)->id, Tag::find(2)->id, Tag::find(3)->id]);
        //
        $pf2 = new PessoaFisica();
        $pf2->nome = 'Victor Homburger Lacerda';
        $pf2->nome_adotado = 'Victor Lacerda';
        $pf2->cpf = '';
        $pf2->rg = '';
        $pf2->passaporte = '';
        $pf2->dt_nascimento = null;
        $pf2->nacionalidade = '';
        $pf2->naturalidade = '';
        $pf2->website = '';
        $pf2->criado_por = 'Eduardo Haddad';
        $pf2->modificado_por = 'Eduardo Haddad';
        $pf2->genero = 'Masculino';
        $pf2->estado_civil_id = EstadoCivil::find(1)->id;
        $pf2->save();
        //
        $pf3 = new PessoaFisica();
        $pf3->nome = 'Eduardo Alfredo Bozza Haddad Junior';
        $pf3->nome_adotado = 'Eduardo Haddad';
        $pf3->cpf = '36965303875';
        $pf3->rg = '248963429';
        $pf3->passaporte = '';
        $pf3->dt_nascimento = '1987-03-26';
        $pf3->nacionalidade = '';
        $pf3->naturalidade = '';
        $pf3->website = 'http://adomuka.com';
        $pf3->criado_por = 'Eduardo Haddad';
        $pf3->modificado_por = 'Eduardo Haddad';
        $pf3->genero = 'Masculino';
        $pf3->estado_civil_id = EstadoCivil::find(2)->id;
        $pf3->save();
        $pf3->tags()->attach([Tag::find(3)->id]);

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
