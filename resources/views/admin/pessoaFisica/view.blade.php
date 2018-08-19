@extends('layouts.app')

@section('content')

    {{-- Errors --}}
    @include('admin.elements.errors')

    <div id="container_conteudo" class="formulario">

        <div class="titulo">Pessoa Física - {{ $pessoa_fisica->nome_adotado }}</div>

        <hr>

        <div class="resumo">

            <h2 class="nome_grupo">Dados Gerais</h2>

            <span class="campo">Nome</span><div class="valor">{{ ucwords($pessoa_fisica->nome) }}</div><br>

            @if(!empty($pessoa_fisica->nome_adotado))
            <span class="campo">Nome adotado</span><div class="valor">{{ ucwords($pessoa_fisica->nome_adotado) }}</div><br>
            @endif

            @if(!empty($genero))
            <span class="campo">Gênero</span><div class="valor">{{ ucfirst($genero) }}</div><br>
            @endif

            @if(!empty($estado_civil))
            <span class="campo">Estado civil</span><div class="valor">{{ ucfirst($estado_civil) }}</div><br>
            @endif

            @if(!empty($pessoa_fisica->dt_nascimento))
            <span class="campo">Data de nascimento</span><div class="valor">{{ $pessoa_fisica->dt_nascimento }}</div><br>
            @endif

            @if(!empty($pessoa_fisica->nacionalidade))
            <span class="campo">Nacionalidade</span><div class="valor">{{ ucfirst($pessoa_fisica->nacionalidade) }}</div><br>
            @endif

            @if(!empty($pessoa_fisica->naturalidade))
            <span class="campo">Naturalidade</span><div class="valor">{{ ucfirst($pessoa_fisica->naturalidade) }}</div>
            @endif

            <h2 class="nome_grupo">Documentos</h2>

            @if(empty($pessoa_fisica->rg) && empty($pessoa_fisica->cpf) && empty($pessoa_fisica->passaporte))
                <div class="valor">Nenhum documento cadastrado</div>
            @else

                @if(!empty($pessoa_fisica->rg))
                    <span class="campo">RG</span><div class="valor">{{ $pessoa_fisica->rg }}</div><br>
                @endif
                @if(!empty($pessoa_fisica->cpf))
                    <span class="campo">CPF</span><div class="valor">{{ $pessoa_fisica->cpf }}</div><br>
                @endif
                @if(!empty($pessoa_fisica->passaporte))
                    <span class="campo">Passaporte</span><div class="valor">{{ $pessoa_fisica->passaporte }}</div>
                @endif

            @endif

        </div>

        

        


    </div>

   

@stop