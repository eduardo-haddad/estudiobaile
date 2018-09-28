<?php

use Illuminate\Database\Seeder;
use App\DadoBancario;

class DadoBancarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dado_bancario1 = new DadoBancario();
        $dado_bancario1->nome_banco = "Banco do Brasil";
        $dado_bancario1->agencia = "6941-8";
        $dado_bancario1->conta = "16.574-3";
        $dado_bancario1->tipo_conta_id = 1;
        $dado_bancario1->save();
        $dado_bancario2 = new DadoBancario();
        $dado_bancario2->nome_banco = "Bradesco";
        $dado_bancario2->agencia = "12345-8";
        $dado_bancario2->conta = "54331-3";
        $dado_bancario2->tipo_conta_id = 2;
        $dado_bancario2->save();
    }
}
