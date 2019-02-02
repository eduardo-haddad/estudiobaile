<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $table = 'projetos';

    protected $fillable = [
        'nome', 
        'dt_inicio', 
        'dt_fim', 
        'criado_por', 
        'modificado_por'
    ];

    public function pessoas_fisicas()
    {
        return $this->belongsToMany('App\PessoaFisica', 'pf_projeto', 'projeto_id', 'pessoa_fisica_id');
    }
    
    public function pessoas_juridicas()
    {
        return $this->belongsToMany('App\PessoaJuridica', 'pj_projeto', 'projeto_id', 'pessoa_juridica_id');
    }

    public function arquivos()
    {
        return $this->belongsToMany('App\Arquivo', 'arquivos_relacionados', 'projeto_id', 'arquivo_id');
    }

    public static function getChancelaPorId($projeto_id, $pessoa_fisica_id) {
        return \DB::select("
            SELECT Chancela.id
            FROM chancelas Chancela
              INNER JOIN pf_projeto PfProjeto
                ON PfProjeto.tag_id = Chancela.id
              INNER JOIN projetos Projeto
                ON Projeto.id = PfProjeto.projeto_id
              WHERE Projeto.id = $projeto_id AND PfProjeto.pessoa_fisica_id = $pessoa_fisica_id
        ");
    }

    public static function getPessoasDeProjetos($projeto_id, $pessoa_fisica = null, $pessoa_juridica = null) {

        if(!empty($pessoa_fisica) && empty($pessoa_juridica)) {
            $pessoa_nome = 'nome_adotado';
            $pessoa_tabela = 'pessoas_fisicas';
            $pessoa_tabela_assoc = 'pf_projeto';
            $pessoa_chave = 'pessoa_fisica_id';
        } else if(empty($pessoa_fisica) && !empty($pessoa_juridica)) {
            $pessoa_nome = 'nome_fantasia';
            $pessoa_tabela = 'pessoas_juridicas';
            $pessoa_tabela_assoc = 'pj_projeto';
            $pessoa_chave = 'pessoa_juridica_id';
        } else {
            return "Pessoa inválida";
        }

        return \DB::select("
            SELECT
                Pessoa.$pessoa_nome AS nome,
                Pessoa.id AS pessoa_id,
                Projeto.nome AS projeto,
                Projeto.id AS projeto_id,
                Tag.text AS tag,
                Tag.id AS tag_id
            FROM $pessoa_tabela Pessoa
                LEFT JOIN $pessoa_tabela_assoc PessoaProjeto
                ON Pessoa.id = PessoaProjeto.$pessoa_chave
                INNER JOIN projetos Projeto
                ON Projeto.id = PessoaProjeto.projeto_id AND Projeto.id = $projeto_id
                INNER JOIN tags Tag
                ON Tag.id = PessoaProjeto.tag_id
            ORDER BY Pessoa.$pessoa_nome
        ");
    }

    public static function removeChancelaDeProjeto($projeto_id, $tag_id, $pessoa_fisica_id = null, $pessoa_juridica_id = null) {

        if(!empty($pessoa_fisica_id) && empty($pessoa_juridica_id)){
            $pessoa_tabela = "pf_projeto";
            $pessoa_chave = "pessoa_fisica_id";
            $pessoa_id = $pessoa_fisica_id;
        } else if(!empty($pessoa_juridica_id) && empty($pessoa_fisica_id)) {
            $pessoa_tabela = "pj_projeto";
            $pessoa_chave = "pessoa_juridica_id";
            $pessoa_id = $pessoa_juridica_id;
        } else {
            return "Pessoa inválida";
        }

        try {
            \DB::select("
            DELETE FROM $pessoa_tabela
            WHERE $pessoa_chave = $pessoa_id
                AND projeto_id = $projeto_id
                AND tag_id = $tag_id
        ");
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    public static function checaDestaque($projeto_id, $arquivo_id) {
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


}
