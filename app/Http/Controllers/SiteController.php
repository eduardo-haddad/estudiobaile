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
        $dados = [ 'titulo' => 'Projeto A' ]; 

        return view('site.projetoa', $dados);
    }

    public function projetoViewB(){
        $dados = [ 'titulo' => 'Projeto B' ];
        return view('site.projetob', $dados);
    }

    public function projetoViewC(){
        $dados = [ 'titulo' => 'Projeto C' ];
        return view('site.projetoc' ,$dados);
    }

    public function projetoViewD(){
        $dados = [ 'titulo' => '1ª Temporada de Dança Videobrasil' ];
        return view('site.projetod', $dados);
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