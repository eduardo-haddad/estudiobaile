<?php

namespace App\Http\Controllers;

use App\PessoaFisica;
use App\PessoaJuridica;
use Illuminate\Http\Request;
use App\Projeto;
use App\Chancela;
use App\Arquivo;

class ProjetoController extends Controller
{
    public function ajaxIndex()
    {
        return Projeto::orderBy('nome')->get();
    }

    public function ajaxCreate(Request $request)
    {
        if(!empty(request('nome'))) {

            $projeto = Projeto::create([
                'nome' => request('nome'),
                'criado_por' => $request->user()->name,
                'modificado_por' => $request->user()->name
            ]);

            return $projeto['id'];

        }

        return "Não foi possível criar projeto";

    }


    public function ajaxView($id)
    {
        $projeto = Projeto::find($id);
        $pessoas_fisicas = PessoaFisica::all();
        $pessoas_juridicas = PessoaJuridica::all();
        $chancelas = Chancela::all();
        $pessoas_fisicas_chancelas_relacionadas = Projeto::getPessoasDeProjetos($id, true);
        $pessoas_juridicas_chancelas_relacionadas = Projeto::getPessoasDeProjetos($id, null, true);
        $arquivos = $projeto->arquivos()->get();


        return [
            'projeto' => $projeto,
            'pessoas_fisicas_chancelas_relacionadas' => $pessoas_fisicas_chancelas_relacionadas,
            'pessoas_juridicas_chancelas_relacionadas' => $pessoas_juridicas_chancelas_relacionadas,
            'arquivos' => $arquivos,
            'atributos' => [
                'pessoas_fisicas' => $pessoas_fisicas,
                'pessoas_juridicas' => $pessoas_juridicas,
                'chancelas' => $chancelas,
            ]
        ];
    }


    public function ajaxSave(Request $r) {

        $request['projeto'] = request('projeto');
        $request['pessoas_fisicas'] = request('pessoas_fisicas');
        $request['chancelas_pf'] = request('chancelas_pf');
        $request['arquivos'] = request('arquivos');

        //Projeto
        $projeto = Projeto::find($request['projeto']['id']);

        foreach(json_decode($projeto) as $chave => $valor):
            if($chave == "modificado_por") {
                $projeto->$chave = $r->user()->name;
            }
            else {
                if(!empty($request['projeto'][$chave])) {
                    $projeto->$chave = $request['projeto'][$chave];
                }
            }
        endforeach;

        $projeto->save();

        //Pessoas físicas
        if(empty($request['pessoas_fisicas'])) {
            $projeto->pessoas_fisicas()->detach();
        } else {
            //$projeto->pessoas_fisicas()->sync($request['pessoas_fisicas']);
            $projeto->pessoas_fisicas()->attach(PessoaFisica::find($request['pessoas_fisicas']));
        }

        //Chancelas Pessoa Física
        $pessoa_fisica = PessoaFisica::find($request['pessoas_fisicas']);

        if(empty($request['chancelas_pf'])) {
            $projeto->pessoas_fisicas()->detach();
            $projeto->pessoas_fisicas()->attach(PessoaFisica::find($request['pessoas_fisicas']), ['chancela_id' => null]);
        } else {
            $chancela_pf = $request['chancelas_pf'];
            if (substr($chancela_pf, 0, 4) == 'new:')
            {
                $chancela_pf = strtolower(substr($chancela_pf,4));
                $chancelaPfObj = Chancela::where('valor', $chancela_pf)->first();
                if(empty($chancelaPfObj)){
                    $nova_chancela = Chancela::create(['valor' => $chancela_pf]);
                    $chancela_pf_id = $nova_chancela->id;
                } else {
                    $chancela_pf_id = $chancelaPfObj->id;
                }
            } else {
                $chancela_pf_id = $chancela_pf;
            }

            $projeto->pessoas_fisicas()->detach();
            $projeto->pessoas_fisicas()->attach(PessoaFisica::find($request['pessoas_fisicas']), ['chancela_id' => $chancela_pf_id]);

        }

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

        return $projeto;
    }

    public function ajaxGetPfSelecionadas($id) {

        $projeto = (new Projeto)->find($id);
        $pessoas_fisicas = $projeto->pessoas_fisicas()->get();
        return $pessoas_fisicas;

    }

    public function ajaxGetChancelasSelecionadas($id) {

        $projeto = (new Projeto)->find($id);
        $pessoas_fisicas = $projeto->pessoas_fisicas()->get();

        foreach($pessoas_fisicas as &$pessoa_fisica){
            $pessoa_fisica['chancela'] = Projeto::getChancelaPorId($id, $pessoa_fisica['id']);
        }


        return $pessoas_fisicas;

    }


