<?php

use Illuminate\Database\Seeder;
use App\Contato;

class ContatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contato0 = new Contato();
        $contato0->valor = 'therezafarkas@gmail.com';
        $contato0->tipo_contato_id = 1;
        $contato0->pessoa_fisica_id = 1;
        $contato0->pessoa_juridica_id = 0;
        $contato0->save();
        $contato1 = new Contato();
        $contato1->valor = 'thereza@estudiobaile.org';
        $contato1->tipo_contato_id = 1;
        $contato1->pessoa_fisica_id = 1;
        $contato1->pessoa_juridica_id = 0;
        $contato1->save();
        $contato2 = new Contato();
        $contato2->valor = '+55 11 985866863';
        $contato2->tipo_contato_id = 2;
        $contato2->pessoa_fisica_id = 1;
        $contato2->pessoa_juridica_id = 0;
        $contato2->save();
    }
}
