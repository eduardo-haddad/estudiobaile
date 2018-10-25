<?php

namespace App\Http\Controllers;

use App\PessoaFisica;
use Illuminate\Http\Request;
use App\Projeto;
use App\Cargo;

class ProjetoController extends Controller
{
    public function ajaxIndex()
    {
        return (new Projeto)->orderBy('nome')->get();
    }


    public function ajaxView($id)
    {
        $projeto = (new Projeto)->find($id);
        $pessoas_fisicas = PessoaFisica::all();
        $cargos_pf = Cargo::all();
        $pessoas_fisicas_cargos_relacionados = Projeto::getPessoasFisicasDeProjetos($id);


        return [
            'projeto' => $projeto,
            'pessoas_fisicas_cargos_relacionados' => $pessoas_fisicas_cargos_relacionados,
            'atributos' => [
                'pessoas_fisicas' => $pessoas_fisicas,
                'cargos' => $cargos_pf,
            ]
        ];
    }


    public function ajaxSave(Request $r) {

        $request['projeto'] = request('projeto');
        $request['pessoas_fisicas'] = request('pessoas_fisicas');
        $request['cargos_pf'] = request('cargos_pf');

        //Projeto
        $projeto = (new Projeto)->find($request['projeto']['id']);

        foreach(json_decode($projeto) as $chave => $valor):
            if($chave == "modificado_por") {
                $projeto->$chave = $r->user()->name;
            }
            else {
                if(!empty($request['projeto'][$chave])) {
                    $projeto->$chave = $request['projeto'][$chave];
                }
            }
        endforeach;

        $projeto->save();

        //Pessoas físicas
        if(empty($request['pessoas_fisicas'])) {
            $projeto->pessoas_fisicas()->detach();
        } else {
            //$projeto->pessoas_fisicas()->sync($request['pessoas_fisicas']);
            $projeto->pessoas_fisicas()->attach(PessoaFisica::find($request['pessoas_fisicas']));
        }

        //Cargos Pessoa Física
        $pessoa_fisica = (new PessoaFisica)->find($request['pessoas_fisicas']);

        if(empty($request['cargos_pf'])) {
            $projeto->pessoas_fisicas()->detach();
            $projeto->pessoas_fisicas()->attach(PessoaFisica::find($request['pessoas_fisicas']), ['cargo_id' => null]);
        } else {

            $cargo_pf = $request['cargos_pf'];
            if (substr($cargo_pf, 0, 4) == 'new:')
            {
                $cargo_pf = strtolower(substr($cargo_pf,4));
                $cargoPfObj = Cargo::where('valor', $cargo_pf)->first();
                if(empty($cargoPfObj)){
                    $novo_cargo = Cargo::create(['valor' => $cargo_pf]);
                    $cargo_pf_id = $novo_cargo->id;
                } else {
                    $cargo_pf_id = $cargoPfObj->id;
                }
            } else {
                $cargo_pf_id = $cargo_pf;
            }

            $projeto->pessoas_fisicas()->detach();
            $projeto->pessoas_fisicas()->attach(PessoaFisica::find($request['pessoas_fisicas']), ['cargo_id' => $cargo_pf_id]);

        }

        return $projeto;
    }

    public function ajaxGetPfSelecionadas($id) {

        $projeto = (new Projeto)->find($id);
        $pessoas_fisicas = $projeto->pessoas_fisicas()->get();
        return $pessoas_fisicas;

    }

    public function ajaxGetCargosSelecionados($id) {

        $projeto = (new Projeto)->find($id);
        $pessoas_fisicas = $projeto->pessoas_fisicas()->get();

        foreach($pessoas_fisicas as &$pessoa_fisica){
            $pessoa_fisica['cargo'] = Projeto::getCargoPorId($id, $pessoa_fisica['id']);
        }


        return $pessoas_fisicas;

    }


    public function ajaxAddCargoPf() {

        $cargo = request('novo_cargo');
        $projeto_id = request('projeto_id');

        if(!empty($projeto_id) && !empty($cargo['pessoa_fisica'] && !empty($cargo['cargo']))) {

            if(substr($cargo['cargo'], 0, 4) == 'new:'){
                $novo_cargo = strtolower(substr($cargo['cargo'],4));
                $cargoObj = Cargo::where('valor', $novo_cargo)->first();
                if(empty($cargoObj)){
                    $novo_cargo = Cargo::create(['valor' => $novo_cargo]);
                    $cargo['cargo'] = $novo_cargo->id;
                }
            }

            $projeto = (new Projeto)->find($projeto_id);
            $projeto->pessoas_fisicas()->attach(PessoaFisica::find($cargo['pessoa_fisica']), ['cargo_id' => $cargo['cargo']]);

        } else {
            return "Cargo inválido";
        }

        return [Projeto::getPessoasFisicasDeProjetos($projeto_id), Cargo::all()];
    }

    public function ajaxRemoveCargoPf() {

        $projeto_id = request('projeto_id');
        $cargo_id = request('cargo_id');
        $pessoa_fisica_id = request('pessoa_fisica_id');

        if(Projeto::removeCargoDeProjeto($projeto_id, $cargo_id, $pessoa_fisica_id, null)){
            return Projeto::getPessoasFisicasDeProjetos($projeto_id);
        }

        return "Cargo inválido";

    }


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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
