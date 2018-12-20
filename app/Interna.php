<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interna extends Model
{
    protected $table = 'interna';

    protected $fillable = [
        'valor'
    ];

    public function arquivos()
    {
        return $this->belongsToMany('App\Arquivo', 'arquivos_relacionados', 'interna_id', 'arquivo_id');
    }
}
