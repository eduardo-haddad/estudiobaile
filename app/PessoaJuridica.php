<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaJuridica extends Model
{
    protected $table = 'pessoas_juridicas';

    protected $fillable = [
        'nome_fantasia', 
        'razao_social', 
        'cpf', 
        'cnpj',
        'website',
        'dados_bancarios', 
        'criado_por', 
        'modificado_por'
    ];

    public function contatos() 
    {
        return $this->hasMany('App\Contato');
    }

    public function projetos()
    {
        return $this->belongsToMany('App\Projeto', 'pj_projeto', 'pessoa_juridica_id', 'projeto_id');
    }

    public function pessoas_fisicas()
    {
        return $this->belongsToMany('App\PessoaFisica', 'pf_pj', 'pessoa_juridica_id', 'pessoa_fisica_id');
    }

    public function categorias()
    {
        return $this->belongsToMany('App\Categoria', 'pessoa_categoria', 'pessoa_juridica_id', 'categoria_id');
    }

    public function enderecos()
    {
        return $this->belongsToMany('App\Endereco', 'pessoa_endereco', 'pessoa_juridica_id', 'endereco_id');
    }

    public function arquivos()
    {
        return $this->belongsToMany('App\Arquivo', 'arquivos_relacionados', 'pessoa_juridica_id', 'arquivo_id');
    }

    public function dados_bancarios()
    {
        return $this->belongsToMany('App\DadoBancario', 'pessoa_dados_bancarios', 'pessoa_juridica_id', 'dado_bancario_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'pessoa_tag', 'pessoa_juridica_id', 'tag_id');
    }

    public static function getPessoasFisicasRelacionadas($id) {

        return \DB::select("
            SELECT 
              PessoaFisica.id AS pessoa_fisica_id,
              PessoaFisica.nome_adotado AS pessoa_fisica_nome_adotado,
              Tag.text AS tag,
              Tag.id AS tag_id
            FROM 
              pessoas_fisicas PessoaFisica
              LEFT JOIN pf_pj PessoaFisicaJuridica
              ON PessoaFisicaJuridica.pessoa_fisica_id = PessoaFisica.id 
                AND PessoaFisicaJuridica.pessoa_juridica_id = $id
              INNER JOIN tags Tag
              ON Tag.id = PessoaFisicaJuridica.tag_id
            ORDER BY PessoaFisica.nome_adotado
        ");
    }

    public static function removeCargoPf($tag_id, $pessoa_fisica_id, $pessoa_juridica_id) {

        try {
            \DB::select("
            DELETE FROM pf_pj
            WHERE tag_id = $tag_id
                AND pessoa_fisica_id = $pessoa_fisica_id
                AND pessoa_juridica_id = $pessoa_juridica_id
        ");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }


    public static function getProjetosChancelasPorId($pessoa_juridica_id) {
        return \DB::select("
            SELECT 
                Projeto.nome AS projeto,
                Projeto.id AS id,
                Tag.text AS chancela,
                Tag.id AS chancela_id
            FROM projetos Projeto
                INNER JOIN pj_projeto PfProjeto
                ON PfProjeto.projeto_id = Projeto.id AND PfProjeto.pessoa_juridica_id = $pessoa_juridica_id
                INNER JOIN tags Tag
                ON Tag.id = PfProjeto.tag_id
            ORDER BY Projeto.dt_inicio DESC, chancela
        ");
    }

    public static function checaDestaque($pessoa_id, $arquivo_id) {
        return \DB::select("
            SELECT 
                ArquivosRelacionados.destaque
            FROM arquivos Arquivos
                INNER JOIN arquivos_relacionados ArquivosRelacionados
                ON Arquivos.id = ArquivosRelacionados.arquivo_id 
                  AND ArquivosRelacionados.pessoa_juridica_id = $pessoa_id
            WHERE ArquivosRelacionados.arquivo_id = $arquivo_id
            LIMIT 1
        ");
    }


}
