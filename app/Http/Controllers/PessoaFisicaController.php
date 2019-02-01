<?php

namespace App\Http\Controllers;

use App\DadoBancario;
use App\PessoaJuridica;
use Illuminate\Http\Request;
use App\PessoaFisica;
use App\TipoContato;
use App\Contato;
use App\Projeto;
use App\Genero;
use App\EstadoCivil;
use App\Endereco;
use App\TipoContaBancaria;
use App\Tag;
use App\Arquivo;
use Session;
use DB;

class PessoaFisicaController extends Controller
{

    public function ajaxIndex()
    {
        return PessoaFisica::select('id', 'nome_adotado')->orderBy('nome_adotado')->get();
    }

    public function ajaxCreate(Request $request)
    {
        if(!empty(request('nome_adotado'))) {

            $pessoa_fisica = PessoaFisica::create([
                'nome_adotado' => request('nome_adotado'),
                'criado_por' => $request->user()->name,
                'modificado_por' => $request->user()->name
            ]);

            return $pessoa_fisica['id'];

        }

        return "Não foi possível criar pessoa física";

    }


    public function ajaxView($id)
    {
        $pessoa_fisica = PessoaFisica::find($id);
        $pessoas_juridicas_relacionadas = PessoaFisica::getPessoasJuridicasRelacionadasPorId($id);

        //Contatos
        $contatos = $pessoa_fisica->contatos()->get();

        //Endereços
        $enderecos = $pessoa_fisica->enderecos()->get();

        //Arquivos
        $arquivos = $pessoa_fisica->arquivos()->get();

        //Pessoas Jurídicas
        //$pessoas_juridicas = PessoaFisica::getPessoasJuridicasRelacionadasPorId($id);

        //Dados Bancários
        $dados_bancarios = $pessoa_fisica->dados_bancarios()->get();

        //Tags
        $tags = Tag::select('id', 'text')->where('tipo', 'tag')->orderBy('text')->get();

        //Estado Civil
        $estado_civil = !empty($pessoa_fisica->estado_civil_id) ? EstadoCivil::find($pessoa_fisica->estado_civil_id)->valor : null;

        //Projetos
        $projetos = PessoaFisica::getProjetosChancelasPorId($id);


        return [
            'pessoa_fisica' => $pessoa_fisica,
            'estado_civil' => $estado_civil,
            'contatos' => $contatos,
            'enderecos' => $enderecos,
            'arquivos' => $arquivos,
            'dados_bancarios' => $dados_bancarios,
            'tags' => $tags,
            'pessoas_juridicas_relacionadas' => $pessoas_juridicas_relacionadas,
            'projetos' => $projetos,
            'atributos' => [
                'pessoas_juridicas' => PessoaJuridica::select('id', 'nome_fantasia')->orderBy('nome_fantasia')->get(),
                'cargos_pj' => Tag::select('id', 'text')->where('tipo', 'cargo')->orderBy('text')->get(),
                'tipos_contato' => TipoContato::all(),
                'generos' => Tag::select('id', 'text')->where('tipo', 'genero')->orderBy('text')->get(),
                'estados_civis' => EstadoCivil::all(),
                'tipos_conta_bancaria' => TipoContaBancaria::all()
            ]
        ];
    }

    public function ajaxSave(Request $r) {

        $request['pessoa'] = request('pessoa');
        $request['contatos'] = request('contatos');
        $request['enderecos'] = request('enderecos');
        $request['arquivos'] = request('arquivos');
        $request['dados_bancarios'] = request('dados_bancarios');
        $request['tags'] = request('tags');
        $request['genero'] = request('genero');

        //Pessoa Física
        $pessoa_fisica = PessoaFisica::find($request['pessoa']['id']);

        foreach(json_decode($pessoa_fisica) as $chave => $valor):
            if($chave == "modificado_por") {
                $pessoa_fisica->$chave = $r->user()->name;
            } else if($chave == "estado_civil_id" && empty($valor)){
                $pessoa_fisica->$chave = null;
            } else if($chave == "genero" && !empty($request['genero'])){
                if(substr($request['genero'], 0, 4) == 'new:'){
                    $tag_criada = Tag::criaTags($request['genero'], 'genero');
                    $pessoa_fisica->$chave = is_array($tag_criada) ? $tag_criada[0] : $tag_criada;
                } else {
                    $pessoa_fisica->$chave = $request['genero'];
                }
            } else {
                $pessoa_fisica->$chave = $request['pessoa'][$chave];
            }
        endforeach;

        $pessoa_fisica->save();

        //Contatos
        foreach($request['contatos'] as $i => $contato):
            $contato = Contato::find($request['contatos'][$i]['id']);
            $contato->valor = $request['contatos'][$i]['valor'];
            $contato->save();
        endforeach;

        //Endereços
        foreach($request['enderecos'] as $j => $endereco):
            $endereco_atual = Endereco::find($endereco['id']);
            foreach(json_decode($endereco_atual) as $key => $value):
                if(!empty($request['enderecos'][$j][$key])) {
                    $endereco_atual->$key = $request['enderecos'][$j][$key];
                }
            endforeach;
            $endereco_atual->save();
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


        //Tags
        if(empty($request['tags'])) {
            $pessoa_fisica->tags()->detach();
        } else {
            $pessoa_fisica->tags()->sync(Tag::criaTags($request['tags'], 'tag'));
        }
        //Deleta tags não atribuídas a ninguém
        $tags_nao_atribuidas = array_map(function($t){ return $t->id; }, Tag::getTagsNaoAtribuidas());
        if(!empty($tags_nao_atribuidas)){
            \DB::table('tags')->whereIn('id', $tags_nao_atribuidas)->delete();
        }

        return $pessoa_fisica;
    }

