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

}
