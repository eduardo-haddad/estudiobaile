@extends('site.layouts.base')
@section('conteudo')

@carousel(['ibagens' => "/images/galeria1/RM10.png"])
@endcarousel

<div class="row projeto tipo-d justify-content-center" id="corpo">
  <div class="ficha col-md-2">
    <div class="info">
      <div class="campo">
        <p>parte do projeto</p>
        <a href="{{  url('/site/projetob') }}">Temporada de Dança Videobrasil</a>
      </div>
    </div>
    <div class="titulo">
      <h1>
        1<sup>ª</sup> Temporada de Dança Videobrasil
      </h1>
    </div>
    <div class="info">
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
    <div class="info">
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
  </div>
  <div class="col-md-5 offset-md-1">
    <div class="row">
      @texto
          
      @endtexto
      @notas(['display' => 'd-md-block'])
          
      @endnotas
    </div>
      @galeria(['display' => 'd-none d-md-block'])
          
      @endgaleria
      @galeriaMobile(['display' => 'd-block d-md-none'])

      @endgaleriaMobile
  </div>
</div>


@stop