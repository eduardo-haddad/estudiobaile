<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaFisica;
use App\TipoContato;
use App\Contato;
use App\Projeto;
use App\Genero;
use App\EstadoCivil;
use App\Endereco;
use App\TipoContaBancaria;
use Session;
use DB;

class PessoaFisicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pessoaFisica.index', [
            'pessoas_fisicas' => PessoaFisica::orderBy('nome_adotado')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pessoaFisica.create', [
            'tipos_contato' => TipoContato::all(),
            'generos' => Genero::all(),
            'estados_civis' => EstadoCivil::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        $this->validate($request, [
//            'nome' => 'required|max:255',
//            'nome_adotado' => 'required|max:255',
//            'dt_nascimento' => 'nullable|date',
//        ]);


        $pf = PessoaFisica::create([
            'nome' => $request->nome,
            'nome_adotado' => $request->nome_adotado,
            'genero_id' => $request->genero_id,
            'estado_civil_id' => $request->estado_civil_id,
            'dt_nascimento' => $request->dt_nascimento,
            'nacionalidade' => $request->nacionalidade,
            'naturalidade' => $request->naturalidade,
            'rg' => $request->rg,
            'passaporte' => $request->passaporte,
            'cpf' => $request->cpf,
            'criado_por' => $request->user()->name,
            'modificado_por' => $request->user()->name
        ]);

        Session::flash('success', 'Pessoa cadastrada');

        return redirect()->route('pf.view', ['id' => $pf->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $pf = (new PessoaFisica)->find($id);

        //Gênero
        $genero = (new Genero)->find($pf->genero_id)->valor == "F" ? "Feminino" : "Masculino";

        //Contatos
        $contatos = DB::select("
            select tc.nome as tipo, c.valor, c.id from contatos c
            inner join tipos_contato tc
            on c.tipo_contato_id = tc.id
            left join pessoas_fisicas p
            on c.pessoa_fisica_id = p.id
            where p.id = $id
        ");

        $estado_civil = (new EstadoCivil)->find($pf->estado_civil_id);
        $estado_civil = !empty($estado_civil->valor) ? $estado_civil->valor : null;

        return view('admin.pessoaFisica.view', [
            'pessoa_fisica' => $pf,
            'genero' => $genero,
            'estado_civil' => $estado_civil,
            'contatos' => $contatos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dadosGeraisEdit($id)
    {
        return view('admin.pessoaFisica.dadosGeraisEdit', [
            'pessoa_fisica' => (new PessoaFisica)->find($id),
            'tipos_contato' => TipoContato::all(),
            'generos' => Genero::all(),
            'estados_civis' => EstadoCivil::all()
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dadosGeraisUpdate(Request $request, $id)
    {
        
        $this->validate($request, [
            'nome' => 'required|max:255',
            'nome_adotado' => 'required|max:255',
            'dt_nascimento' => 'nullable|date',
        ]); 

        $pf = (new PessoaFisica)->find($id);

        $pf->nome = $request->nome;
        $pf->nome_adotado = $request->nome_adotado;
        $pf->genero_id = $request->genero_id;
        $pf->estado_civil_id = $request->estado_civil_id;
        $pf->dt_nascimento = $request->dt_nascimento;
        $pf->nacionalidade = $request->nacionalidade;
        $pf->naturalidade = $request->naturalidade;
        $pf->rg = $request->rg;
        $pf->passaporte = $request->passaporte;
        $pf->cpf = $request->cpf;
        $pf->modificado_por = $request->user()->name;

        $pf->save();
        
        Session::flash('success', 'Registro alterado');

        return redirect()->route('pf.view', ['id' => $id]);

    }

    public function contatosUpdate(Request $request, $id)
    {

        $this->validate($request, [
            'nome' => 'required|max:255',
            'nome_adotado' => 'required|max:255',
            'dt_nascimento' => 'nullable|date',
        ]);

        $pf = (new PessoaFisica)->find($id);

        $pf->nome = $request->nome;
        $pf->nome_adotado = $request->nome_adotado;
        $pf->genero_id = $request->genero_id;
        $pf->estado_civil_id = $request->estado_civil_id;
        $pf->dt_nascimento = $request->dt_nascimento;
        $pf->nacionalidade = $request->nacionalidade;
        $pf->naturalidade = $request->naturalidade;
        $pf->rg = $request->rg;
        $pf->passaporte = $request->passaporte;
        $pf->cpf = $request->cpf;
        $pf->modificado_por = $request->user()->name;

        $pf->save();

        Session::flash('success', 'Registro alterado');

        return redirect()->route('pf.view', ['id' => $id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxIndex()
    {
        return (new PessoaFisica)->orderBy('nome_adotado')->get();
    }


    public function ajaxView($id)
    {
        $pessoa_fisica = (new PessoaFisica)->find($id);

        //Gênero
        $genero = !empty($pessoa_fisica->genero_id) ? (new Genero)->find($pessoa_fisica->genero_id)->valor : null;

        //Contatos
        $contatos = $pessoa_fisica->contatos()->get();

        //Endereços
        $enderecos = $pessoa_fisica->enderecos()->get();

        //Pessoas Jurídicas
        $pessoas_juridicas = $pessoa_fisica->pessoas_juridicas()->get();

        //Dados Bancários
        $dados_bancarios = $pessoa_fisica->dados_bancarios()->get();

        //Estado Civil
        $estado_civil = !empty($pessoa_fisica->estado_civil_id) ? (new EstadoCivil)->find($pessoa_fisica->estado_civil_id)->valor : null;

        return [
            'pessoa_fisica' => $pessoa_fisica,
            'genero' => $genero,
            'estado_civil' => $estado_civil,
            'contatos' => $contatos,
            'enderecos' => $enderecos,
            'dados_bancarios' => $dados_bancarios,
            'pessoas_juridicas' => $pessoas_juridicas,
            'atributos' => [
                'tipos_contato' => TipoContato::all(),
                'generos' => Genero::all(),
                'estados_civis' => EstadoCivil::all(),
                'tipos_conta_bancaria' => TipoContaBancaria::all(),
            ]
        ];
    }

    public function ajaxSave(Request $r) {

        $request['pessoa'] = request('pessoa');
        $request['contatos'] = request('contatos');
        $request['enderecos'] = request('enderecos');



        //Pessoa Física
        $pessoa_fisica = (new PessoaFisica)->find($request['pessoa']['id']);

        foreach(json_decode($pessoa_fisica) as $chave => $valor):
            if($chave == "modificado_por") {
                $pessoa_fisica->$chave = $r->user()->name;
            }
            else {
                if(!empty($request['pessoa'][$chave])) {
                    $pessoa_fisica->$chave = $request['pessoa'][$chave];
                }
            }
        endforeach;

        $pessoa_fisica->save();

        //Contatos
        foreach($request['contatos'] as $i => $contato) {
            $contato = (new Contato)->find($request['contatos'][$i]['id']);
            $contato->valor = $request['contatos'][$i]['valor'];
            $contato->save();
        }

        //Endereços
        foreach($request['enderecos'] as $j => $endereco):

            $endereco_atual = (new Endereco)->find($endereco['id']);

            foreach(json_decode($endereco_atual) as $key => $value):
                if(!empty($request['enderecos'][$j][$key])) {
                    $endereco_atual->$key = $request['enderecos'][$j][$key];
                }
            endforeach;
            $endereco_atual->save();

        endforeach;

        return $pessoa_fisica;
    }

    public function ajaxAddContato() {

        $request['email'] = request('email');
        $request['telefone'] = request('telefone');

        if(empty($request['email']) && empty($request['telefone'])) {
            return "Contato inválido";
        }

        $contato = new Contato();
        $contato->pessoa_fisica_id = request('pessoa_id');
        $contato->pessoa_juridica_id = 0;

        if(!empty($request['email'])){
            $contato->tipo_contato_id = 1;
            $contato->valor = $request['email'];
        } else {
            $contato->tipo_contato_id = 2;
            $contato->valor = $request['telefone'];
        }

        try {
            $contato->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $contatos = PessoaFisica::getContatosPessoaFisicaPorId(request('pessoa_id'));

        return $contatos;
    }

    public function ajaxRemoveContato(Request $r) {

        $contato_id = request('contato_id');
        $pessoa_id = request('pessoa_id');

        $contato = (new Contato)->find($contato_id);
        $contato->delete();

        $contatos = PessoaFisica::getContatosPessoaFisicaPorId($pessoa_id);

        return $contatos;
    }

    public function ajaxAddEndereco() {

        $endereco = request('endereco');
        $pessoa_id = request('pessoa_id');

        if(empty($endereco['rua'])) {
            return "Endereço inválido";
        }

        $novo_endereco = new Endereco();
        $novo_endereco->rua = !empty($endereco['rua']) ? $endereco['rua'] : '';
        $novo_endereco->numero = !empty($endereco['numero']) ? $endereco['numero'] : '';
        $novo_endereco->complemento = !empty($endereco['complemento']) ? $endereco['complemento'] : '';
        $novo_endereco->bairro = !empty($endereco['bairro']) ? $endereco['bairro'] : '';
        $novo_endereco->cep = !empty($endereco['cep']) ? $endereco['cep'] : '';
        $novo_endereco->cidade = !empty($endereco['cidade']) ? $endereco['cidade'] : '';
        $novo_endereco->estado = !empty($endereco['estado']) ? $endereco['estado'] : '';
        $novo_endereco->pais = !empty($endereco['pais']) ? $endereco['pais'] : '';

        try {
            $novo_endereco->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $pessoa = (new PessoaFisica)->find($pessoa_id);
        $pessoa->enderecos()->attach($novo_endereco->id);

        $enderecos = $pessoa->enderecos()->get();

        return $enderecos;
    }

    public function ajaxRemoveEndereco() {

        $endereco_id = request('endereco_id');
        $pessoa_id = request('pessoa_id');

        $endereco = (new Endereco)->find($endereco_id);
        $pessoa_fisica = (new PessoaFisica)->find($pessoa_id);

        try {
            $pessoa_fisica->enderecos()->detach($endereco_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        try {
            $endereco->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $enderecos = $pessoa_fisica->enderecos()->get();

        return $enderecos;
    }


}
