<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['text', 'tipo'];

    //Relacionamentos

    public function pessoas_fisicas()
    {
        return $this->belongsToMany('App\PessoaFisica', 'pessoa_tag', 'tag_id', 'pessoa_fisica_id');
    }

    public function pessoas_juridicas()
    {
        return $this->belongsToMany('App\PessoaJuridica', 'pessoa_tag', 'tag_id', 'pessoa_juridica_id');
    }

    public static function getTagsNaoAtribuidas()
    {
        return \DB::select("
          SELECT id FROM tags
          WHERE id NOT IN (
            -- Tags PF/PJ
            SELECT Tags.id FROM tags Tags
            INNER JOIN pessoa_tag PessoaTag
            ON Tags.id = PessoaTag.tag_id AND Tags.tipo = 'tag'
            
            UNION DISTINCT
            
            -- Cargos PF/Pj relacionadas
            SELECT Tags.id FROM tags Tags
            INNER JOIN pf_pj PfPj
            ON Tags.id = PfPj.tag_id AND Tags.tipo = 'cargo'
            
            UNION DISTINCT
            
            -- Chancela PF/Projeto
            SELECT Tags.id FROM tags Tags
            INNER JOIN pf_projeto PfProjeto
            ON Tags.id = PfProjeto.tag_id AND Tags.tipo = 'chancela'
            
            UNION DISTINCT
            
            -- Chancela PJ/Projeto
            SELECT Tags.id FROM tags Tags
            INNER JOIN pj_projeto PjProjeto
            ON Tags.id = PjProjeto.tag_id AND Tags.tipo = 'chancela'
          )
        ");
    }

    public static function removeTagsNaoAtribuidas()
    {
        $tags_nao_atribuidas = array_map(function($t){ return $t->id; }, Tag::getTagsNaoAtribuidas());
        if(!empty($tags_nao_atribuidas)){
            \DB::table('tags')->whereIn('id', $tags_nao_atribuidas)->delete();
            return true;
        }
        return false;
    }


    public static function pessoasRelacionadas($id, $tipo) {

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

        return \DB::Select("
            SELECT $pessoa.id, $pessoa.$nome
                FROM tags Tag
                INNER JOIN pessoa_tag PessoaTag ON PessoaTag.tag_id = Tag.id
                INNER JOIN $tabela $pessoa ON $pessoa.id = PessoaTag.$chave
            WHERE Tag.id = $id
            ORDER BY $pessoa.$nome
        ");
    }

    public static function getIdsPessoasRelacionadasCargo($tag_id){
        return \DB::Select("
            SELECT 
              PfPj.pessoa_fisica_id AS pessoa_fisica_id, 
              PfPj.pessoa_juridica_id AS pessoa_juridica_id
            FROM tags Tag
            INNER JOIN pf_pj PfPj ON Tag.id = PfPj.tag_id
            LEFT JOIN pessoas_fisicas PessoaFisica ON PfPj.pessoa_fisica_id = PessoaFisica.id
            WHERE Tag.id = $tag_id
            ORDER BY PessoaFisica.nome_adotado
        ");

    }

    public static function getIdsPfRelacionadasChancela($tag_id){
        return \DB::Select("
            SELECT 
              PessoaFisica.pessoa_fisica_id AS id,
              Pf.nome_adotado AS nome_adotado,
              Projeto.nome AS projeto_nome,
              Projeto.id AS projeto_id
            FROM projetos Projeto
            LEFT JOIN pf_projeto PessoaFisica ON PessoaFisica.projeto_id = Projeto.id
            INNER JOIN tags Tag ON Tag.id = PessoaFisica.tag_id
            INNER JOIN pessoas_fisicas Pf ON PessoaFisica.pessoa_fisica_id = Pf.id
            WHERE Tag.id = $tag_id
            ORDER BY Pf.nome_adotado
        ");
    }
    public static function getIdsPjRelacionadasChancela($tag_id){
        return \DB::Select("
            SELECT 
              PessoaJuridica.pessoa_juridica_id AS id,
              Pj.nome_fantasia AS nome_fantasia,
              Projeto.nome AS projeto_nome,
              Projeto.id AS projeto_id
            FROM projetos Projeto
            LEFT JOIN pj_projeto PessoaJuridica ON PessoaJuridica.projeto_id = Projeto.id
            INNER JOIN tags Tag ON Tag.id = PessoaJuridica.tag_id
            INNER JOIN pessoas_juridicas Pj ON PessoaJuridica.pessoa_juridica_id = Pj.id
            WHERE Tag.id = $tag_id
            ORDER BY Pj.nome_fantasia
        ");
    }





}
