<?php

use Illuminate\Database\Seeder;
use App\TipoContato;

class TipoContatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        $tipo_contato_email = new TipoContato();
        $tipo_contato_email->tipo = 'e-mail';
        $tipo_contato_email->save();
        //2
        $tipo_contato_telefone = new TipoContato();
        $tipo_contato_telefone->tipo = 'telefone';
        $tipo_contato_telefone->save();
    }
}
