<?php

use Illuminate\Database\Seeder;
use App\Genero;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fem = new Genero();
        $fem->valor = "F";
        $fem->save();
        $masc = new Genero();
        $masc->valor = "M";
        $masc->save();
    }
}
