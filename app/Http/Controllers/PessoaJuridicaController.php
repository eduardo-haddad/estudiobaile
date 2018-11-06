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

class PessoaJuridicaController extends Controller
{
    public function ajaxIndex()
    {
        return (new PessoaJuridica)->orderBy('nome_fantasia')->get();
    }


    public function ajaxView($id)
    {
        $pessoa_juridica = (new PessoaJuridica)->find($id);
        $pessoas_fisicas = PessoaFisica::all();
        $pessoas_fisicas_cargos_relacionados = PessoaJuridica::getPessoasFisicasRelacionadas($id);
        $cargos_pf = Cargo::all();

        //Contatos
        $contatos = $pessoa_juridica->contatos()->get();

        //Endereços
        $enderecos = $pessoa_juridica->enderecos()->get();

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
            'projetos' => $projetos,
            'atributos' => [
                'cargos_pf' => $cargos_pf,
                'pessoas_fisicas' => $pessoas_fisicas,
            ]
        ];
    }

    public function ajaxSave(Request $r) {

        $request['pessoa'] = request('pessoa');
        $request['tags'] = request('tags');

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

    public function ajaxGetTagsSelecionadas($id) {
        $pessoa = (new PessoaJuridica)->find($id);
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

        $pessoa_juridica = (new PessoaJuridica)->find($pessoa_id);
        $pessoa_juridica->dados_bancarios()->attach($novos_dados_bancarios->id);

        $todos_dados_bancarios = $pessoa_juridica->dados_bancarios()->get();
        return $todos_dados_bancarios;
    }


    public function ajaxRemoveDadosBancarios() {

        $dados_bancarios_id = request('dados_bancarios_id');
        $pessoa_id = request('pessoa_id');

        $dados_bancarios = (new DadoBancario)->find($dados_bancarios_id);
        $pessoa = (new PessoaFisica)->find($pessoa_id);

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

}
