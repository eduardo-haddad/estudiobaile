<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DadoBancario extends Model
{
    protected $table = 'dados_bancarios';

    protected $fillable = [
        'nome_banco',
        'agencia',
        'conta'
    ];

    public function tipo_conta_bancaria()
    {
        return $this->belongsTo('App\TipoContaBancaria');
    }

    public function pessoas_fisicas()
    {
        return $this->belongsToMany('App\PessoaFisica', 'pessoa_dados_bancarios', 'dado_bancario_id', 'pessoa_fisica_id');
    }

    public function pessoas_juridicas()
    {
        return $this->belongsToMany('App\PessoaJuridica', 'pessoa_dados_bancarios', 'dado_bancario_id', 'pessoa_juridica_id');
    }
}
