<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interna;
use App\Arquivo;

class InternaController extends Controller
{
    public function getInterna()
    {
        $interna = Interna::find(1);
        $arquivos = $interna->arquivos()->get();

        return [
            'conteudoEditor' => html_entity_decode($interna->valor),
            'arquivos' => $arquivos,

        ];
    }

    public function saveInterna()
    {
        $html = htmlentities(request('conteudoEditor'));
        $arquivos = request('arquivos');

        $interna = Interna::find(1);
        $interna->valor = $html;

        //Arquivos
        foreach($arquivos as $l => $arquivo):
            $arquivo_atual = Arquivo::find($arquivo['id']);
            foreach(json_decode($arquivo_atual) as $chave_arquivos => $valor_arquivos):
                if(!empty($arquivos[$l][$chave_arquivos]) && $chave_arquivos == "descricao") {
                    $arquivo_atual->$chave_arquivos = $arquivos[$l][$chave_arquivos];
                }
            endforeach;
            $arquivo_atual->save();
        endforeach;

        try {
            $interna->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $interna;

    }

    public function ajaxUpload() {

        if(isset($_FILES['arquivo'])) {

            // 0 => 'Arquivo enviado com sucesso'
            if(!$_FILES['arquivo']['error']) {

                $nome_arquivo = date('YmdHis') . '_' . $_FILES['arquivo']['name'];
                $extensao = explode('.', $_FILES['arquivo']['name']);
                $extensao = end($extensao);
                $extensao = strtolower($extensao);
                $tipo = $this->getTipoArquivo($extensao);

                $arquivo = new Arquivo();
                $arquivo->nome = $nome_arquivo;
                $arquivo->tipo = $tipo;
                $arquivo->descricao = $_REQUEST['descricao_arquivo'];
                $arquivo->extensao = $extensao;
                $arquivo->data = date('Y M d H:i');
                $arquivo->save();

                $diretorio = base_path() . "/public/uploads/interna/";

                // cria diretório se não existir
                if(!is_dir($diretorio)) mkdir($diretorio);

                move_uploaded_file(
                    $_FILES['arquivo']['tmp_name'],
                    $diretorio . $nome_arquivo
                );

                $interna = Interna::find(1);
                $interna->arquivos()->attach($arquivo->id);

                $erros = array(
                    0 => 'Arquivo enviado com sucesso',
                    1 => 'Arquivo excede o tamanho estipulado em php.ini (upload_max_filesize)',
                    2 => 'Arquivo excede o tamanho estipulado no formulário HTML (max_file_size)',
                    3 => 'Arquivo enviado parcialmente',
                    4 => 'Nenhum arquivo enviado',
                    6 => 'Diretório temporário inexistente',
                    7 => 'Falha ao salvar arquivo no disco',
                    8 => 'Uma extensão PHP impediu o upload'
                );

                return [
                    'mensagem_upload' => $erros[$_FILES['arquivo']['error']],
                    'arquivos' => $interna->arquivos()->get()
                ];

            }
        }

        return "Arquivo inválido";

    }

    public function ajaxRemoveArquivo() {

        $arquivo_id = request('arquivo_id');

        $arquivo = Arquivo::find($arquivo_id);
        $interna = Interna::find(1);

        $caminho_arquivo = base_path() . "/public/uploads/interna/" . $arquivo->nome;

        try {
            $interna->arquivos()->detach($arquivo_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        try {
            $arquivo->delete();
            unlink($caminho_arquivo);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $arquivos = $interna->arquivos()->get();

        return [
            'arquivos' => $arquivos,
        ];
    }

}
