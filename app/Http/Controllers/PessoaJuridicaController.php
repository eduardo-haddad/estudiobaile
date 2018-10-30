<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaJuridica;
use App\PessoaFisica;
use App\Tag;
use App\Cargo;

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

        //Tags
        $tags = Tag::all();

        return [
            'pessoa_juridica' => $pessoa_juridica,
            'tags' => $tags,
            'pessoas_fisicas_cargos_relacionados' => $pessoas_fisicas_cargos_relacionados,
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

}
