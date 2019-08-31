@extends('site.layouts.base')
@section('conteudo')

@carousel(['ibagens' => ["/images/projc.png"]])
@endcarousel

<div class="row projeto tipo-c justify-content-center" id="corpo">
  <div class="ficha col-md-2">
    <div class="titulo">
      <h1>
        Projeto C
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
      <div class="campo">
        <p>data</p>
        <span class="bold">dezembro 2019</span>
      </div>
      <div class="campo">
        <p>onde</p>
        <span class="bold">galeria vermelho, são paulo</span>
      </div>
      <div class="campo">
        {{-- TODO não percebi a diferença entre esse cambo e o cambo 'assuntos' --}}
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