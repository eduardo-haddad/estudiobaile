<?php

use Illuminate\Database\Seeder;
use App\PessoaFisica;
use App\PessoaJuridica;
use App\Projeto;
use App\Categoria;
use App\Endereco;
use App\Genero;
use App\EstadoCivil;

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
        $pf1->cpf = '123.456.789-00';
        $pf1->dt_nascimento = '1987-03-26';
        $pf1->nacionalidade = 'Brasileiro';
        $pf1->naturalidade = 'São Paulo, SP';
        $pf1->criado_por = 'Eduardo Haddad';
        $pf1->modificado_por = 'Eduardo Haddad';
        $pf1->genero_id = Genero::find(2)->id;
        $pf1->estado_civil_id = EstadoCivil::find(2)->id;
        $pf1->save();
        $pf1->projetos()->attach(Projeto::all()->first());
        $pf1->pessoas_juridicas()->attach(PessoaJuridica::all()->first());
        $pf1->categorias()->attach(Categoria::find(2));
        $pf1->enderecos()->attach(Endereco::find(1));
    }
}
