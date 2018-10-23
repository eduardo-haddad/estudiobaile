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

    public static function getCargoPorId($projeto_id, $pessoa_fisica_id) {
        return \DB::select("
            SELECT Cargo.id
            FROM cargos Cargo
              INNER JOIN pf_projeto PfProjeto
                ON PfProjeto.cargo_id = Cargo.id
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
                Cargo.valor AS cargo,
                Cargo.id AS cargo_id
            FROM pessoas_fisicas PessoaFisica
                LEFT JOIN pf_projeto PfProjeto
                ON PessoaFisica.id = PfProjeto.pessoa_fisica_id
                INNER JOIN projetos Projeto
                ON Projeto.id = PfProjeto.projeto_id AND Projeto.id = $projeto_id
                INNER JOIN cargos Cargo
                ON Cargo.id = PfProjeto.cargo_id
            ORDER BY PessoaFisica.nome_adotado
        ");
    }

    public static function removeCargoDeProjeto($projeto_id, $cargo_id, $pessoa_fisica_id = null, $pessoa_juridica_id = null) {

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
                AND cargo_id = $cargo_id
        ");
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }


}
