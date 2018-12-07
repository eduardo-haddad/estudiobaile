<?php

namespace App\Http\Controllers;

use App\PessoaFisica;
use App\PessoaJuridica;
use Illuminate\Http\Request;
use DB;
use App\Tag;

class TagController extends Controller
{

    public function ajaxIndex()
    {
        return Tag::orderBy('text')->get();
    }


    public function ajaxView($id)
    {
        $tag = Tag::find($id);

        $pessoas_fisicas_relacionadas = $this->pessoasRelacionadas($id, "pessoa_fisica");
        $pessoas_juridicas_relacionadas = $this->pessoasRelacionadas($id, "pessoa_juridica");

        return [
            'tag' => $tag,
            'pessoas_fisicas_relacionadas' => $pessoas_fisicas_relacionadas,
            'pessoas_juridicas_relacionadas' => $pessoas_juridicas_relacionadas
        ];
    }


    public function ajaxSave(Request $r) {

        $request['tag'] = request('tag');

        $tag = Tag::find($request['tag']['id']);

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

        return $tag;
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

        if(Tag::where('id', $id)->exists()) return "ok";

        return $this->ajaxIndex();

    }


    public function pessoasRelacionadas($id, $tipo) {

        switch($tipo):
            case 'pessoa_fisica':
                $pessoa = 'PessoaFisica';
                $nome = 'nome_adotado';
                $tabela = 'pessoas_fisicas';
                $chave = 'pessoa_fisica_id';
                break;
            case 'pessoa_juridica':
                $pessoa = 'PessoaJuridica';
                $nome = 'nome_fantasia';
                $tabela = 'pessoas_juridicas';
                $chave = 'pessoa_juridica_id';
                break;
            default:
                return 'Tipo de pessoa inválido';
        endswitch;

        return DB::Select("
            SELECT $pessoa.id, $pessoa.$nome
                FROM tags Tag
                INNER JOIN pessoa_tag PessoaTag ON PessoaTag.tag_id = Tag.id
                INNER JOIN $tabela $pessoa ON $pessoa.id = PessoaTag.$chave
            WHERE Tag.id = $id
        ");
    }



}
