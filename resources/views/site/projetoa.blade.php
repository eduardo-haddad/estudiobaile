@extends('site.layouts.base')
@section('conteudo')

@carousel(['ibagens' => [
  "/images/proja.png",
  "/images/projb.png",
  "/images/projc.png"
]])
@endcarousel

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
    @fichaTecnica(['display' => 'd-none d-md-block'])
        
    @endfichaTecnica
    @parceiros(['display' => 'd-none d-md-block'])

    @endparceiros
  </div>
  <div class="col-md-5 offset-md-1">
    <div class="row">
      @texto
          
      @endtexto
      @notas(['display' => 'd-md-block'])
          
      @endnotas
      @galeria(['display' => 'd-none d-md-block'])
      
      @endgaleria
      <div class="col ficha">
        @galeriaMobile(['display' => 'd-block d-md-none'])
  
        @endgaleriaMobile
        @fichaTecnica(['display' => 'd-block d-md-none'])
          
        @endfichaTecnica
        @parceiros(['display' => 'd-block d-md-none'])
  
        @endparceiros
      </div>
    </div>
  </div>
</div>


@stop