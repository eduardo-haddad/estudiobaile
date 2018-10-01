<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['valor'];

    //Relacionamentos

    public function pessoas_fisicas()
    {
        return $this->belongsToMany('App\PessoaFisica', 'pessoa_tag', 'tag_id', 'pessoa_fisica_id');
    }

    public function pessoas_juridicas()
    {
        return $this->belongsToMany('App\PessoaJuridica', 'pessoa_tag', 'tag_id', 'pessoa_juridica_id');
    }
}
