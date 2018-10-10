<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['text'];

    //Relacionamentos

    public function pessoas_fisicas()
    {
        return $this->belongsToMany('App\PessoaFisica', 'pessoa_tag', 'tag_id', 'pessoa_fisica_id');
    }

    public function pessoas_juridicas()
    {
        return $this->belongsToMany('App\PessoaJuridica', 'pessoa_tag', 'tag_id', 'pessoa_juridica_id');
    }

    public static function getTagsNaoAtribuidas()
    {
        return \DB::select("
          SELECT id FROM tags
          WHERE id NOT IN (
            SELECT Tags.id FROM tags Tags
            INNER JOIN pessoa_tag PessoaTag
            ON Tags.id = PessoaTag.tag_id
          )
        ");
    }
}
