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
        $pf = (new PessoaFisica)->find($id);

        //Gênero
        if(!empty($pf->genero_id)){
            $genero = (new Genero)->find($pf->genero_id)->valor;
        } else {
            $genero = null;
        }

        //Contatos
        $contatos = DB::select("
            SELECT TipoContato.nome AS tipo, Contatos.valor, Contatos.id FROM contatos Contatos
                INNER JOIN tipos_contato TipoContato
                ON Contatos.tipo_contato_id = TipoContato.id
                LEFT JOIN pessoas_fisicas PessoaFisica
                ON Contatos.pessoa_fisica_id = PessoaFisica.id
            WHERE PessoaFisica.id = $id
            GROUP BY tipo
            ORDER BY tipo ASC
        ");

        $estado_civil = (new EstadoCivil)->find($pf->estado_civil_id);
        $estado_civil = !empty($estado_civil->valor) ? $estado_civil->valor : null;

        return [
            'pessoa_fisica' => $pf,
            'genero' => $genero,
            'estado_civil' => $estado_civil,
            'contatos' => $contatos,
            'atributos' => [
                'tipos_contato' => TipoContato::all(),
                'generos' => Genero::all(),
                'estados_civis' => EstadoCivil::all()
            ]
        ];
    }

    public function ajaxSave(Request $r){

        $request = request('pessoa');

        $pf = (new PessoaFisica)->find($request['id']);

        $pf->nome = $request['nome'];
        $pf->nome_adotado = $request['nome_adotado'];
        $pf->genero_id = $request['genero_id'];
        $pf->estado_civil_id = $request['estado_civil_id'];
        $pf->dt_nascimento = $request['dt_nascimento'];
        $pf->nacionalidade = $request['nacionalidade'];
        $pf->naturalidade = $request['naturalidade'];
        $pf->rg = $request['rg'];
        $pf->passaporte = $request['passaporte'];
        $pf->cpf = $request['cpf'];
        $pf->modificado_por = $r->user()->name;

        $pf->save();

        return $pf;
    }

}
