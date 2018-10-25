<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaJuridica;

class PessoaJuridicaController extends Controller
{
    public function ajaxIndex()
    {
        return (new PessoaJuridica)->orderBy('nome_fantasia')->get();
    }


    public function ajaxView($id)
    {
        $pessoa_juridica = (new PessoaJuridica)->find($id);

        return [
            'pessoa_juridica' => $pessoa_juridica,
            'atributos' => [
                //
            ]
        ];
    }
}
