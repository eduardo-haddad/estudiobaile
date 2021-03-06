@extends('site.layouts.base')
@section('conteudo')

@carousel(['ibagens' => ["/images/galeria1/RM10.png"]])
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
        {{ $titulo }}
      </h1>
    </div>
    <div class="info">
      @dataELocal(['data' => 'dezembro 2019', 'local' => 'galeria vermelho, são paulo'])
        
      @enddataELocal
      @assuntos(['tags' => ['educação', 'astronomia', 'dança', 'algo ambient']])
  
      @endassuntos
    </div>
    @fichaTecnica(['display' => 'd-none d-md-block'])
        
    @endfichaTecnica
  </div>
  <div class="col-md-5 offset-md-1">
    <div class="row">
      @texto
          
      @endtexto
      @notas(['display' => 'd-md-block'])
          
      @endnotas
      @galeria([
        
        'display' => 'd-none d-md-block', 
      
        'ibagens' => [
          "/images/galeria1/MissBaker.png",
          "/images/galeria1/RM1.png",
          "/images/galeria1/RM4.jpg",
          "/images/galeria1/RM5.jpg",
          "/images/galeria1/RM6.png",
          "/images/galeria1/RM10.png"

      ]])
          
      @endgaleria
    </div>
    <div class="col ficha d-md-none">
      @galeriaMobile(['display' => 'd-block d-md-none'])
  
      @endgaleriaMobile
      @fichaTecnica(['display' => 'd-block d-md-none'])
        
      @endfichaTecnica
      @parceiros(['display' => 'd-block d-md-none', 'titulo' => 'parceiros'])
  
      @endparceiros
    </div>
  </div>
</div>


@stop