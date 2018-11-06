<?php

namespace App\Http\Controllers;

use App\PessoaFisica;
use App\PessoaJuridica;
use Illuminate\Http\Request;
use App\Projeto;
use App\Chancela;

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
        $pessoas_juridicas = PessoaJuridica::all();
        $chancelas = Chancela::all();
        $pessoas_fisicas_chancelas_relacionadas = Projeto::getPessoasDeProjetos($id, true);
        $pessoas_juridicas_chancelas_relacionadas = Projeto::getPessoasDeProjetos($id, null, true);


        return [
            'projeto' => $projeto,
            'pessoas_fisicas_chancelas_relacionadas' => $pessoas_fisicas_chancelas_relacionadas,
            'pessoas_juridicas_chancelas_relacionadas' => $pessoas_juridicas_chancelas_relacionadas,
            'atributos' => [
                'pessoas_fisicas' => $pessoas_fisicas,
                'pessoas_juridicas' => $pessoas_juridicas,
                'chancelas' => $chancelas,
            ]
        ];
    }


    public function ajaxSave(Request $r) {

        $request['projeto'] = request('projeto');
        $request['pessoas_fisicas'] = request('pessoas_fisicas');
        $request['chancelas_pf'] = request('chancelas_pf');

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

        //Chancelas Pessoa Física
        $pessoa_fisica = (new PessoaFisica)->find($request['pessoas_fisicas']);

        if(empty($request['chancelas_pf'])) {
            $projeto->pessoas_fisicas()->detach();
            $projeto->pessoas_fisicas()->attach(PessoaFisica::find($request['pessoas_fisicas']), ['chancela_id' => null]);
        } else {

            $chancela_pf = $request['chancelas_pf'];
            if (substr($chancela_pf, 0, 4) == 'new:')
            {
                $chancela_pf = strtolower(substr($chancela_pf,4));
                $chancelaPfObj = Chancela::where('valor', $chancela_pf)->first();
                if(empty($chancelaPfObj)){
                    $nova_chancela = Chancela::create(['valor' => $chancela_pf]);
                    $chancela_pf_id = $nova_chancela->id;
                } else {
                    $chancela_pf_id = $chancelaPfObj->id;
                }
            } else {
                $chancela_pf_id = $chancela_pf;
            }

            $projeto->pessoas_fisicas()->detach();
            $projeto->pessoas_fisicas()->attach(PessoaFisica::find($request['pessoas_fisicas']), ['chancela_id' => $chancela_pf_id]);

        }

        return $projeto;
    }

    public function ajaxGetPfSelecionadas($id) {

        $projeto = (new Projeto)->find($id);
        $pessoas_fisicas = $projeto->pessoas_fisicas()->get();
        return $pessoas_fisicas;

    }

    public function ajaxGetChancelasSelecionadas($id) {

        $projeto = (new Projeto)->find($id);
        $pessoas_fisicas = $projeto->pessoas_fisicas()->get();

        foreach($pessoas_fisicas as &$pessoa_fisica){
            $pessoa_fisica['chancela'] = Projeto::getChancelaPorId($id, $pessoa_fisica['id']);
        }


        return $pessoas_fisicas;

    }


    public function ajaxAddChancelaPf() {

        $chancela = request('nova_chancela');
        $projeto_id = request('projeto_id');

        //Condições
        $isPf = array_key_exists('pessoa_fisica', $chancela)
            && !empty($chancela['pessoa_fisica'])
            && !array_key_exists('pessoa_juridica', $chancela);

        $isPj = array_key_exists('pessoa_juridica', $chancela)
            && !empty($chancela['pessoa_juridica'])
            && !array_key_exists('pessoa_fisica', $chancela);;

        if(!empty($projeto_id) && ( $isPf || $isPj ) && !empty($chancela['chancela'])) {

            if(substr($chancela['chancela'], 0, 4) == 'new:'){
                $nova_chancela = strtolower(substr($chancela['chancela'],4));
                $chancelaObj = Chancela::where('valor', $nova_chancela)->first();
                if(empty($chancelaObj)){
                    $nova_chancela = Chancela::create(['valor' => $nova_chancela]);
                    $chancela['chancela'] = $nova_chancela->id;
                }
            }

            $projeto = Projeto::find($projeto_id);

            if($isPf) {
                $projeto->pessoas_fisicas()->attach(PessoaFisica::find($chancela['pessoa_fisica']), ['chancela_id' => $chancela['chancela']]);
            } else if($isPj) {
                $projeto->pessoas_juridicas()->attach(PessoaJuridica::find($chancela['pessoa_juridica']), ['chancela_id' => $chancela['chancela']]);
            }

        } else {
            return "Chancela inválida";
        }

        return [ Projeto::getPessoasDeProjetos($projeto_id, $isPf, $isPj), Chancela::all() ];
    }

    public function ajaxRemoveChancelaPf() {

        $projeto_id = request('projeto_id');
        $chancela_id = request('chancela_id');
        $pessoa_fisica_id = request('pessoa_fisica_id');
        $pessoa_juridica_id = request('pessoa_juridica_id');

        if(Projeto::removeChancelaDeProjeto($projeto_id, $chancela_id, $pessoa_fisica_id, $pessoa_juridica_id)){
            return Projeto::getPessoasDeProjetos($projeto_id, $pessoa_fisica_id, $pessoa_juridica_id);
        }

        return "Chancela inválida";

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
