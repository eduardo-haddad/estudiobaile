@extends('layouts.app')

@section('content')

    {{-- Errors --}}
    @include('admin.elements.errors')

    <div id="container_conteudo" class="formulario">

        <div class="titulo">Editar contato</div>

        <hr>

        <form action="{{ route('pf.contatos.update', ['id' => $contato->id]) }}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="grupo">

                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-1">
                            <label for="tipo_contato">Contato</label>
                            <select name="tipo_contato_id" class="form-control">
                                @foreach ($tipos_contato as $tipo)
                                    @php
                                        if($tipo->id == $contato->tipo_contato_id) $selected = 'selected="selected"';
                                        else $selected = '';
                                    @endphp
                                    <option value="{{ $tipo->id }}" {{ $selected }}>{{ $tipo->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label for="contato">&nbsp;</label>
                            <input type="text" name="valor" class="form-control" value="{{ $contato->valor }}">
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