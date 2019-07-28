@extends('site.layouts.base')
@section('conteudo')

<div class="row justify-content-center agenda formArea">
  <div class="col-md-1">
    <div class="interjeicao">
      <p class="bold">
        fique <br>
        por dentro!
        </p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="formWrap">
      <form class="formulario">
        <label class="item" >
          nome:
        </label>
        <input class="grow">
      </form>
      <form class="formulario">
        <label class="item">
          email:
        </label>
        <input class="grow">
      </form>
      <form class="formulario">
        <label class="item">
          ocupação:
        </label>
        <input class="grow">
      </form>
      <form class="formulario">
        <label class="item">
          cidade onde vive:
        </label>
        <input class="grow">
      </form>
    </div>
    <button type="submit">ok</button>
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