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
        $cargo1->valor = 'propietário';
        $cargo1->save();
        $cargo2 = new Cargo();
        $cargo2->valor = 'estagiário';
        $cargo2->save();
        $cargo3 = new Cargo();
        $cargo3->valor = 'coordenação';
        $cargo3->save();
    }
}
