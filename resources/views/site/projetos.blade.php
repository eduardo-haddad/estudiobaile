@extends('site.layouts.base')
@section('title', 'projetos')    
@section('conteudo')

  <div class="row justify-content-center projetos">
    <div class="col-md-8 legendas">
      <div class="leg-item">
        <img src="{{ asset('/images/passado.png') }}" alt="">
        <p>
          passado
        </p>
      </div>
      <div class="leg-item">
        <img src="{{ asset('/images/presente.png') }}" alt="">
        <p>
          presente
        </p>
      </div>
      <div class="leg-item">
        <img src="{{ asset('/images/futuro.png') }}" alt="">
        <p>
          futuros
        </p>
      </div>
      <div class="leg-item cap-c">
        <img src="{{ asset('/images/externo.png') }}" alt="">
        <p>
          projetos tipo c
        </p>
      </div>
      <hr>
    </div>
  </div>
  <div class="row justify-content-center projetos">
    
    <div class="col-md-8">
      <div class="row">
        @foreach ($imagens as $i => $imagem)

        @php

          // numero randomico especifico para atribuir "projeto tipo c"
          $randomC = mt_rand(0, 4);
          $tipoC = ($randomC == 0 ? "cap-c" : "");
          
          // randomizar epoca para teste
          $numeroRandonia = mt_rand(0, 2);
          if ($numeroRandonia == 0) {
            $epocaProjeto = "passado";
            $tag = "tag1";
          } else if ($numeroRandonia == 1) {
            $epocaProjeto = "presente";
            $tag = "tag2";
          } else {
            $epocaProjeto = "futuro";
            $tag = "tag3";
          }

          //
          $tituloProjeto = "Nome do projeto";
          $urlProjeto = "#"

        @endphp
            
          <div class="col-md-3">
            <div class="thumbProjeto {{ $epocaProjeto }}">
              <a href="{{ $urlProjeto }}"><img src="{{ $imagem }}" alt=""></a>
            </div>
            <div class="caption {{ $tipoC }}">
              <p class="bold">
                {{ $tituloProjeto }}
              </p>
              <p>{{ $tag }} + {{ $tag }}</p>
            </div>
          </div>
    
        @endforeach
      </div>
    </div>
    
  </div>

@stop