    public function ajaxAddChancelaPf() {

        $chancela = request('nova_chancela');
        $projeto_id = request('projeto_id');

        //Condições
        $isPf = array_key_exists('pessoa_fisica', $chancela)
            && !empty($chancela['pessoa_fisica'])
            && !array_key_exists('pessoa_juridica', $chancela);

        $isPj = array_key_exists('pessoa_juridica', $chancela)
            && !empty($chancela['pessoa_juridica'])
            && !array_key_exists('pessoa_fisica', $chancela);;

        if(!empty($projeto_id) && ( $isPf || $isPj ) && !empty($chancela['chancela'])) {

            if(substr($chancela['chancela'], 0, 4) == 'new:'){
                $nova_chancela = strtolower(substr($chancela['chancela'],4));
                $chancelaObj = Chancela::where('valor', $nova_chancela)->first();
                if(empty($chancelaObj)){
                    $nova_chancela = Chancela::create(['valor' => $nova_chancela]);
                    $chancela['chancela'] = $nova_chancela->id;
                }
            }

            $projeto = Projeto::find($projeto_id);

            if($isPf) {
                $projeto->pessoas_fisicas()->attach(PessoaFisica::find($chancela['pessoa_fisica']), ['chancela_id' => $chancela['chancela']]);
            } else if($isPj) {
                $projeto->pessoas_juridicas()->attach(PessoaJuridica::find($chancela['pessoa_juridica']), ['chancela_id' => $chancela['chancela']]);
            }

        } else {
            return "Chancela inválida";
        }

        return [ Projeto::getPessoasDeProjetos($projeto_id, $isPf, $isPj), Chancela::all() ];
    }

    public function ajaxRemoveChancelaPf() {

        $projeto_id = request('projeto_id');
        $chancela_id = request('chancela_id');
        $pessoa_fisica_id = request('pessoa_fisica_id');
        $pessoa_juridica_id = request('pessoa_juridica_id');

        if(Projeto::removeChancelaDeProjeto($projeto_id, $chancela_id, $pessoa_fisica_id, $pessoa_juridica_id)){
            return Projeto::getPessoasDeProjetos($projeto_id, $pessoa_fisica_id, $pessoa_juridica_id);
        }

        return "Chancela inválida";

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

                $projeto_id = $_REQUEST['projeto_id'];

                $diretorio = base_path() . "/public/uploads/projetos/$projeto_id/";

                // cria diretório se não existir
                if(!is_dir($diretorio)) mkdir($diretorio);

                move_uploaded_file(
                    $_FILES['arquivo']['tmp_name'],
                    $diretorio . $nome_arquivo
                );

                $projeto = Projeto::find($projeto_id);
                $projeto->arquivos()->attach($arquivo->id);

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
                    'arquivos' => $projeto->arquivos()->get()
                ];

            }
        }

        return "Arquivo inválido";

    }

    public function ajaxRemoveArquivo() {

        $arquivo_id = request('arquivo_id');
        $projeto_id = request('projeto_id');

        $arquivo = Arquivo::find($arquivo_id);
        $projeto = Projeto::find($projeto_id);

        $caminho_arquivo = base_path() . "/public/uploads/projetos/$projeto_id/" . $arquivo->nome;

        //Checa se arquivo relacionado tem destaque
        $destaque = $this->checaDestaque($projeto_id, $arquivo_id);

        //Desabilita destaque se já existir
        $remove_destaque = false;
        if(!empty($destaque) && $destaque[0]->destaque == 1) {
            //Apaga outros thumbs
            $dir_thumbs = base_path() . "/public/thumbs/projetos/$projeto_id";
            if($this->rmRecursivo($dir_thumbs)) {
                $remove_destaque = true;
            }
        }

        try {
            $projeto->arquivos()->detach($arquivo_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        try {
            $arquivo->delete();
            unlink($caminho_arquivo);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $arquivos = $projeto->arquivos()->get();

        return [
            'arquivos' => $arquivos,
            'remove_destaque' => $remove_destaque,
        ];
    }

    public function ajaxSetImagemDestaque() {

        $projeto_id = request('projeto_id');
        $arquivo_id = request('arquivo_id');

        $projeto = Projeto::find($projeto_id);
        $arquivo = $projeto->arquivos()->find($arquivo_id);
        $arquivos = $projeto->arquivos()->get();

        //Dados para criação de thumbnail
        $nome_arquivo = $arquivo['nome'];
        $extensao = $arquivo['extensao'];
        $origem = base_path() . "/public/uploads/projetos/$projeto_id/";
        $destino = base_path() . "/public/thumbs/projetos/$projeto_id/";
        $dir_thumbs = base_path() . "/public/thumbs/projetos/$projeto_id";

        //Checa se arquivo relacionado tem destaque
        $destaque = $this->checaDestaque($projeto_id, $arquivo_id);

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

        if(!empty($projeto) && $arquivo['tipo'] == 'imagem') {

            //Desabilita todos destaques das imagens relacionadas
            foreach($arquivos as $arquivos_projeto) {
                if($arquivos_projeto['tipo'] == 'imagem') {
                    $arquivos_projeto->pivot->destaque = null;
                    $arquivos_projeto->pivot->save();
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

        $destaque = Projeto::find(request('projeto_id'))->arquivos()->where('destaque', 1)->first();
        return !empty($destaque) ? $destaque : "Destaque indisponível";

    }

    public function checaDestaque($projeto_id, $arquivo_id) {
        return \DB::select("
            SELECT 
                ArquivosRelacionados.destaque
            FROM arquivos Arquivos
                INNER JOIN arquivos_relacionados ArquivosRelacionados
                ON Arquivos.id = ArquivosRelacionados.arquivo_id 
                  AND ArquivosRelacionados.projeto_id = $projeto_id
            WHERE ArquivosRelacionados.arquivo_id = $arquivo_id
            LIMIT 1
        ");
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
