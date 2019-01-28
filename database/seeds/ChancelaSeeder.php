<?php

use Illuminate\Database\Seeder;
use App\Chancela;

class ChancelaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chancela1 = new Chancela();
        $chancela1->valor = 'realização';
        $chancela1->save();
        $chancela2 = new Chancela();
        $chancela2->valor = 'produtora';
        $chancela2->save();
    }
}
