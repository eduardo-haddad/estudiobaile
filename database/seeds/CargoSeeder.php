<?php

use Illuminate\Database\Seeder;
use App\Cargo;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cargo1 = new Cargo();
        $cargo1->valor = 'produtor';
        $cargo1->save();
        $cargo2 = new Cargo();
        $cargo2->valor = 'produtora';
        $cargo2->save();
        $cargo3 = new Cargo();
        $cargo3->valor = 'produtor executivo';
        $cargo3->save();
        $cargo4 = new Cargo();
        $cargo4->valor = 'produtora executiva';
        $cargo4->save();
    }
}
