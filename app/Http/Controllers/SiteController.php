<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaFisica;

class SiteController extends Controller
{
    /*
     * Home
     */

    // Pessoa
    public function homeGetListaPessoa(){
        return response()->json(PessoaFisica::orderBy('nome_adotado')->get(), 200);
    }
    public function homeGetListaPessoaProjetos(Request $request){
        $pessoa = PessoaFisica::find($request->id);
        return response()->json($pessoa->projetos()->get(), 200);
    }
    // Assunto
    // Lugar
    // Parceria

    /*
     * Projetos
     */
    public function projetoViewA(){
        $dados = [];
        return view('site.projetoa', compact('dados'));
    }

    public function projetoViewB(){
        $dados = [];
        return view('site.projetob', compact('dados'));
    }

    public function projetoViewC(){
        $dados = [];
        return view('site.projetoc', compact('dados'));
    }

    public function projetoViewD(){
        $dados = [];
        return view('site.projetod', compact('dados'));
    }

    public function sobre(){
        $dados = [];
        return view('site.sobre', compact('dados'));
    }

    public function projetos(){
        $dados = [];
        return view('site.projetos', compact('dados'));
    }

    public function agenda(){
        $dados = [];
        return view('site.agenda', compact('dados'));
    }

}