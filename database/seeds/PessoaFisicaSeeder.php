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
        $pf1->rg = '24.896.342-9';
        $pf1->passaporte = '12345';
        $pf1->dt_nascimento = '1987-03-26';
        $pf1->nacionalidade = 'Brasileiro';
        $pf1->naturalidade = 'São Paulo, SP';
        $pf1->website = 'http://google.com';
        $pf1->criado_por = 'Eduardo Haddad';
        $pf1->modificado_por = 'Eduardo Haddad';
        $pf1->genero_id = Genero::find(2)->id;
        $pf1->estado_civil_id = EstadoCivil::find(2)->id;
        $pf1->save();
        $pf1->projetos()->attach(Projeto::all()->first());
        $pf1->pessoas_juridicas()->attach(PessoaJuridica::all()->first());
        $pf1->categorias()->attach(Categoria::find(2));
        $pf1->enderecos()->attach(Endereco::find(1));
        $pf1->dados_bancarios()->attach([DadoBancario::find(1)->id, DadoBancario::find(2)->id]);
        
        for($i = 0; $i <= 20; $i++){
            $var = "pf" . $i;

            $zero = $i < 10 ? "0" : "";

            $$var = new PessoaFisica();
            $$var->nome = 'Pessoa' . $zero . $i;
            $$var->nome_adotado = 'Pessoa' . $zero . $i;
            $$var->cpf = '123.456.789-00';
            $$var->rg = '12.123.123-1';
            $$var->passaporte = '12345';
            $$var->dt_nascimento = '1987-03-26';
            $$var->nacionalidade = 'Brasileiro';
            $$var->naturalidade = 'São Paulo, SP';
            $$var->criado_por = 'Eduardo Haddad';
            $$var->modificado_por = 'Eduardo Haddad';
            $$var->genero_id = Genero::find(2)->id;
            $$var->estado_civil_id = EstadoCivil::find(2)->id;
            $$var->save();
        }
        
    }
}
