<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaJuridica;
use App\PessoaFisica;
use App\Tag;
use App\Cargo;
use App\Contato;
use App\Endereco;
use App\DadoBancario;
use App\TipoContaBancaria;
use App\Arquivo;
use App\Projeto;

class PessoaJuridicaController extends Controller
{
    public function ajaxIndex()
    {
        return PessoaJuridica::orderBy('nome_fantasia')->get();
    }

    public function ajaxCreate(Request $request)
    {
        if(!empty(request('nome_fantasia'))) {

            $pessoa_juridica = PessoaJuridica::create([
                'nome_fantasia' => request('nome_fantasia'),
                'criado_por' => $request->user()->name,
                'modificado_por' => $request->user()->name
            ]);

            return $pessoa_juridica['id'];

        }

        return "Não foi possível criar pessoa jurídica";

    }


    public function ajaxView($id)
    {
        $pessoa_juridica = PessoaJuridica::find($id);
        $pessoas_fisicas_cargos_relacionados = PessoaJuridica::getPessoasFisicasRelacionadas($id);

        //Contatos
        $contatos = $pessoa_juridica->contatos()->get();

        //Endereços
        $enderecos = $pessoa_juridica->enderecos()->get();

        //Arquivos
        $arquivos = $pessoa_juridica->arquivos()->get();

        //Dados Bancários
        $dados_bancarios = $pessoa_juridica->dados_bancarios()->get();

        //Tags
        $tags = Tag::all();

        //Projetos
        $projetos = PessoaJuridica::getProjetosChancelasPorId($id);

        return [
            'pessoa_juridica' => $pessoa_juridica,
            'tags' => $tags,
            'pessoas_fisicas_cargos_relacionados' => $pessoas_fisicas_cargos_relacionados,
            'contatos' => $contatos,
            'enderecos' => $enderecos,
            'arquivos' => $arquivos,
            'dados_bancarios' => $dados_bancarios,
            'projetos' => $projetos,
            'atributos' => [
                'cargos_pf' => Cargo::all(),
                'pessoas_fisicas' => PessoaFisica::all(),
                'tipos_conta_bancaria' => TipoContaBancaria::all()
            ]
        ];
    }

    public function ajaxSave(Request $r) {

        $request['pessoa'] = request('pessoa');
        $request['tags'] = request('tags');
        $request['arquivos'] = request('arquivos');
        $request['dados_bancarios'] = request('dados_bancarios');

        //Pessoa Física
        $pessoa_juridica = (new PessoaJuridica)->find($request['pessoa']['id']);

        foreach(json_decode($pessoa_juridica) as $chave => $valor):
            if($chave == "modificado_por") {
                $pessoa_juridica->$chave = $r->user()->name;
            }
            else {
                if(!empty($request['pessoa'][$chave])) {
                    $pessoa_juridica->$chave = $request['pessoa'][$chave];
                }
            }
        endforeach;

        $pessoa_juridica->save();

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

        //Dados Bancários
        foreach($request['dados_bancarios'] as $k => $dados_bancarios):
            $dados_atuais = DadoBancario::find($dados_bancarios['id']);
            foreach(json_decode($dados_atuais) as $chave_dados => $valor_dados):
                if(!empty($request['dados_bancarios'][$k][$chave_dados])) {
                    $dados_atuais->$chave_dados = $request['dados_bancarios'][$k][$chave_dados];
                }
            endforeach;
            $dados_atuais->save();
        endforeach;

        //Tags
        if(empty($request['tags'])) {
            $pessoa_juridica->tags()->detach();
        } else {

            $tags_ids = array();

            foreach ($request['tags'] as $tag)
            {
                if (substr($tag, 0, 4) == 'new:')
                {
                    $tag = strtolower(substr($tag,4));
                    $tagObj = Tag::where('text', $tag)->first();
                    if(empty($tagObj)){
                        $nova_tag = Tag::create(['text' => $tag]);
                        $tags_ids[] = $nova_tag->id;
                    } else {
                        $tags_ids[] = $tagObj->id;
                    }
                    continue;
                }
                $tags_ids[] = $tag;
            }

            $pessoa_juridica->tags()->sync($tags_ids);

        }
        //Deleta tags não atribuídas a ninguém
        $tags_nao_atribuidas = array_map(function($t){ return $t->id; }, Tag::getTagsNaoAtribuidas());
        if(!empty($tags_nao_atribuidas)){
            \DB::table('tags')->whereIn('id', $tags_nao_atribuidas)->delete();
        }

        return $pessoa_juridica;
    }


