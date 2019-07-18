@extends('site.layouts.base')
@section('conteudo')

<div class="row" id="carrousel">
  <div class="col-8 car-w">
    <img src="{{ asset('/images/galeria1/RM10.png') }}" alt="">
  </div>
</div>
<div class="row projeto tipo-d" id="corpo">
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
          <p>
            Como a escritora inglesa Jeanette Winterson escreveu, “Observar quadros durante muito tempo é como ser abandonado numa cidade estrangeira: aos poucos, por vontade própria ou desespero, algumas palavras-chave, e depois certa sintaxe, abrem caminho em meio ao silêncio. A arte, qualquer arte, não apenas a pintura, é uma cidade estrangeira, e é engano pensar que ela nos é familiar. Ninguém se surpreende ao constatar que uma cidade estrangeira tem costumes e idioma próprios. Somente um insensível não levaria em conta esses fatores e culparia o lugar pela própria ignorância. É o que acontece com o artista e com a arte todos os dias. Temos de reconhecer que a linguagem da arte, de qualquer arte, não é nossa língua materna”.1
          </p>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
    <div class="row">
      <div class="col">
        <div class="galeria">
          <h2 class="bold">galeria</h2>
          <div class="thumb landscape">
            <img src={{ asset('/images/galeria1/RM2.png') }}>
          </div>
          <div class="thumb portrait">
            <img src={{ asset('/images/galeria1/RM1.png') }}>
          </div>
          <div class="thumb portrait">
            <img src={{ asset('/images/galeria1/RM4.jpg') }}>
          </div>
          <div class="thumb landscape">
            <img src={{ asset('/images/galeria1/RM5.jpg') }}>
          </div>
          <div class="thumb portrait">
            <img src={{ asset('/images/galeria1/RM2.png') }}>
          </div>
          <div class="thumb landscape">
            <img src={{ asset('/images/galeria1/RM1.png') }}>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@stop