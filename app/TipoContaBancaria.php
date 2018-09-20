<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContaBancaria extends Model
{
    protected $table = 'tipos_conta_bancaria';

    protected $fillable = [
        'valor'
    ];

    public function dados_bancarios()
    {
        return $this->hasMany('App\DadoBancario');
    }
}
