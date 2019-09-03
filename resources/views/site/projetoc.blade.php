@extends('site.layouts.base')
@section('conteudo')

@carousel(['ibagens' => ["/images/projc.png"]])
@endcarousel

<div class="row projeto tipo-c justify-content-center" id="corpo">
  <div class="ficha col-md-2">
    <div class="titulo">
      <h1>
        {{ $titulo }}
      </h1>
      <span class="med">Residências artísticas<br>
      em contexto educativos</span>
    </div>
    <div class="info">
      <div class="campo">
        @parceiros(['display' => '', 'titulo' => 'realização'])
        
        @endparceiros
      </div>
      <div class="campo">
        <p>organização</p>
        <div class="logo-externo">
          <img src="{{ asset('/images/logo-solo.png') }}" alt="">
        </div>
      </div>
    </div>
    <div class="info">
      @assuntos(['tags' => ['educação', 'astronomia', 'dança']])
  
      @endassuntos
    </div>
    <div class="info">
      @dataELocal(['data' => 'dezembro 2019', 'local' => 'galeria vermelho, são paulo'])
        
      @enddataELocal
      <div class="campo">
        {{-- TODO não percebi a diferença entre esse campo 'tags' e o campo 'assuntos' --}}
        <p>tags</p>
        <span class="bold">educação <br>
        astronomia <br>
        dança <br>
        </span>
      </div>
    </div>
  </div>
  <div class="col-md-5 offset-md-1">
    <div class="row">
      @texto
          
      @endtexto
      @notas(['display' => 'd-md-block'])
          
      @endnotas
    </div>
  </div>
</div>


@stop