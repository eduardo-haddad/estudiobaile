<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Arquivo;
use App\PessoaFisica;
use App\PessoaJuridica;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getFile($tipo, $id=null, $arquivo_id=null){

        $arquivo = null;
        if(!empty($arquivo_id)){
            $arquivo = Arquivo::find($arquivo_id)->nome;
        }

        switch ($tipo) {
            case 'pf': $diretorio = "pessoas_fisicas/$id/"; break;
            case 'pj': $diretorio = "pessoas_juridicas/$id/"; break;
            case 'projeto': $diretorio = "projetos/$id/"; break;
            case 'usuario': $diretorio = "usuarios/$id/"; break;
            //case 'export-pf': $diretorio = "arquivos/"; break;
        }

        if(empty($diretorio)) return "Arquivo inválido";

        $caminho_arquivo = base_path('public/uploads/' . $diretorio . $arquivo);

        return response()->download($caminho_arquivo, $arquivo);

    }

    public function getTipoArquivo($ext){
        switch($ext):
            //imagens
            case 'jpg': case 'jpeg': case 'png':
                return "imagem";
            //gif
            case 'gif':
                return "gif";
            //imagens
            case 'psd': case 'tiff':
                return "img alta";
            //documentos de texto
            case 'doc': case 'docx': case 'pdf': case 'txt':
                return "documento";
            //planilhas
            case 'xls': case 'xlsx':
                return "planilha";
            //outros
            default:
                return "arquivo";
        endswitch;
    }

    public function makeThumb($src, $dest, $desired_width, $ext) {

        /* read the source image */
        if(isset($ext)) {
            switch ($ext) {
                case 'png':
                    $source_image = imagecreatefrompng($src);
                    break;
                case 'jpg': case 'jpeg':
                    $source_image = imagecreatefromjpeg($src);
                    break;
                default:
                    return false;
            }
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);


        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy and rescale source image */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical cropped image to its destination */
        switch ($ext) {
            case 'png':
                imagepng($virtual_image, $dest);
                return true;
            case 'jpg':
                imagejpeg($virtual_image, $dest, 85);
                return true;
        }
    }

    public function rmRecursivo($dir) {
        foreach(glob("{$dir}/*") as $file) {
            if(is_dir($file)) {
                $this->rmRecursivo($file);
            } else {
                unlink($file);
            }
        }
        return true;
    }

    public function exportPlanilha(){

        $input = public_path() . '/modelo_export.xlsx';
        $output = public_path() . '/export_pf.xlsx';

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($input);

        $dados_pf = array();
        $pessoas_fisicas = PessoaFisica::select('id', 'nome_adotado')->orderBy('nome_adotado')->get();
        $pessoas_juridicas = PessoaJuridica::select('id', 'nome_fantasia')->orderBy('nome_fantasia')->get();

        //Pessoas Físicas
        foreach($pessoas_fisicas as $pessoa_fisica):
            $pf = PessoaFisica::find($pessoa_fisica->id);
            $contatos = $pf->contatos()->where([
                //somente emails
                ['tipo_contato_id', '=', 1],
                //somente contatos marcados como mailing
                ['mailing', '=', 1]
            ])->get();

            foreach($contatos as $contato):
                array_push($dados_pf,
                    //monta array
                    ['Pessoa Física', $pf->nome_adotado, $contato['valor']]
                );
            endforeach;
        endforeach;

        //Pesoas Jurídicas
        foreach($pessoas_juridicas as $pessoa_juridica):
            $pj = PessoaJuridica::find($pessoa_juridica->id);
            $contatos = $pj->contatos()->where([
                //somente emails
                ['tipo_contato_id', '=', 1],
                //somente contatos marcados como mailing
                ['mailing', '=', 1]
            ])->get();

            foreach($contatos as $contato):
                array_push($dados_pf,
                    //monta array
                    ['Pessoa Jurídica', $pj->nome_fantasia, $contato['valor']]
                );
            endforeach;
        endforeach;

        //insere dados na planilha
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $dados_pf,          // The data to set
                NULL,       // Array values with this value will not be set
                'A2'         // Top left coordinate of the worksheet range where we want to set these values (default is A1)
            );

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($output);

        return response()->download($output, 'export_' . date('YmdHis') . '.xlsx');
    }

}
