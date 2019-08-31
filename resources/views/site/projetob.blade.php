@extends('site.layouts.base')
@section('conteudo')


@carousel(['ibagens' => [
  "/images/proja.png",
  "/images/projb.png",
  "/images/projc.png"
]])
@endcarousel

<div class="row projeto tipo-d justify-content-center" id="corpo">
  <div class="ficha col-md-2">
    <div class="titulo">
      <h1>
        {{ $titulo }}
      </h1>
      <span class="med">
        Residências artísticas<br>
        em contexto educativos
      </span>
    </div>
    <div class="info d-none d-md-block">
      <div class="campo">
        <span class="bold">temporada 1</span>
        <p>
          dezembro 2019
        </p>
      </div>
      <div class="campo">
        <span class="bold">temporada 2</span>
        <p>janeiro 2020</p>
      </div>
    </div>
    <div class="info">
      {{-- TODO line-height desse campo difere em A e B --}}
      @assuntos(['tags' => ['educação', 'astronomia', 'dança', 'NOISE']])
  
      @endassuntos
    </div>
  </div>
  <div class="col-md-5 offset-md-1">
    <div class="row">
      @texto
          
      @endtexto
      @notas(['display' => 'd-md-block'])
          
      @endnotas
    </div>
    <div class="row">
      <div class="col">
        <div class="texto">
          <div class="subprojeto">
            <div class="portrait">
              <a href="{{ url('/site/projetod') }}"><h1 class="bold">Temporada 1</h1></a>
              <span class="bold">2019</span>
              <p>galeria vermelho,</p>
              <p>são paulo</p>
            </div>
            <div class="thumb landscape">
              <a href="{{ url('/site/projetod') }}"><img src="{{ asset('/images/galeria1/RM10.png') }}" alt=""></a>
            </div>
          </div>
          <div class="subprojeto">
            <div class="portrait">
              <a href="#"><h1 class="bold">Temporada 2</h1></a>
              <span class="bold">2020</span>
              <p>galeria vermelho,</p>
              <p>são paulo</p>
            </div>
            <div class="thumb landscape">
              <a href="#"><img src="{{ asset('/images/galeria1/RM6.png') }}" alt=""></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@stop