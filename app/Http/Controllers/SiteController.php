<?php

namespace App\Http\Controllers;

use App\PessoaFisica;

class SiteController extends Controller
{
    public function view(){

        $dados = PessoaFisica::all();

        return view('site.projetoa',compact('dados'));
    }

}