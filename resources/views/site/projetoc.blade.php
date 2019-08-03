@extends('site.layouts.base')
@section('conteudo')

@component('site.components.carousel')

@endcomponent
<div class="row projeto tipo-c justify-content-center" id="corpo">
  <div class="ficha col-md-2">
    <div class="titulo">
      <h1>
        Projeto C
      </h1>
      <span class="med">Residências artísticas<br>
      em contexto educativos</span>
    </div>
    <div class="info">
      <div class="campo">
        <p>
          realização
        </p>
        <div class="parceiros">
          <img src="{{ asset('/images/parceiros.png') }}" alt="">
          <img src="{{ asset('/images/parceiros.png') }}" alt="">
        </div>
      </div>
      <div class="campo">
        <p>organização</p>
        <div class="logo-externo">
          <img src="{{ asset('/images/logo-solo.png') }}" alt="">
        </div>
      </div>
    </div>
    <div class="info">
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
        <p>data</p>
        <span class="bold">dezembro 2019</span>
      </div>
      <div class="campo">
        <p>onde</p>
        <span class="bold">galeria vermelho, são paulo</span>
      </div>
      <div class="campo">
        <p>tags</p>
        <span class="bold">educação <br>
        astronomia <br>
        dança <br>
        </span>
      </div>
    </div>
  </div>
  <div class="col-md-5 offset-md-1">
    <div class="row">
      <div class="col-md-10">
        <div class="texto">
          <p>
            Atualmente no Brasil, temos a elaboração e a implementação de uma Base Nacional Comum Curricular para a educação artística nos níveis de Educação Infantil, Ensino Fundamental e Ensino Médio. A Base estabelece nove objetivos de aprendizagem para a Educação Infantil, ligados a traços, sons, cores e formas, e delineia para o Ensino Fundamental 61 objetivos, relacionados a artes visuais, teatro, música, dança e artes integradas.
          </p>
          <p>
            Mas algumas perguntas permanecem: quando, e como, as crianças entram em contato com a arte, em geral? O que é iniciação artística? Por que a arte é essencial na formação do ser humano? Que tipo de conhecimento caracteriza a arte? Qual a contribuição especí ca que a arte traz para a educação? Como garantir que cada indivíduo, em suas particularidades, tenha acesso a uma formação que envolva e considere a arte?
          </p>
          <p>
            Estamos convictos de que a arte tem algo a lecionar. Sabemos, contudo, que não basta estar diante de uma obra para aprender com ela. À primeira vista, a obra de arte parece trivial. Portanto, buscamos lidar com ela do mesmo modo como lidamos com outras coisas do nosso cotidiano. Aos poucos, porém, a arte nos impõe seu caráter misterioso, enigmático, de compreensão menos evidente e múltiplas leituras possíveis.
          </p>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
</div>


@stop