    public function ajaxDelete() {

        $pessoa = PessoaFisica::find(request('pessoa'));

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

        //Pessoas Jurídicas
        $pj_relacionadas = PessoaFisica::getPessoasJuridicasRelacionadasPorId(request('pessoa'));
        if(!empty($pj_relacionadas)){
            foreach($pj_relacionadas as $pj){
                PessoaFisica::removeChancelaPj($pj->tag_id, request('pessoa'), $pj->pessoa_juridica_id);
            }
        }

        //Projetos
        $projetos = $pessoa->projetos()->get();
        if(!$projetos->isEmpty()){
            foreach($projetos as $projeto){
                $pessoas_projeto = Projeto::getPessoasDeProjetos($projeto['id'], true, null);
                foreach($pessoas_projeto as $pessoa_projeto){
                    Projeto::removeChancelaDeProjeto($projeto['id'], $pessoa_projeto->tag_id, request('pessoa'), null);
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

        return $this->ajaxIndex();

    }

    public function ajaxAddContato() {

        $request['email'] = request('email');
        $request['telefone'] = request('telefone');

        if(empty($request['email']) && empty($request['telefone'])) {
            return "Contato inválido";
        }

        $contato = new Contato();
        $contato->pessoa_fisica_id = request('pessoa_id');
        $contato->pessoa_juridica_id = 0;

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

        $pessoa_fisica = PessoaFisica::find(request('pessoa_id'));
        $contatos = $pessoa_fisica->contatos()->get();

//        $contatos = PessoaFisica::getContatosPessoaFisicaPorId(request('pessoa_id'));


        return $contatos;
    }

    public function ajaxRemoveContato(Request $r) {

        $contato_id = request('contato_id');

        $contato = Contato::find($contato_id);
        $contato->delete();

        $pessoa_fisica = PessoaFisica::find(request('pessoa_id'));
        $contatos = $pessoa_fisica->contatos()->get();

//        $contatos = PessoaFisica::getContatosPessoaFisicaPorId($pessoa_id);

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

        $pessoa = PessoaFisica::find($pessoa_id);
        $pessoa->enderecos()->attach($novo_endereco->id);

        $enderecos = $pessoa->enderecos()->get();

        return $enderecos;
    }

    public function ajaxRemoveEndereco() {

        $endereco_id = request('endereco_id');
        $pessoa_id = request('pessoa_id');

        $endereco = Endereco::find($endereco_id);
        $pessoa_fisica = PessoaFisica::find($pessoa_id);

        try {
            $pessoa_fisica->enderecos()->detach($endereco_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        try {
            $endereco->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $enderecos = $pessoa_fisica->enderecos()->get();

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

        $pessoa = PessoaFisica::find($pessoa_id);
        $pessoa->dados_bancarios()->attach($novos_dados_bancarios->id);

        $todos_dados_bancarios = $pessoa->dados_bancarios()->get();
        return $todos_dados_bancarios;
    }


    public function ajaxRemoveDadosBancarios() {

        $dados_bancarios_id = request('dados_bancarios_id');
        $pessoa_id = request('pessoa_id');

        $dados_bancarios = DadoBancario::find($dados_bancarios_id);
        $pessoa = PessoaFisica::find($pessoa_id);

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

    public function ajaxGetTags() {

        return Tag::select('id', 'text')->orderBy('text')->get();

    }

    public function ajaxGetTagsSelecionadas($id) {

        $pessoa = PessoaFisica::find($id);
        $tags = $pessoa->tags()->orderBy('text')->get();

        $tags_ids = array();
        foreach($tags as $tag) array_push($tags_ids, $tag['id']);

        return $tags_ids;

    }

    public function ajaxGetGeneroSelecionado($id) {
        $pessoa = PessoaFisica::find($id);
        return $pessoa->genero;
    }

    public function ajaxAddCargoPj() {

        $cargo = request('novo_cargo');
        $pessoa_fisica_id = request('pessoa_fisica_id');
        $pessoa_juridica_id = request('pessoa_juridica_id');

        if(!empty($cargo) && !empty($pessoa_juridica_id)) {

            if(substr($cargo, 0, 4) == 'new:'){
                $novo_cargo = strtolower(substr($cargo,4));
                $tagObj = Tag::where('text', $novo_cargo)->first();
                if(empty($tagObj)){
                    $novo_cargo = Tag::create(['text' => $novo_cargo, 'tipo' => 'cargo']);
                    $cargo = $novo_cargo->id;
                }
            }
            $pessoa_juridica = PessoaJuridica::find($pessoa_juridica_id);
            $pessoa_juridica->pessoas_fisicas()->attach(PessoaFisica::find($pessoa_fisica_id), ['tag_id' => $cargo]);
        } else {
            return "Cargo inválido";
        }

        return [ PessoaFisica::getPessoasJuridicasRelacionadasPorId($pessoa_fisica_id), Tag::select('id', 'text')->where('tipo', 'cargo')->orderBy('text')->get() ];

    }

    public function ajaxRemoveChancelaPj() {

        $chancela = request('chancela');
        $pessoa_fisica_id = request('pessoa_fisica_id');
        $pessoa_juridica_id = request('pessoa_juridica_id');

        if(PessoaFisica::removeChancelaPj($chancela, $pessoa_fisica_id, $pessoa_juridica_id)){
            return PessoaFisica::getPessoasJuridicasRelacionadasPorId($pessoa_fisica_id);
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
                $extensao = strtolower($extensao);
                $tipo = $this->getTipoArquivo($extensao);

                $arquivo = new Arquivo();
                $arquivo->nome = $nome_arquivo;
                $arquivo->tipo = $tipo;
                $arquivo->descricao = $_REQUEST['descricao_arquivo'];
                $arquivo->extensao = $extensao;
                $arquivo->data = date('Y M d H:i');
                $arquivo->save();

                $pessoa_id = $_REQUEST['pessoa_id'];

                $diretorio = base_path() . "/public/uploads/pessoas_fisicas/$pessoa_id/";

                // cria diretório se não existir
                if(!is_dir($diretorio)) mkdir($diretorio);

                move_uploaded_file(
                    $_FILES['arquivo']['tmp_name'],
                    $diretorio . $nome_arquivo
                );

                $pessoa_fisica = PessoaFisica::find($pessoa_id);
                $pessoa_fisica->arquivos()->attach($arquivo->id);

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
                    'arquivos' => $pessoa_fisica->arquivos()->get()
                ];

            }
        }

        return "Arquivo inválido";

    }

    public function removeArquivo($arquivo_id, $pessoa_id) {

        $arquivo = Arquivo::find($arquivo_id);
        $pessoa_fisica = PessoaFisica::find($pessoa_id);

        $caminho_arquivo = base_path() . "/public/uploads/pessoas_fisicas/$pessoa_id/" . $arquivo->nome;

        //Checa se arquivo relacionado tem destaque
        $destaque = PessoaFisica::checaDestaque($pessoa_id, $arquivo_id);

        //Desabilita destaque se já existir
        $remove_destaque = false;
        if(!empty($destaque) && $destaque[0]->destaque == 1) {
            //Apaga outros thumbs
            $dir_thumbs = base_path() . "/public/thumbs/pessoas_fisicas/$pessoa_id";
            if($this->rmRecursivo($dir_thumbs)) {
                $remove_destaque = true;
            }
        }

        try {
            $pessoa_fisica->arquivos()->detach($arquivo_id);
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

        $arquivos = PessoaFisica::find($pessoa_id)->arquivos()->get();

        return [
            'arquivos' => $arquivos,
            'remove_destaque' => $remove_destaque,
        ];
    }

    public function ajaxSetImagemDestaque() {

        $pessoa_id = request('pessoa_id');
        $arquivo_id = request('arquivo_id');

        $pessoa_fisica = PessoaFisica::find($pessoa_id);
        $arquivo = $pessoa_fisica->arquivos()->find($arquivo_id);
        $arquivos = $pessoa_fisica->arquivos()->get();

        //Dados para criação de thumbnail
        $nome_arquivo = $arquivo['nome'];
        $extensao = $arquivo['extensao'];
        $origem = base_path() . "/public/uploads/pessoas_fisicas/$pessoa_id/";
        $destino = base_path() . "/public/thumbs/pessoas_fisicas/$pessoa_id/";
        $dir_thumbs = base_path() . "/public/thumbs/pessoas_fisicas/$pessoa_id";

        //Checa se arquivo relacionado tem destaque
        $destaque = PessoaFisica::checaDestaque($pessoa_id, $arquivo_id);

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

        if(!empty($pessoa_fisica) && $arquivo['tipo'] == 'imagem') {

            //Desabilita todos destaques das imagens relacionadas
            foreach($arquivos as $arquivos_pessoa_fisica) {
                if($arquivos_pessoa_fisica['tipo'] == 'imagem') {
                    $arquivos_pessoa_fisica->pivot->destaque = null;
                    $arquivos_pessoa_fisica->pivot->save();
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

        $destaque = PessoaFisica::find(request('pessoa_id'))->arquivos()->where('destaque', 1)->first();
        return !empty($destaque) ? $destaque : "Destaque indisponível";

    }
    


}
