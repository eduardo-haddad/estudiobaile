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
        $chancela1->valor = 'produtor';
        $chancela1->save();
        $chancela2 = new Chancela();
        $chancela2->valor = 'produtora';
        $chancela2->save();
        $chancela3 = new Chancela();
        $chancela3->valor = 'produtor executivo';
        $chancela3->save();
        $chancela4 = new Chancela();
        $chancela4->valor = 'produtora executiva';
        $chancela4->save();
    }
}
