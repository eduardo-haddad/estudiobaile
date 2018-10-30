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

    public static function getChancelaPorId($projeto_id, $pessoa_fisica_id) {
        return \DB::select("
            SELECT Chancela.id
            FROM chancelas Chancela
              INNER JOIN pf_projeto PfProjeto
                ON PfProjeto.chancela_id = Chancela.id
              INNER JOIN projetos Projeto
                ON Projeto.id = PfProjeto.projeto_id
              WHERE Projeto.id = $projeto_id AND PfProjeto.pessoa_fisica_id = $pessoa_fisica_id
        ");
    }

    public static function getPessoasFisicasDeProjetos($projeto_id) {
        return \DB::select("
            SELECT
                PessoaFisica.nome_adotado AS nome,
                PessoaFisica.id AS pessoa_fisica_id,
                Projeto.nome AS projeto,
                Chancela.valor AS chancela,
                Chancela.id AS chancela_id
            FROM pessoas_fisicas PessoaFisica
                LEFT JOIN pf_projeto PfProjeto
                ON PessoaFisica.id = PfProjeto.pessoa_fisica_id
                INNER JOIN projetos Projeto
                ON Projeto.id = PfProjeto.projeto_id AND Projeto.id = $projeto_id
                INNER JOIN chancelas Chancela
                ON Chancela.id = PfProjeto.chancela_id
            ORDER BY PessoaFisica.nome_adotado
        ");
    }

    public static function removeChancelaDeProjeto($projeto_id, $chancela_id, $pessoa_fisica_id = null, $pessoa_juridica_id = null) {

        if(!empty($pessoa_fisica_id) && empty($pessoa_juridica_id)){
            $pessoa_tabela = "pf_projeto";
            $pessoa_chave = "pessoa_fisica_id";
            $pessoa_id = $pessoa_fisica_id;
        } else if(!empty($pessoa_juridica_id) && empty($pessoa_fisica_id)) {
            $pessoa_tabela = "pj_projeto";
            $pessoa_chave = "pessoa_juridica_id";
            $pessoa_id = $pessoa_juridica_id;
        } else {
            return false;
        }

        try {
            \DB::select("
            DELETE FROM $pessoa_tabela
            WHERE $pessoa_chave = $pessoa_id
                AND projeto_id = $projeto_id
                AND chancela_id = $chancela_id
        ");
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }


}
