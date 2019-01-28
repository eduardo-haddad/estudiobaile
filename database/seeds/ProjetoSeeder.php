<?php

use Illuminate\Database\Seeder;
use App\Projeto;
use App\PessoaFisica;
use App\PessoaJuridica;
use App\Chancela;

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
        $projeto1->nome = 'Temporada de Dança Videobrasil 2018';
        $projeto1->dt_inicio = '2018-07-07';
        $projeto1->dt_fim = '2018-07-27';
        $projeto1->criado_por = 'Eduardo Haddad';
        $projeto1->modificado_por = 'Eduardo Haddad';
        $projeto1->save();
//        $projeto1->pessoas_juridicas()->attach(PessoaJuridica::find(1), ['tag_id' => 1]);
//        $projeto1->pessoas_fisicas()->attach(PessoaJuridica::find(1), ['tag_id' => 2]);
        $projeto2 = new Projeto();
        $projeto2->nome = 'Temporada de Dança Videobrasil / 1a edição';
        $projeto2->dt_inicio = '2017-06-08';
        $projeto2->dt_fim = '2017-07-13';
        $projeto2->criado_por = 'Eduardo Haddad';
        $projeto2->modificado_por = 'Eduardo Haddad';
        $projeto2->save();
//        $projeto2->pessoas_juridicas()->attach(PessoaJuridica::find(1), ['tag_id' => 2]);
        $projeto3 = new Projeto();
        $projeto3->nome = 'Arte Indústria';
        $projeto3->dt_inicio = '';
        $projeto3->dt_fim = '';
        $projeto3->criado_por = 'Eduardo Haddad';
        $projeto3->modificado_por = 'Eduardo Haddad';
        $projeto3->save();
        $projeto4 = new Projeto();
        $projeto4->nome = 'Pousos - Residências artísticas em contextos educativos';
        $projeto4->dt_inicio = '';
        $projeto4->dt_fim = '';
        $projeto4->criado_por = 'Eduardo Haddad';
        $projeto4->modificado_por = 'Eduardo Haddad';
        $projeto4->save();

    }
}
