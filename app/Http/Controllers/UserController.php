<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Arquivo;
use App\Role;

class UserController extends Controller
{
    public function ajaxIndex()
    {
        return User::orderBy('name')->get();
    }


    public function ajaxView($id)
    {
        $usuario = User::find($id);

        $funcao = $usuario->roles()->get();
        $funcoes = Role::where('name', '!=', 'superadmin')->orderby('id')->get();

        //Arquivos
        $arquivos = $usuario->arquivos()->get();

        return [
            'usuario' => $usuario,
            'funcao' => $funcao[0],
            'arquivos' => $arquivos,
            'atributos' => [
                'funcoes' => $funcoes
            ]
        ];
    }

    public function ajaxCreate()
    {
        if(!empty(request('name')) && !empty(request('username')) && !empty(request('password'))) {

            $funcao = Role::where('id', request('role'))->first();

            $usuario = User::create([
                'name' => request('name'),
                'username' => request('username'),
                'password' => bcrypt(request('password'))
            ]);

            $usuario->roles()->attach($funcao);

            return $usuario['id'];

        }

        return "Não foi possível criar pessoa física";

    }


    public function ajaxSave(Request $r) {

        $request['usuario'] = request('usuario');
        $request['arquivos'] = request('arquivos');
        $request['funcao'] = request('funcao');
        $request['nova_senha'] = request('nova_senha');

        $usuario = User::find($request['usuario']['id']);

//        if($request['nova_senha'] == )

        if(!empty($request['usuario']['password'])) {
            $usuario->password = bcrypt($request['usuario']['password']);
        }

        //Usuario
        foreach(json_decode($usuario) as $chave => $valor):
            if($chave == "modificado_por") {
                $usuario->$chave = $r->user()->name;
            } else {
                $dado = $request['usuario'][$chave];
                if(!empty($dado)) {
                   $usuario->$chave = $dado;
                }
            }
        endforeach;

        $usuario->roles()->sync([$request['funcao']]);

        //Arquivos
        foreach($request['arquivos'] as $l => $arquivo):
            $arquivo_atual = Arquivo::find($arquivo['id']);
            foreach(json_decode($arquivo_atual) as $chave_arquivos => $valor_arquivos):
                if(!empty($request['arquivos'][$l][$chave_arquivos]) && $chave_arquivos == "descricao") {
                    $arquivo_atual->$chave_arquivos = $request['arquivos'][$l][$chave_arquivos];
                }
            endforeach;
            $arquivo_atual->save();
        endforeach;

        $usuario->save();

        return $usuario;
    }

    public function ajaxRemoveUsuario($id) {

        $usuario = User::find($id);
        $usuario_logado = User::find(request('usuario_logado'));

        $funcao_usuario = $usuario->roles()->get()[0]['name'];
        $funcao_usuario_logado = $usuario_logado->roles()->get()[0]['name'];

        if(in_array($funcao_usuario_logado, ['equipe', 'usuario'])) {
            if(in_array($funcao_usuario, ['administrador', 'superadmin'])) {
                return "Você não tem permissão para realizar esta operação";
            }
        }

        try {
            $usuario->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return User::all();

    }


    public function ajaxUpload() {

        if(isset($_FILES['arquivo'])) {

            // 0 => 'Arquivo enviado com sucesso'
            if(!$_FILES['arquivo']['error']) {

                $nome_arquivo = date('YmdHis') . '_' . $_FILES['arquivo']['name'];
                $extensao = explode('.', $_FILES['arquivo']['name']);
                $extensao = end($extensao);

                switch($extensao):
                    //imagens
                    case 'jpg': case 'jpeg': case 'png':
                    $tipo = "imagem"; break;
                    //gif
                    case 'gif':
                        $tipo = "gif"; break;
                    //imagens
                    case 'psd': case 'tiff':
                    $tipo = "imagem+"; break;
                    //documentos de texto
                    case 'doc': case 'docx': case 'pdf': case 'txt':
                    $tipo = "documento"; break;
                    //planilhas
                    case 'xls': case 'xlsx':
                    $tipo = "planilha"; break;
                    //outros
                    default:
                        $tipo = "arquivo";
                endswitch;


                $arquivo = new Arquivo();
                $arquivo->nome = $nome_arquivo;
                $arquivo->tipo = $tipo;
                $arquivo->descricao = $_REQUEST['descricao_arquivo'];
                $arquivo->extensao = $extensao;
                $arquivo->data = date('Y M d H:i');
                $arquivo->save();

                $usuario_id = $_REQUEST['usuario_id'];

                $diretorio = base_path() . "/public/uploads/usuarios/$usuario_id/";

                // cria diretório se não existir
                if(!is_dir($diretorio)) mkdir($diretorio);

                move_uploaded_file(
                    $_FILES['arquivo']['tmp_name'],
                    $diretorio . $nome_arquivo
                );

                $usuario = User::find($usuario_id);
                $usuario->arquivos()->attach($arquivo->id);

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
                    'arquivos' => $usuario->arquivos()->get()
                ];

            }
        }

        return "Arquivo inválido";

    }

