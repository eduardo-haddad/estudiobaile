@extends('layouts.app')

@section('content')

    {{-- Errors --}}
    @include('admin.elements.errors')

    <div id="container_conteudo" class="formulario">

        <div class="titulo">Editar Pessoa Física - {{ $pessoa_fisica->nome_adotado }}</div>

        <hr>

        <form action="{{ route('pf.dadosgerais.update', ['id' => $pessoa_fisica->id]) }}" method="post" enctype="multipart/form-data">
            
            {{ csrf_field() }}

            <div class="grupo">

                <h2 class="nome_grupo">Dados Gerais</h2>

                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-4 col-xs-6">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" class="form-control" value="{{ $pessoa_fisica->nome }}">
                        </div>
                                    
                        <div class="col-sm-4 col-xs-6">
                            <label for="nome_adotado">Nome adotado</label>
                            <input type="text" name="nome_adotado" class="form-control" value="{{ $pessoa_fisica->nome_adotado }}">
                        </div>
                    </div>
                </div>
                                    
                <div class="row">
                    
                    <div class="form-group">
                    
                        <div class="col-xs-2">
                            <label for="genero_id">Gênero</label>
                            <select name="genero_id" class="form-control">
                                @foreach ($generos as $genero)
                                    @php
                                        $genero_valor = $genero->valor == "M" ? "Masculino" : "Feminino";
                                        if($genero->id == $pessoa_fisica->genero_id){
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                    @endphp
                                    <option value="{{ $genero->id }}" {{ $selected }}>{{ $genero_valor }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-xs-2">
                            <label for="cpf">Estado Civil</label>
                            <select name="estado_civil_id" class="form-control">
                                @foreach ($estados_civis as $estado_civil)
                                    @php if($estado_civil->id == $pessoa_fisica->estado_civil_id){
                                        $selected = 'selected="selected"';
                                    } else {
                                        $selected = '';
                                    } @endphp
                            <option value="{{ $estado_civil->id }}" {{ $selected }}>{{ ucfirst($estado_civil->valor) }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="col-xs-2">
                            <label for="dt_nascimento">Data de nascimento</label>
                            <input type="date" name="dt_nascimento" class="form-control" value="{{ $pessoa_fisica->dt_nascimento }}">
                        </div>
                    
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-2">
                            <label for="nacionalidade">Nacionalidade</label>
                            <input type="text" name="nacionalidade" class="form-control" value="{{ $pessoa_fisica->nacionalidade }}">
                        </div>
                        <div class="col-xs-2">
                            <label for="naturalidade">Naturalidade</label>
                            <input type="text" name="naturalidade" class="form-control" value="{{ $pessoa_fisica->naturalidade }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="grupo">

                <h2 class="nome_grupo">Documentos</h2>

                <div class="row">

                    <div class="col-xs-2">
                        <label for="rg">RG</label>
                        <input type="text" name="rg" class="form-control" value="{{ $pessoa_fisica->rg }}">
                    </div>
                    <div class="col-xs-2">
                        <label for="passaporte">Passaporte</label>
                        <input type="text" name="passaporte" class="form-control" value="{{ $pessoa_fisica->passaporte }}">
                    </div>
                    <div class="col-xs-2">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" class="form-control" value="{{ $pessoa_fisica->cpf }}">
                    </div>

                </div>
                    
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-default">
                    Cadastrar
                </button>
            </div>
                
            


        </form>

        


    </div>



@stop