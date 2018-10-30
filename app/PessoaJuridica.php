<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaJuridica extends Model
{
    protected $table = 'pessoas_juridicas';

    protected $fillable = [
        'nome_fantasia', 
        'razao_social', 
        'cpf', 
        'cnpj',
        'website',
        'dados_bancarios', 
        'criado_por', 
        'modificado_por'
    ];

    public function contatos() 
    {
        return $this->hasMany('App\Contato');
    }

    public function projetos()
    {
        return $this->belongsToMany('App\Projeto', 'pj_projeto', 'pessoa_juridica_id', 'projeto_id');
    }

    public function pessoas_fisicas()
    {
        return $this->belongsToMany('App\PessoaFisica', 'pf_pj', 'pessoa_juridica_id', 'pessoa_fisica_id');
    }

    public function categorias()
    {
        return $this->belongsToMany('App\Categoria', 'pessoa_categoria', 'pessoa_juridica_id', 'categoria_id');
    }

    public function enderecos()
    {
        return $this->belongsToMany('App\Endereco', 'pessoa_endereco', 'pessoa_juridica_id', 'endereco_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'pessoa_tag', 'pessoa_juridica_id', 'tag_id');
    }

    public static function getPessoasFisicasRelacionadas($id) {

        return \DB::select("
            SELECT 
              PessoaFisica.id AS pessoa_fisica_id,
              PessoaFisica.nome_adotado AS pessoa_fisica_nome_adotado,
              Cargo.valor AS cargo
            FROM 
              pessoas_fisicas PessoaFisica
              LEFT JOIN pf_pj PessoaFisicaJuridica
              ON PessoaFisicaJuridica.pessoa_fisica_id = PessoaFisica.id 
                AND PessoaFisicaJuridica.pessoa_juridica_id = $id
              INNER JOIN cargos Cargo
              ON Cargo.id = PessoaFisicaJuridica.cargo_id
            ORDER BY PessoaFisica.nome_adotado
        ");
    }


}
