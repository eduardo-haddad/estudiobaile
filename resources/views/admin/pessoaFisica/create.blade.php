@extends('layouts.app')

@section('content')

    {{-- Errors --}}
    @include('admin.elements.errors')

    <div id="container_conteudo" class="formulario">

        <div class="titulo">Criar nova Pessoa Física</div>

        <hr>

        <form action="{{ route('pf.store') }}" method="post" enctype="multipart/form-data">
            
            {{ csrf_field() }}

            <div class="grupo">

                <h2 class="nome_grupo">Dados Gerais</h2>

                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-4 col-xs-6">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" class="form-control">
                        </div>
                                    
                        <div class="col-sm-4 col-xs-6">
                            <label for="nome_adotado">Nome adotado</label>
                            <input type="text" name="nome_adotado" class="form-control">
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
                                        $genero_valor = $genero->valor == "M" ? "Feminino" : "Masculino";
                                    @endphp
                                    <option value="{{ $genero->id }}">{{ $genero_valor }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-xs-2">
                            <label for="estado_civil_id">Estado Civil</label>
                            <select name="estado_civil_id" class="form-control">
                                @foreach ($estados_civis as $estado_civil)
                                    <option value="{{ $estado_civil->id }}">{{ ucfirst($estado_civil->valor) }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="col-xs-2">
                            <label for="dt_nascimento">Data de nascimento</label>
                            <input type="date" name="dt_nascimento" class="form-control">
                        </div>
                    
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-2">
                            <label for="nacionalidade">Nacionalidade</label>
                            <input type="text" name="nacionalidade" class="form-control">
                        </div>
                        <div class="col-xs-2">
                            <label for="naturalidade">Naturalidade</label>
                            <input type="text" name="naturalidade" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="grupo">

                <h2 class="nome_grupo">Documentos</h2>

                <div class="row">

                    <div class="col-xs-2">
                        <label for="rg">RG</label>
                        <input type="text" name="rg" class="form-control">
                    </div>
                    <div class="col-xs-2">
                        <label for="passaporte">Passaporte</label>
                        <input type="text" name="passaporte" class="form-control">
                    </div>
                    <div class="col-xs-2">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" class="form-control">
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