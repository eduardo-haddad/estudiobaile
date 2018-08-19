<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaFisica;
use App\TipoContato;
use App\Contato;
use App\Projeto;
use App\Genero;
use App\EstadoCivil;
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
            'pessoas_fisicas' => PessoaFisica::all()
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
        //dd($request->user()->name);

        $this->validate($request, [
            'nome' => 'required|max:255',
            'nome_adotado' => 'required|max:255',
            'dt_nascimento' => 'nullable|date',
        ]);  

        PessoaFisica::create([
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

        return redirect()->back();
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
            select tc.nome as tipo, c.valor from contatos c
            inner join tipos_contato tc
            on c.tipo_contato_id = tc.id
            left join pessoas_fisicas p
            on c.pessoa_fisica_id = p.id
            where p.id = $id
        ");

        return view('admin.pessoaFisica.view', [
            'pessoa_fisica' => $pf,
            'genero' => $genero,
            'estado_civil' => (new EstadoCivil)->find($pf->estado_civil_id)->valor,
            'contatos' => $contatos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.pessoaFisica.edit', [
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
    public function update(Request $request, $id)
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

        return redirect()->route('pf.index');

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
}
