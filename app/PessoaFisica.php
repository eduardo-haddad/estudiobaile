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

    //Relacionamentos

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

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'pessoa_tag', 'pessoa_fisica_id', 'tag_id');
    }

    public function genero()
    {
        return $this->belongsTo('App\Genero', 'genero_id');
    }

    public function estado_civil()
    {
        return $this->belongsTo('App\EstadoCivil', 'estado_civil_id');
    }

    //Métodos - Helpers

    public static function getContatosPessoaFisicaPorId($id) {
        return \DB::select("
            SELECT 
                TipoContato.tipo, 
                Contatos.valor, 
                Contatos.id 
            FROM contatos Contatos
                INNER JOIN tipos_contato TipoContato
                ON Contatos.tipo_contato_id = TipoContato.id
                LEFT JOIN pessoas_fisicas PessoaFisica
                ON Contatos.pessoa_fisica_id = PessoaFisica.id
            WHERE PessoaFisica.id = $id
            ORDER BY Contatos.id ASC
        ");
    }

    public static function getPessoasJuridicasRelacionadasPorId($id) {
        return \DB::select("
            SELECT 
                PessoaJuridica.id,
                PessoaJuridica.nome_fantasia,
                PessoaJuridica.razao_social
            FROM pessoas_juridicas PessoaJuridica
                INNER JOIN pf_pj PessoaFisicaJuridica
                ON PessoaJuridica.id = PessoaFisicaJuridica.pessoa_juridica_id
                AND PessoaFisicaJuridica.pessoa_fisica_id = $id
        ");
    }

    public static function getDadosBancariosPessoaFisicaPorId($id) {
        return \DB::select("
            SELECT 
                TiposContaBancaria.id AS tipo_conta_id,
                TiposContaBancaria.valor AS tipo_conta,
                DadosBancarios.* 
            FROM tipos_conta_bancaria TiposContaBancaria
                INNER JOIN dados_bancarios DadosBancarios
                ON TiposContaBancaria.id = DadosBancarios.tipo_conta_id
                LEFT JOIN pessoa_dados_bancarios PessoaDadosBancarios
                ON DadosBancarios.id = PessoaDadosBancarios.dado_bancario_id
                AND PessoaDadosBancarios.pessoa_fisica_id = $id
        ");
    }

    public static function getProjetosCargosPorId($id) {
        return \DB::select("
            SELECT 
                Projeto.nome AS projeto,
                Projeto.id AS id,
                Cargo.valor AS cargo
            FROM projetos Projeto
                INNER JOIN pf_projeto PfProjeto
                ON PfProjeto.projeto_id = Projeto.id AND PfProjeto.pessoa_fisica_id = $id
                LEFT JOIN cargos Cargo
                ON Cargo.id = PfProjeto.cargo_id
            ORDER BY Projeto.dt_inicio DESC
        ");
    }


}