    public function ajaxRemoveArquivo() {

        $arquivo_id = request('arquivo_id');
        $usuario_id = request('usuario_id');

        $arquivo = Arquivo::find($arquivo_id);
        $usuario = User::find($usuario_id);

        $caminho_arquivo = base_path() . "/public/uploads/usuarios/$usuario_id/" . $arquivo->nome;

        //Checa se arquivo relacionado tem destaque
        $destaque = $this->checaDestaque($usuario_id, $arquivo_id);

        //Desabilita destaque se já existir
        $remove_destaque = false;
        if(!empty($destaque) && $destaque[0]->destaque == 1) {
            //Apaga outros thumbs
            $dir_thumbs = base_path() . "/public/thumbs/usuarios/$usuario_id";
            if($this->rmRecursivo($dir_thumbs)) {
                $remove_destaque = true;
            }
        }

        try {
            $usuario->arquivos()->detach($arquivo_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        try {
            $arquivo->delete();
            unlink($caminho_arquivo);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $arquivos = $usuario->arquivos()->get();

        return [
            'arquivos' => $arquivos,
            'remove_destaque' => $remove_destaque,
        ];
    }

    public function ajaxSetImagemDestaque() {

        $usuario_id = request('usuario_id');
        $arquivo_id = request('arquivo_id');

        $usuario = User::find($usuario_id);
        $arquivo = $usuario->arquivos()->find($arquivo_id);
        $arquivos = $usuario->arquivos()->get();

        //Dados para criação de thumbnail
        $nome_arquivo = $arquivo['nome'];
        $extensao = $arquivo['extensao'];
        $origem = base_path() . "/public/uploads/usuarios/$usuario_id/";
        $destino = base_path() . "/public/thumbs/usuarios/$usuario_id/";
        $dir_thumbs = base_path() . "/public/thumbs/usuarios/$usuario_id";

        //Checa se arquivo relacionado tem destaque
        $destaque = $this->checaDestaque($usuario_id, $arquivo_id);

        //Desabilita thumb se já existir
        if(!empty($destaque) && $destaque[0]->destaque == 1) {
            //Remove destaque de tabela associativa
            $arquivo->pivot->destaque = null;
            $arquivo->pivot->save();
            //Apaga outros thumbs
            if($this->rmRecursivo($dir_thumbs)) {
                //id == 0 na view aciona a foto de perfil vazio
                $arquivo['id'] = 0;
                return [
                    'imagem_destaque' => $arquivo,
                    'arquivos' => $arquivos
                ];
            }
        }

        if(!empty($usuario) && $arquivo['tipo'] == 'imagem') {

            //Desabilita todos destaques das imagens relacionadas
            foreach($arquivos as $arquivos_usuario) {
                if($arquivos_usuario['tipo'] == 'imagem') {
                    $arquivos_usuario->pivot->destaque = null;
                    $arquivos_usuario->pivot->save();
                }
            }

            //Destaca arquivo clicado
            $arquivo->pivot->destaque = 1;
            $arquivo->pivot->save();

            //Apaga outros thumbs
            if($this->rmRecursivo($dir_thumbs)) {
                // cria diretório se não existir
                if(!is_dir($destino)) mkdir($destino);
                //Gera novo thumb
                if($this->makeThumb($origem.$nome_arquivo, $destino.$nome_arquivo, 300, $extensao)) {
                    return [
                        'imagem_destaque' => $arquivo,
                        'arquivos' => $arquivos
                    ];
                }
            } else return "Erro ao apagar thumbs";
        }
        return "Arquivo inválido";
    }


    public function ajaxGetImagemDestaque() {

        $destaque = User::find(request('usuario_id'))->arquivos()->where('destaque', 1)->first();
        return !empty($destaque) ? $destaque : "Destaque indisponível";

    }

    public function checaDestaque($usuario_id, $arquivo_id) {
        return \DB::select("
            SELECT 
                ArquivosRelacionados.destaque
            FROM arquivos Arquivos
                INNER JOIN arquivos_relacionados ArquivosRelacionados
                ON Arquivos.id = ArquivosRelacionados.arquivo_id 
                  AND ArquivosRelacionados.usuario_id = $usuario_id
            WHERE ArquivosRelacionados.arquivo_id = $arquivo_id
            LIMIT 1
        ");
    }

    public function getFuncoes() {
        return Role::where('name', '!=', 'superadmin')->orderby('id')->get();
    }
}
