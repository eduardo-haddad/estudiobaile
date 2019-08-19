@extends('site.layouts.base')
@section('conteudo')

@component('site.components.carousel')
@endcomponent

<div class="row projeto tipo-a justify-content-center" id="corpo">
  <div class="ficha col-md-2">
    <div class="titulo">
      <h1>
        Projeto A
      </h1>
      <span class="med">Residências artísticas<br>
      em contexto educativos</span>
    </div>
    <div class="info">
      {{-- TODO complicado : diagramação diferente no mobile --}}
      <div class="campo">
        <p>
            data 
        </p>
        <span class="bold">dezembro 2019</span>
      </div>
      <div class="campo">
        <p>onde</p>
        <span class="bold">galeria veremelho, são paulo</span>
      </div>
      <div class="campo">
        <p>assuntos</p>
        <span class="bold">educação<br>
          astronomia<br>
          dança<br>
        </span>
      </div>
    </div>
    <div class="info d-none d-md-block">
      <div class="campo">
        <p>curadoria</p>
        <span class="bold">nome sobrenome</span>
      </div>
      <div class="campo">
        <p>montagem</p>
        <span class="bold">nome sobrenome</span>
      </div>
      <div class="campo">
        <p>função</p>
        <span class="bold">nome sobrenome</span>
      </div>
      <div class="campo">
        <p>função</p>
        <span class="bold">nome sobrenome</span>
      </div>
      <div class="campo">
        <p>função</p>
        <span class="bold">nome sobrenome</span>
      </div>
    </div>
    <div class="info d-none d-md-block">
      parceiros
      <div class="parceiros">
        <img src="{{ asset('/images/parceiros.png') }}" alt="">
        <img src="{{ asset('/images/parceiros.png') }}" alt="">
      </div>
      <div class="parceiros">
        <img src="{{ asset('/images/parceiros.png') }}" alt="">
        <img src="{{ asset('/images/parceiros.png') }}" alt="">
      </div>
    </div>
  </div>
  <div class="col-md-5 offset-md-1">
    <div class="row">
        @component('site.components.texto')
            
        @endcomponent
        @notas
            
        @endnotas
    </div>
    @component('site.components.galeria')
        
    @endcomponent
  </div>
</div>


@stop