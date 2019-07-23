@extends('site.layouts.base')
@section('conteudo')

<div class="row justify-content-center" id="projetos">
  <div class="col-md-8">
    <div class="row no-gutters">
      <div class="col-md-12" id="legendas">
        <div class="leg-item">
          <img src="{{ asset('/images/passado.png') }}" alt="">
          <p>
            passado
          </p>
        </div>
        <div class="leg-item">
          <img src="{{ asset('/images/presente.png') }}" alt="">
          presente
        </div>
        <div class="leg-item">
          <img src="{{ asset('/images/futuro.png') }}" alt="">
          futuro
        </div>
        <div class="leg-item cap-c">
          <img src="{{ asset('/images/externo.png') }}" alt="">
          externos
        </div>
      </div>
    </div>
    <div class="row no-gutters" id="proj-gal">
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
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
  </div>
</div>

@stop