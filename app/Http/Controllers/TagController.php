<?php

namespace App\Http\Controllers;

use App\PessoaFisica;
use App\PessoaJuridica;
use App\Projeto;
use Illuminate\Http\Request;
use DB;
use App\Tag;

class TagController extends Controller
{

    public function ajaxIndex()
    {
        return Tag::select('id', 'text')->orderBy('text')->get();
    }


    public function ajaxView($id)
    {
        $tag = Tag::find($id);
        $pessoas_relacionadas = null;
        $pf_relacionadas = null;
        $pj_relacionadas = null;

        if(!empty($tag) && $tag->tipo == "tag") {
            return [
                'tag' => $tag,
                'pessoas_fisicas_relacionadas' => Tag::pessoasRelacionadas($id, "pessoa_fisica"),
                'pessoas_juridicas_relacionadas' => Tag::pessoasRelacionadas($id, "pessoa_juridica")
            ];

        } else if(!empty($tag) && $tag->tipo == "cargo") {
            $pf_pj_relacionados = Tag::getIdsPessoasRelacionadasCargo($id);
            foreach($pf_pj_relacionados as $pf_pj) {
                $pessoas_relacionadas[] = [
                    'pessoa_fisica' => PessoaFisica::find($pf_pj->pessoa_fisica_id),
                    'pessoa_juridica' => PessoaJuridica::find($pf_pj->pessoa_juridica_id),
                ];
            }
            return [
                'tag' => $tag,
                'pessoas_relacionadas' => $pessoas_relacionadas,
            ];

        } else if(!empty($tag) && $tag->tipo == "chancela") {
            $pf_relacionadas_ids = Tag::getIdsPfRelacionadasChancela($id);
            $pj_relacionadas_ids = Tag::getIdsPjRelacionadasChancela($id);

            foreach($pf_relacionadas_ids as $pf){
                $pf_relacionadas[] = [
                    'id' => $pf->id,
                    'nome_adotado' => $pf->nome_adotado,
                    'projeto_nome' => $pf->projeto_nome,
                    'projeto_id' => $pf->projeto_id
                ];
            }
            foreach($pj_relacionadas_ids as $pj){
                $pj_relacionadas[] = [
                    'id' => $pj->id,
                    'nome_fantasia' => $pj->nome_fantasia,
                    'projeto_nome' => $pj->projeto_nome,
                    'projeto_id' => $pj->projeto_id
                ];
            }

            return [
                'tag' => $tag,
                'pessoas_fisicas_relacionadas' => $pf_relacionadas,
                'pessoas_juridicas_relacionadas' => $pj_relacionadas,
            ];

        }

        return "tipo de tag inválido";

    }


    public function ajaxSave(Request $r) {

        $request['tag'] = request('tag');
        $request['tag_id'] = request('tag_id');

        $tag = Tag::find($request['tag_id']);

        if($request['tag']['id'] == $request['tag_id']){
            foreach(json_decode($tag) as $chave => $valor):
                if($chave == "modificado_por") {
                    $tag->$chave = $r->user()->name;
                }
                else {
                    if(!empty($request['tag'][$chave])) {
                        $tag->$chave = $request['tag'][$chave];
                    }
                }
            endforeach;

            $tag->save();

        } else {
            return "id do objeto: " . $request['tag']['id'] . " -- não confere com id atual: " . $request['tag_id'];
        }

        return $this->ajaxIndex();
    }

    public function ajaxRemoveTag($id) {

        $pessoa_id = request('pessoa_id');

        if(request('pessoa_tipo') == 1)
            $pessoa = PessoaFisica::find($pessoa_id);
        else
            $pessoa = PessoaJuridica::find($pessoa_id);

        $pessoa->tags()->detach($id);

        //Deleta tags não atribuídas a ninguém
        Tag::removeTagsNaoAtribuidas();

        return [
            'empty' => !(Tag::where('id', $id)->exists()),
            'index' => $this->ajaxIndex()
        ];

    }

    public function ajaxRemoveCargo() {
        $tag_id = request('tag_id');
        $pessoa_fisica_id = request('pessoa_fisica_id');
        $pessoa_juridica_id = request('pessoa_juridica_id');

        if(PessoaFisica::removeChancelaPj($tag_id, $pessoa_fisica_id, $pessoa_juridica_id)){
            //Deleta tags não atribuídas a ninguém
            Tag::removeTagsNaoAtribuidas();

            return [
                'empty' => !(Tag::where('id', $tag_id)->exists()),
                'index' => $this->ajaxIndex()
            ];
        }
        return false;
    }

    public function ajaxRemoveChancela() {

        $tag_id = request('tag_id');
        $pessoa_fisica_id = request('pessoa_fisica_id');
        $pessoa_juridica_id = request('pessoa_juridica_id');
        $projeto_id = request('projeto_id');

        if(Projeto::removeChancelaDeProjeto($projeto_id, $tag_id, $pessoa_fisica_id, $pessoa_juridica_id)){
            //Deleta tags não atribuídas a ninguém
            Tag::removeTagsNaoAtribuidas();

            return [
                'empty' => !(Tag::where('id', $tag_id)->exists()),
                'index' => $this->ajaxIndex()
            ];
        }
        return false;
    }

}
