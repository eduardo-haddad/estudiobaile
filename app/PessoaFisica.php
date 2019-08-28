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
        'origem_cidade',
        'origem_pais_id',
        'vive_em_cidade',
        'vive_em_pais_id',
        'genero',
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

    public function arquivos()
    {
        return $this->belongsToMany('App\Arquivo', 'arquivos_relacionados', 'pessoa_fisica_id', 'arquivo_id');
    }

    public function dados_bancarios()
    {
        return $this->belongsToMany('App\DadoBancario', 'pessoa_dados_bancarios', 'pessoa_fisica_id', 'dado_bancario_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'pessoa_tag', 'pessoa_fisica_id', 'tag_id');
    }

//    public function genero()
//    {
//        return $this->belongsTo('App\Genero', 'genero_id');
//    }

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
                PessoaJuridica.id AS pessoa_juridica_id,
                PessoaJuridica.nome_fantasia AS nome_fantasia,
                PessoaJuridica.razao_social AS razao_social,
                Tag.text AS tag,
                Tag.id AS tag_id
            FROM pessoas_juridicas PessoaJuridica
                INNER JOIN pf_pj PessoaFisicaJuridica
                ON PessoaJuridica.id = PessoaFisicaJuridica.pessoa_juridica_id
                AND PessoaFisicaJuridica.pessoa_fisica_id = $id
                INNER JOIN tags Tag
                ON Tag.id = PessoaFisicaJuridica.tag_id
            ORDER BY PessoaJuridica.nome_fantasia
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

    public static function getProjetosChancelasPorId($pessoa_fisica_id) {
        return \DB::select("
            SELECT 
                Projeto.nome AS projeto,
                Projeto.id AS id,
                Tag.text AS chancela,
                Tag.id AS chancela_id
            FROM projetos Projeto
                INNER JOIN pf_projeto PfProjeto
                ON PfProjeto.projeto_id = Projeto.id AND PfProjeto.pessoa_fisica_id = $pessoa_fisica_id
                INNER JOIN tags Tag
                ON Tag.id = PfProjeto.tag_id
            ORDER BY Projeto.dt_inicio DESC, chancela
        ");
    }

    public static function removeChancelaPj($tag_id, $pessoa_fisica_id, $pessoa_juridica_id) {

        try {
            \DB::select("
            DELETE FROM pf_pj
            WHERE tag_id = $tag_id
                AND pessoa_fisica_id = $pessoa_fisica_id
                AND pessoa_juridica_id = $pessoa_juridica_id
        ");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public static function checaDestaque($pessoa_id, $arquivo_id) {
        return \DB::select("
            SELECT 
                ArquivosRelacionados.destaque
            FROM arquivos Arquivos
                INNER JOIN arquivos_relacionados ArquivosRelacionados
                ON Arquivos.id = ArquivosRelacionados.arquivo_id 
                  AND ArquivosRelacionados.pessoa_fisica_id = $pessoa_id
            WHERE ArquivosRelacionados.arquivo_id = $arquivo_id
            LIMIT 1
        ");
    }


}
