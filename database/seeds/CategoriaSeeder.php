<?php

use Illuminate\Database\Seeder;
use App\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat1 = new Categoria();
        $cat1->nome = "fornecedor";
        $cat1->criado_por = 'Eduardo Haddad';
        $cat1->modificado_por = 'Eduardo Haddad';
        $cat1->save();

        $cat2 = new Categoria();
        $cat2->nome = "artista";
        $cat2->criado_por = 'Eduardo Haddad';
        $cat2->modificado_por = 'Eduardo Haddad';
        $cat2->save();

    }
}
