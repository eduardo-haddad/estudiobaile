<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'contatos';

    protected $fillable = [
        'valor', 
        'tipo_contato_id', 
        'pessoa_fisica_id', 
        'pessoa_juridica_id'
    ];

    public function tipoContato() 
    {
        return $this->belongsTo('App\TipoContato');
    }

    public function pessoas_fisicas() 
    {
        return $this->belongsTo('App\PessoaFisica');
    }
    
    public function pessoas_juridicas() 
    {
        return $this->belongsTo('App\PessoaJuridica');
    }
}
