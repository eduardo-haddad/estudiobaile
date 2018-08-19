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
        $contato1 = new Contato();
        $contato1->valor = 'eduardo.torquemada@gmail.com';
        $contato1->tipo_contato_id = 1;
        $contato1->pessoa_fisica_id = 1;
        $contato1->pessoa_juridica_id = 0;
        $contato1->save();
        $contato2 = new Contato();
        $contato2->valor = '+551130610705';
        $contato2->tipo_contato_id = 2;
        $contato2->pessoa_fisica_id = 1;
        $contato2->pessoa_juridica_id = 0;
        $contato2->save();
        $contato3 = new Contato();
        $contato3->valor = '+5511996002335';
        $contato3->tipo_contato_id = 3;
        $contato3->pessoa_fisica_id = 1;
        $contato3->pessoa_juridica_id = 0;
        $contato3->save();
    }
}
