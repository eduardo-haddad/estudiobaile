@extends('layouts.app')

@section('content')

    {{-- Errors --}}
    @include('admin.elements.errors')

    <div id="container_conteudo" class="formulario">

        <div class="titulo">Adicionar contato - {{ $pessoa_fisica->nome_adotado }}</div>

        <hr>

        <form action="{{ route('pf.contatos.store', ['pf' => $pessoa_fisica->id]) }}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="grupo">

                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-1">
                            <label for="tipo_contato">Contato</label>
                            <select name="tipo_contato_id" class="form-control">
                                @foreach ($tipos_contato as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label for="contato">&nbsp;</label>
                            <input type="text" name="valor" class="form-control">
                        </div>

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