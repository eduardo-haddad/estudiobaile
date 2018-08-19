<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';

    protected $fillable = [
        'cep', 
        'rua', 
        'numero', 
        'bairro',
        'cidade',
        'pais'
    ];

    public function pessoas_fisicas()
    {
        return $this->belongsToMany('App\PessoaFisica', 'pessoa_endereco', 'endereco_id', 'pessoa_fisica_id');
    }

    public function pessoas_juridicas()
    {
        return $this->belongsToMany('App\PessoaJuridica', 'pessoa_endereco', 'endereco_id', 'pessoa_juridica_id');
    }
}