    public function ajaxDelete() {

        $pessoa = PessoaJuridica::find(request('pessoa'));

        //Dados bancários
        $dados_bancarios = $pessoa->dados_bancarios()->get();
        if(!$dados_bancarios->isEmpty()){
            foreach($dados_bancarios as $dado_pessoa) {
                $pessoa->dados_bancarios()->detach($dado_pessoa['id']);
                $dado_bancario = DadoBancario::find($dado_pessoa['id']);
                $dado_bancario->delete();
            }
        }

        //Endereços
        $enderecos = $pessoa->enderecos()->get();
        if(!$enderecos->isEmpty()){
            foreach($enderecos as $endereco_pessoa) {
                $pessoa->enderecos()->detach($endereco_pessoa['id']);
                $endereco = Endereco::find($endereco_pessoa['id']);
                $endereco->delete();
            }
        }

        //Tags
        $tags = $pessoa->tags()->get();
        if(!$tags->isEmpty()){
            $pessoa->tags()->detach();
            //Deleta tags não atribuídas a ninguém
            $tags_nao_atribuidas = array_map(function($t){ return $t->id; }, Tag::getTagsNaoAtribuidas());
            if(!empty($tags_nao_atribuidas)){
                \DB::table('tags')->whereIn('id', $tags_nao_atribuidas)->delete();
            }
        }

        //Contatos
        $contatos = $pessoa->contatos()->get();
        if(!$contatos->isEmpty()) $pessoa->contatos()->delete();

        //Pessoas Físicas
        $pf_relacionadas = PessoaJuridica::getPessoasFisicasRelacionadas(request('pessoa'));
        if(!empty($pf_relacionadas)){
            foreach($pf_relacionadas as $pf){
                PessoaJuridica::removeCargoPf($pf->cargo_id, $pf->pessoa_fisica_id, request('pessoa'));
            }
        }

        //Projetos
        $projetos = $pessoa->projetos()->get();
        if(!$projetos->isEmpty()){
            foreach($projetos as $projeto){
                $pessoas_projeto = Projeto::getPessoasDeProjetos($projeto['id'], null, true);
                foreach($pessoas_projeto as $pessoa_projeto){
                    if($pessoa_projeto->pessoa_id == request('pessoa')){
                        Projeto::removeChancelaDeProjeto($projeto['id'], $pessoa_projeto->chancela_id, null, request('pessoa'));
                    }
                }
            }
        }

        //Arquivos
        $arquivos = $pessoa->arquivos()->get();
        if(!$arquivos->isEmpty()){
            foreach($arquivos as $arquivo){
                $this->removeArquivo($arquivo['id'], request('pessoa'));
            }
        }

        try {
            $pessoa->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return PessoaJuridica::all();

    }



    public function ajaxGetTagsSelecionadas($id) {
        $pessoa = PessoaJuridica::find($id);
        $tags = $pessoa->tags()->get();
        return $tags;
    }


    public function ajaxAddCargoPf() {

        $cargo = request('novo_cargo');
        $pessoa_fisica_id = request('pessoa_fisica_id');
        $pessoa_juridica_id = request('pessoa_juridica_id');

        if(!empty($cargo) && !empty($pessoa_fisica_id)) {

            if(substr($cargo, 0, 4) == 'new:'){
                $novo_cargo = strtolower(substr($cargo,4));
                $cargoObj = Cargo::where('valor', $novo_cargo)->first();
                if(empty($cargoObj)){
                    $novo_cargo = Cargo::create(['valor' => $novo_cargo]);
                    $cargo = $novo_cargo->id;
                }
            }
            $pessoa_fisica = (new PessoaFisica)->find($pessoa_fisica_id);
            $pessoa_fisica->pessoas_juridicas()->attach(PessoaJuridica::find($pessoa_juridica_id), ['cargo_id' => $cargo]);
        } else {
            return "Cargo inválido";
        }

        return [ PessoaJuridica::getPessoasFisicasRelacionadas($pessoa_juridica_id), Cargo::all() ];

    }

    public function ajaxRemoveCargoPf() {

        $cargo = request('cargo');
        $pessoa_fisica_id = request('pessoa_fisica_id');
        $pessoa_juridica_id = request('pessoa_juridica_id');

        if(PessoaJuridica::removeCargoPf($cargo, $pessoa_fisica_id, $pessoa_juridica_id)){
            return PessoaJuridica::getPessoasFisicasRelacionadas($pessoa_juridica_id);
        }

        return "Chancela inválida";

    }


    public function ajaxAddContato() {

        $request['email'] = request('email');
        $request['telefone'] = request('telefone');

        if(empty($request['email']) && empty($request['telefone'])) {
            return "Contato inválido";
        }

        $contato = new Contato();
        $contato->pessoa_fisica_id = 0;
        $contato->pessoa_juridica_id = request('pessoa_id');

        if(!empty($request['email'])){
            $contato->tipo_contato_id = 1;
            $contato->valor = $request['email'];
        } else {
            $contato->tipo_contato_id = 2;
            $contato->valor = $request['telefone'];
        }

        try {
            $contato->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $pessoa_juridica = (new PessoaJuridica)->find(request('pessoa_id'));
        $contatos = $pessoa_juridica->contatos()->get();

        return $contatos;
    }

    public function ajaxRemoveContato(Request $r) {

        $contato_id = request('contato_id');

        $contato = (new Contato)->find($contato_id);
        $contato->delete();

        $pessoa_juridica = (new PessoaJuridica)->find(request('pessoa_id'));
        $contatos = $pessoa_juridica->contatos()->get();

        return $contatos;
    }

    public function ajaxAddEndereco() {

        $endereco = request('endereco');
        $pessoa_id = request('pessoa_id');

        if(empty($endereco['rua'])) {
            return "Endereço inválido";
        }

        $novo_endereco = new Endereco();
        $novo_endereco->rua = !empty($endereco['rua']) ? $endereco['rua'] : '';
        $novo_endereco->numero = !empty($endereco['numero']) ? $endereco['numero'] : '';
        $novo_endereco->complemento = !empty($endereco['complemento']) ? $endereco['complemento'] : '';
        $novo_endereco->bairro = !empty($endereco['bairro']) ? $endereco['bairro'] : '';
        $novo_endereco->cep = !empty($endereco['cep']) ? $endereco['cep'] : '';
        $novo_endereco->cidade = !empty($endereco['cidade']) ? $endereco['cidade'] : '';
        $novo_endereco->estado = !empty($endereco['estado']) ? $endereco['estado'] : '';
        $novo_endereco->pais = !empty($endereco['pais']) ? $endereco['pais'] : '';

        try {
            $novo_endereco->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $pessoa_juridica = (new PessoaJuridica)->find($pessoa_id);
        $pessoa_juridica->enderecos()->attach($novo_endereco->id);

        $enderecos = $pessoa_juridica->enderecos()->get();

        return $enderecos;
    }

    public function ajaxRemoveEndereco() {

        $endereco_id = request('endereco_id');
        $pessoa_id = request('pessoa_id');

        $endereco = (new Endereco)->find($endereco_id);
        $pessoa_juridica = (new PessoaJuridica)->find($pessoa_id);

        try {
            $pessoa_juridica->enderecos()->detach($endereco_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        try {
            $endereco->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $enderecos = $pessoa_juridica->enderecos()->get();

        return $enderecos;
    }


    public function ajaxAddDadosBancarios() {

        $dados_bancarios = request('dados_bancarios');
        $pessoa_id = request('pessoa_id');

        if(empty($dados_bancarios['conta'])) {
            return "Conta inválida";
        }

        $novos_dados_bancarios = new DadoBancario();
        $novos_dados_bancarios->nome_banco = !empty($dados_bancarios['nome_banco']) ? $dados_bancarios['nome_banco'] : '';
        $novos_dados_bancarios->agencia = !empty($dados_bancarios['agencia']) ? $dados_bancarios['agencia'] : '';
        $novos_dados_bancarios->conta = !empty($dados_bancarios['conta']) ? $dados_bancarios['conta'] : '';
        $novos_dados_bancarios->tipo_conta_id = !empty($dados_bancarios['tipo_conta_id']) ? $dados_bancarios['tipo_conta_id'] : '';

        try {
            $novos_dados_bancarios->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $pessoa_juridica = PessoaJuridica::find($pessoa_id);
        $pessoa_juridica->dados_bancarios()->attach($novos_dados_bancarios->id);

        $todos_dados_bancarios = $pessoa_juridica->dados_bancarios()->get();
        return $todos_dados_bancarios;
    }


    public function ajaxRemoveDadosBancarios() {

        $dados_bancarios_id = request('dados_bancarios_id');
        $pessoa_id = request('pessoa_id');

        $dados_bancarios = DadoBancario::find($dados_bancarios_id);
        $pessoa = PessoaJuridica::find($pessoa_id);

        try {
            $pessoa->dados_bancarios()->detach($dados_bancarios_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        try {
            $dados_bancarios->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $todos_dados_bancarios = $pessoa->dados_bancarios()->get();
        return $todos_dados_bancarios;
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

                $pessoa_id = $_REQUEST['pessoa_id'];

                $diretorio = base_path() . "/public/uploads/pessoas_juridicas/$pessoa_id/";

                // cria diretório se não existir
                if(!is_dir($diretorio)) mkdir($diretorio);

                move_uploaded_file(
                    $_FILES['arquivo']['tmp_name'],
                    $diretorio . $nome_arquivo
                );

                $pessoa_juridica = PessoaJuridica::find($pessoa_id);
                $pessoa_juridica->arquivos()->attach($arquivo->id);

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
                    'arquivos' => $pessoa_juridica->arquivos()->get()
                ];

            }
        }

        return "Arquivo inválido";

    }
    
    public function removeArquivo($arquivo_id, $pessoa_id){

        $arquivo = Arquivo::find($arquivo_id);
        $pessoa_juridica = PessoaJuridica::find($pessoa_id);

        $caminho_arquivo = base_path() . "/public/uploads/pessoas_juridicas/$pessoa_id/" . $arquivo->nome;

        //Checa se arquivo relacionado tem destaque
        $destaque = PessoaJuridica::checaDestaque($pessoa_id, $arquivo_id);

        //Desabilita destaque se já existir
        $remove_destaque = false;
        if(!empty($destaque) && $destaque[0]->destaque == 1) {
            //Apaga outros thumbs
            $dir_thumbs = base_path() . "/public/thumbs/pessoas_juridicas/$pessoa_id";
            if($this->rmRecursivo($dir_thumbs)) {
                $remove_destaque = true;
            }
        }

        try {
            $pessoa_juridica->arquivos()->detach($arquivo_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        try {
            $arquivo->delete();
            unlink($caminho_arquivo);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $remove_destaque;
    }
    

    public function ajaxRemoveArquivo() {

        $arquivo_id = request('arquivo_id');
        $pessoa_id = request('pessoa_id');

        //removeArquivo() retorna true se remove destaque
        $remove_destaque = $this->removeArquivo($arquivo_id, $pessoa_id);

        $arquivos = PessoaJuridica::find($pessoa_id)->arquivos()->get();

        return [
            'arquivos' => $arquivos,
            'remove_destaque' => $remove_destaque,
        ];
    }

    public function ajaxSetImagemDestaque() {

        $pessoa_id = request('pessoa_id');
        $arquivo_id = request('arquivo_id');

        $pessoa_juridica = PessoaJuridica::find($pessoa_id);
        $arquivo = $pessoa_juridica->arquivos()->find($arquivo_id);
        $arquivos = $pessoa_juridica->arquivos()->get();

        //Dados para criação de thumbnail
        $nome_arquivo = $arquivo['nome'];
        $extensao = $arquivo['extensao'];
        $origem = base_path() . "/public/uploads/pessoas_juridicas/$pessoa_id/";
        $destino = base_path() . "/public/thumbs/pessoas_juridicas/$pessoa_id/";
        $dir_thumbs = base_path() . "/public/thumbs/pessoas_juridicas/$pessoa_id";

        //Checa se arquivo relacionado tem destaque
        $destaque = PessoaJuridica::checaDestaque($pessoa_id, $arquivo_id);

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

        if(!empty($pessoa_juridica) && $arquivo['tipo'] == 'imagem') {

            //Desabilita todos destaques das imagens relacionadas
            foreach($arquivos as $arquivos_pessoa_juridica) {
                if($arquivos_pessoa_juridica['tipo'] == 'imagem') {
                    $arquivos_pessoa_juridica->pivot->destaque = null;
                    $arquivos_pessoa_juridica->pivot->save();
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

        $destaque = PessoaJuridica::find(request('pessoa_id'))->arquivos()->where('destaque', 1)->first();
        return !empty($destaque) ? $destaque : "Destaque indisponível";

    }

}
