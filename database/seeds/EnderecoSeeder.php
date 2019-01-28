<?php

use Illuminate\Database\Seeder;
use App\Endereco;

class EnderecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $end1 = new Endereco();
        $end1->cep = '05418020';
        $end1->rua = 'Rua Navarro de Andrade';
        $end1->numero = '140';
        $end1->complemento = 'apto 12';
        $end1->bairro = 'Pinheiros';
        $end1->cidade = 'São Paulo';
        $end1->estado = 'SP';
        $end1->pais = 'Brasil';
        $end1->save();

    }
}
