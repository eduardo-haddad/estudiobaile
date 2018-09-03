<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Contato;
use App\TipoContato;
use App\PessoaFisica;

class ContatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //Tipos de contato
        $tipos_contato = TipoContato::all();

        //Pessoa física
        $pessoa_fisica = (new PessoaFisica)->find($_GET['pf']);

        return view('admin.pessoaFisica.contatoCreate', [
            'tipos_contato' => $tipos_contato,
            'pessoa_fisica' => $pessoa_fisica
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

        if(empty($_GET['pf'])) {
            return redirect()->route('pf.index');
        }

        Contato::create([
            'valor' => $request->valor,
            'tipo_contato_id' => $request->tipo_contato_id,
            'pessoa_fisica_id' => $_GET['pf'],
            'pessoa_juridica_id' => 0,
        ]);

        Session::flash('success', 'Contato cadastrado');

        return redirect()->route('pf.view', ['id' => $_GET['pf']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        return view('admin.pessoaFisica.dadosGeraisEdit', [
//            'pessoa_fisica' => (new PessoaFisica)->find($id),
//            'tipos_contato' => TipoContato::all(),
//            'generos' => Genero::all(),
//            'estados_civis' => EstadoCivil::all()
//        ]);

        $pf_id = !empty($_GET['pf']) ? $_GET['pf'] : null;
        $pf = (new PessoaFisica)->find($pf_id);


        return view('admin.pessoaFisica.contatoEdit', [
            'pessoa_fisica' => $pf,
            'tipos_contato' => TipoContato::all(),
            'contato' => (new Contato)->find($id)
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

        $contato = (new Contato)->find($id);

        $contato->valor = $request->valor;
        $contato->tipo_contato_id = $request->tipo_contato_id;

        $contato->save();

        Session::flash('success', 'Contato alterado');

        return redirect()->route('pf.view', ['id' => $contato->pessoa_fisica_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $contato = (new Contato)->find($id);

        try {
            $contato->delete();
        } catch (\Exception $e) {
        }

        Session:flash('success', 'Contato apagado');
    }
}
