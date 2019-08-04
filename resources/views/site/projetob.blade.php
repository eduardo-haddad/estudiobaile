@extends('site.layouts.base')
@section('conteudo')

@component('site.components.carousel')

@endcomponent
<div class="row projeto tipo-d justify-content-center" id="corpo">
  <div class="ficha col-md-2">
    <div class="titulo">
      <h1>
        Projeto B
      </h1>
      <span class="med">Residências artísticas<br>
      em contexto educativos</span>
    </div>
    <div class="info">
      <div class="campo">
        <span class="bold">temporada 1</span>
        <p>
          dezembro 2019
        </p>
      </div>
      <div class="campo">
        <span class="bold">temporada 2</span>
        <p>janeiro 2020</p>
      </div>
    </div>
    <div class="info">
      {{-- TODO line-height desse campo difere em A e B --}}
      <div class="campo">
        <p>assuntos</p>
        <span class="bold">educação<br>
          astronomia<br>
          dança<br>
        </span>
      </div>
    </div>
  </div>
  <div class="col-md-5 offset-md-1">
    <div class="row">
      <div class="col-md-9 col-fix-9">
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
          <p>
            Com objetivo de estreitar as relações entre artista, escola e comunidade, a equipe do Pousos realizará um aprofundado trabalho preparatório antes do início da residência. Nesse sentido buscamos entender juntos quais seriam os interesses da escola em ter um artista desenvolvendo sua prática in loco e chegarmos a uma dinâmica que seja interessante para a comunidade. O professor de artes da escola poderá ser muito valioso nesse processo, apontando questões de interesse pedagógico que podem ser valorizadas na experiência.
          </p>
        </div>
      </div>
      <div class="col-md-3 col-fix-3"></div>
    </div>
    <div class="row">
      <div class="col">
        <div class="texto">
          <div class="subprojeto">
            <div class="portrait">
              <h1 class="bold">Temporada 1</h1>
              <span class="bold">2019</span>
              <p>galeria vermelho,</p>
              <p>são paulo</p>
            </div>
            <div class="thumb landscape">
              <a href="{{ url('/site/projetod') }}"><img src="{{ asset('/images/galeria1/RM10.png') }}" alt=""></a>
            </div>
          </div>
          <div class="subprojeto">
            <div class="portrait">
              <h1 class="bold">Temporada 2</h1>
              <span class="bold">2020</span>
              <p>galeria vermelho,</p>
              <p>são paulo</p>
            </div>
            <div class="thumb landscape">
              <img src="{{ asset('/images/galeria1/RM6.png') }}" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@stop