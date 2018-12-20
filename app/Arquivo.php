<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    protected $table = 'arquivos';

    protected $fillable = [
        'nome',
        'deleted'
    ];

    public function pessoas_fisicas()
    {
        return $this->belongsToMany('App\PessoaFisica', 'arquivos_relacionados', 'arquivo_id', 'pessoa_fisica_id');
    }

    public function pessoas_juridicas()
    {
        return $this->belongsToMany('App\PessoaJuridica', 'arquivos_relacionados', 'arquivo_id', 'pessoa_juridica_id');
    }

    public function projetos()
    {
        return $this->belongsToMany('App\Projeto', 'arquivos_relacionados', 'arquivo_id', 'projeto_id');
    }

    public function usuarios()
    {
        return $this->belongsToMany('App\User', 'arquivos_relacionados', 'arquivo_id', 'usuario_id');
    }

    public function interna()
    {
        return $this->belongsToMany('App\User', 'arquivos_relacionados', 'arquivo_id', 'interna_id');
    }

}
