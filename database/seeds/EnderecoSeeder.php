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
        $end1->cep = '01423001';
        $end1->rua = 'Rua Dona Inácia Uchoa';
        $end1->numero = '113';
        $end1->complemento = 'ap 11';
        $end1->bairro = 'Vila Mariana';
        $end1->cidade = 'São Paulo';
        $end1->estado = 'SP';
        $end1->pais = 'Brasil';
        $end1->save();

    }
}
