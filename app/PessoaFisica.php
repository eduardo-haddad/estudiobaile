<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaFisica extends Model
{
    protected $table = 'pessoas_fisicas';

    protected $fillable = [
        'nome', 
        'nome_adotado', 
        'cpf', 
        'rg', 
        'passaporte', 
        'dt_nascimento', 
        'dados_bancarios', 
        'criado_por', 
        'modificado_por', 
        'pessoa_juridica_id', 
        'projeto_id',
        'categoria_id',
        'endereco_id',
        'genero_id'
    ];

    public function contatos() 
    {
        return $this->hasMany('App\Contato');
    }

    public function projetos()
    {
        return $this->belongsToMany('App\Projeto', 'pf_projeto', 'pessoa_fisica_id', 'projeto_id');
    }
    
    public function pessoas_juridicas()
    {
        return $this->belongsToMany('App\PessoaJuridica', 'pf_pj', 'pessoa_fisica_id', 'pessoa_juridica_id');
    }

    public function categorias()
    {
        return $this->belongsToMany('App\Categoria', 'pessoa_categoria', 'pessoa_fisica_id', 'categoria_id');
    }

    public function enderecos()
    {
        return $this->belongsToMany('App\Endereco', 'pessoa_endereco', 'pessoa_fisica_id', 'endereco_id');
    }

    public function dados_bancarios()
    {
        return $this->belongsToMany('App\DadoBancario', 'pessoa_dados_bancarios', 'pessoa_fisica_id', 'dado_bancario_id');
    }

    public function genero()
    {
        return $this->belongsTo('App\Genero', 'genero_id');
    }

    public function estado_civil()
    {
        return $this->belongsTo('App\EstadoCivil', 'estado_civil_id');
    }
}
