@extends('site.layouts.base')
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
    <div class="col-md-2">
      <div class="thu-projeto futuro">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag + tag</p>
      </div>
    </div>
    <div class="col-md-2">
      <div class="thu-projeto presente">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption cap-c">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag</p>
      </div>
    </div>
    <div class="col-md-2">
      <div class="thu-projeto passado">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag + tag + tag</p>
      </div>
    </div>
    <div class="col-md-2">
      <div class="thu-projeto passado">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag + tag + tag</p>
      </div>
    </div>
    <div class="w-100"></div>
    <div class="col-md-2">
      <div class="thu-projeto presente">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag</p>
      </div>
    </div>
    <div class="col-md-2">
      <div class="thu-projeto presente">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag</p>
      </div>
    </div>
    <div class="col-md-2">
      <div class="thu-projeto futuro">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag + tag</p>
      </div>
    </div>
    <div class="col-md-2">
      <div class="thu-projeto passado">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag + tag + tag</p>
      </div>
    </div>
    <div class="w-100"></div>
    <div class="col-md-2">
      <div class="thu-projeto passado">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag + tag + tag</p>
      </div>
    </div>
    <div class="col-md-2">
      <div class="thu-projeto passado">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag + tag + tag</p>
      </div>
    </div>
    <div class="col-md-2">
      <div class="thu-projeto passado">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag + tag + tag</p>
      </div>
    </div>
    <div class="col-md-2">
      <div class="thu-projeto futuro">
        <img src="{{ asset('images/galeria1/MissBaker.png') }}" alt="">
      </div>
      <div class="caption">
        <p class="bold">
          Nome do Projeto
        </p>
        <p>tag</p>
      </div>
    </div>
  </div>

@stop