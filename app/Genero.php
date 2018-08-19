<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    protected $table = 'generos';

    protected $fillable = [
        'valor'
    ];

    public function pessoas_fisicas()
    {
        return $this->hasMany('App\PessoaFisica', 'genero_id');
    }
}
