<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContato extends Model
{
    protected $table = 'tipos_contato';

    protected $fillable = [
        'nome'
    ];
    
    public function contatos() 
    {
        return $this->hasMany('App\Contato');
    }
}
