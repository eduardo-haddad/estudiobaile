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
}
