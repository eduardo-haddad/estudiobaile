<?php

use Illuminate\Database\Seeder;
use App\EstadoCivil;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $casado = new EstadoCivil();
        $casado->valor = "casado(a)";
        $casado->save();
        $divorciado = new EstadoCivil();
        $divorciado->valor = "divorciado(a)";
        $divorciado->save();
        $separado = new EstadoCivil();
        $separado->valor = "separado(a)";
        $separado->save();
        $solteiro = new EstadoCivil();
        $solteiro->valor = "solteiro(a)";
        $solteiro->save();
        $viuvo = new EstadoCivil();
        $viuvo->valor = "viúvo(a)";
        $viuvo->save();
        $desconhecido = new EstadoCivil();
        $desconhecido->valor = "não informado";
        $desconhecido->save();
    }
}
