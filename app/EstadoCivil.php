<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    protected $table = 'estados_civis';

    protected $fillable = [
        'valor'
    ];

    public function pessoas_fisicas()
    {
        return $this->hasMany('App\PessoaFisica', 'estado_civil_id');
    }
}
