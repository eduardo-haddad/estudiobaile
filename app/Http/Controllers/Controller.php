<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Arquivo;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getFile($tipo, $arquivo_id){

        $arquivo = Arquivo::find($arquivo_id)->nome;

        switch ($tipo) {
            case 'pf': $diretorio = 'pessoas_fisicas/'; break;
            case 'pj': $diretorio = 'pessoas_juridicas/'; break;
            case 'projeto': $diretorio = 'projetos/'; break;
        }

        if(empty($diretorio)) return "Arquivo inválido";

        $caminho_arquivo = base_path('public/uploads/' . $diretorio . $arquivo);

        return response()->download($caminho_arquivo, $arquivo);

    }
}
