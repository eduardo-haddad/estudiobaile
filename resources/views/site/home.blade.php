@extends('site.layouts.base')
@section('conteudo')

<div class="row" id="banner">
  <div class="col ban-w">
    {{-- <img src="images/banner1.png"> --}}
  </div>
</div>
<div class="row" id="main">
  <div class="col-2 esc">
    <p>
      escolha por onde começar a busca de <a href="">projetos</a>
    </p>
  </div>
  <div class="col-2 bep">
    <div class="num">
        1
    </div>
    <div class="mic-b">
      <ul class="lista">
        <li><a href="">assunto</a></li>
        <li><a href="">lugar</a></li>
        <li><a href="">parceria</a></li>
        <li><a href="">pessoa</a></li>
      </ul>
    </div>
  </div>
  <div class="col-2 bep">
    <div class="num">
        2
    </div>
    <div class="mic-b">
      <ul class="lista">
        <li><a href="">fulano de tal</a></li>
        <li><a href="">fulano de tal</a></li>
        <li><a href="">fulano de tal</a></li>
        <li><a href="">fulano de tal</a></li>
        <li><a href="">beltrano de tal</a></li>
        <li><a href="">beltrano de tal</a></li>
        <li><a href="">ciclano de tal</a></li>
        <li><a href="">ciclano de tal</a></li>
      </ul>
    </div>
  </div>
  <div class="col-2 bep">
    <div class="num">
        3
    </div>
    <div class="mic-b">
      <ul class="lista">
        <li><a href='{!! route('projetoa'); !!}'>Projeto AAAA</a></li>
        <li><a href="">nome do projeto</a></li>
        <li><a href="">nome do projeto</a></li>
        <li><a href="">nome do projeto</a></li>
        <li><a href="">nome do projeto</a></li>
        <li><a href="">nome do projeto</a></li>
        <li><a href="">nome do projeto</a></li>
        <li><a href="">nome do projeto</a></li>
        <li><a href="">nome do projeto</a></li>
        <li><a href="">nome do projeto</a></li>
        <li><a href="">nome do projeto</a></li>
      </ul>
    </div>
  </div>
</div>

@stop