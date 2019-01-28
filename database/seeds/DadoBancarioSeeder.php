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
        $dado_bancario1->nome_banco = "Itaú";
        $dado_bancario1->agencia = "7054";
        $dado_bancario1->conta = "74654-5";
        $dado_bancario1->tipo_conta_id = 1;
        $dado_bancario1->save();
    }
}
