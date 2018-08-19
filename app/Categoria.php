<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nome', 
        'criado_por', 
        'modificado_por'
    ];

    public function pessoas_fisicas()
    {
        return $this->belongsToMany('App\PessoaFisica', 'pessoa_categoria', 'categoria_id', 'pessoa_fisica_id');
    }

    public function pessoas_juridicas()
    {
        return $this->belongsToMany('App\PessoaJuridica', 'pessoa_categoria', 'categoria_id', 'pessoa_juridica_id');
    }
}
