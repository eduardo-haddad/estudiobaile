<?php

use Illuminate\Database\Seeder;
use App\TipoContaBancaria;

class TipoContaBancariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        $tipo_conta1 = new TipoContaBancaria();
        $tipo_conta1->valor = 'corrente';
        $tipo_conta1->save();
        //2
        $tipo_conta2 = new TipoContaBancaria();
        $tipo_conta2->valor = 'poupança';
        $tipo_conta2->save();
    }
}
