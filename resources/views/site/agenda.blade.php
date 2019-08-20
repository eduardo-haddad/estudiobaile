@extends('site.layouts.base')
@section('conteudo')

<div class="row justify-content-center agenda formArea">
  <div class="col-md-1">
    <div class="fique">
      <div class="porDentro">
        <p class="bold">
          fique <br>
          por dentro!
          </p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <form action="">
      @csrf
      <div class="formWrap">
        <div class="formulario">
          <label class="item" >
            nome:
          </label>
          <input class="grow">
        </div>
        <div class="formulario">
          <label class="item">
            email:
          </label>
          <input class="grow">
        </div>
        <div class="formulario">
          <label class="item">
            ocupação:
          </label>
          <input class="grow">
        </div>
        <div class="formulario">
          <label class="item">
            cidade onde vive:
          </label>
          <input class="grow">
        </div>
      </div>
      <button type="submit">ok</button>
    </form>
  </div>
</div>
<div class="row justify-content-center agenda visualArea">
  <div class="col-12 col-md-8">
    <div class="legendas">
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
    </div>
    <div class="carouselAgenda">
      AGENDA
    </div>
  </div>
</div>

@stop