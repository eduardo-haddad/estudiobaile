@extends('site.layouts.base')
@section('title', 'sobre')    
@section('conteudo')

<div class="row justify-content-center" id="sobre">
  <div class="col-md-3 order-md-1 order-2">
    <div class="scroll">
      <div class="texto">
        <h1>
          o que é <br>
          o estúdio baile
        </h1>
        <p>
          O Estúdio Baile nasce com o intuito de promover ações que evidenciem o pensamento artístico: quais são as operações de um artista? que processos desencadeiam? o que está no cerne de suas questões? Iniciativas que desloquem o artista de seus contextos já habituais e os aproxima a agentes de outras áreas, espaços de naturezas diversas e públicos variados, emprestando, assim, o olhar do artista a outros campos do conhecimento. Ao mesmo tempo, são propostas que experimentam se perguntar: o que é de fundamental importância na figura do artista para nossa sociedade hoje?
        </p>
        <p>
          Em seu programa prevalecem projetos de natureza híbrida, que partem das artes visuais para se relacionar com outras linguagens, como dança, teatro, artes gráficas, música, cinema, literatura. O Estúdio promove encontros inusitados, formando novos pares e coreografias ao conectar autores, instituições, marcas e agentes da cultura, sempre somando forças com iniciativas já existentes. O Baile acontece nos espaços da arte, mas também nas fábricas, nas escolas e bibliotecas, na praça ou na nuvem - basta ser lugar com possibilidade de relação e alguma permeabilidade. 
        </p>
        <p>
          Além das propostas concebidas internamente, o estúdio também oferece consultorias e desenvolve projetos sob encomenda, desde sua elaboração e produção até articulações institucionais.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-2 offset-md-1 order-md-2 order-3">
    <div class="scroll">
      <div class="texto d-none d-md-block">
        <div class="info">
          <a class="bold" href="mailto:estudio@estudiobaile.org" target="_blank">estudio@estudiobaile.org</a>
          <p>
            rua cônego eugênio leite, 920
          </p>
          <p>pinheiros, são paulo</p>
          <p class="smoll">+55 11 23068579</p>
        </div>
      </div>
      <div class="texto">
        <h1>
          equipe
        </h1>
        <p>
          Thereza Farkas graduou-se em Cinema pela FAAP (2008) e em artes cênicas pelo Teatro Escola Célia-Helena (2003). Desde então realizou alguns projetos curatoriais, como as exposições Wabi-Sabi (2011) e Futuro do Pretérito (2012) na galeria Mendes Wood, em São Paulo, e hoje dedica-se à gestão de projetos artísticos. Em 2009 co-fundou a Casa Tomada, espaço de investigação artística dedicado ao incentivo e à discussão da jovem arte contemporânea brasileira, onde atuou até final de 2012. Em 2013, passa a atuar como diretora institucional e de programação na Associação Cultural Videobrasil, dedicada ao fomento, difusão e mapeamento da arte contemporânea, com especial atenção à produção do circuito geopolítico Sul e ao video enquanto linguagem artística. Em 2018, abre o Estúdio Baile.
        </p>
      </div>
    </div>
    <div class="ficha d-block d-md-none">
      <div class="info">
        <div class="campo">
          <span class="bold">
            João Simões
          </span>
          <p>coordenação de projetos</p>
        </div>
        <div class="campo">
          <span class="bold">
            Marcos Reis
          </span>
          <p>coordenação administrativa</p>
        </div>
        <div class="campo">
          <span class="bold">
            Mariana Dupas
          </span>
          <p>função</p>
        </div>
        <div class="campo">
          <span class="bold">Nichollas Além</span>
          <p>consultoria jurídica</p>
        </div>
        <div class="campo">
          <span class="bold">Nina Farkas</span>
          <p>identidade visual</p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-2 order-md-3 order-1">
    <div class="scroll ">
      <div class="logo-vertical">
        <img src="{{ asset('images/logo-vertical.png') }}" alt="">
      </div>
      <div class="ficha d-none d-md-block">
        <div class="info">
          <div class="campo">
            <span class="bold">
              João Simões
            </span>
            <p>coordenação de projetos</p>
          </div>
          <div class="campo">
            <span class="bold">
              Marcos Reis
            </span>
            <p>coordenação administrativa</p>
          </div>
          <div class="campo">
            <span class="bold">
              Mariana Dupas
            </span>
            <p>função</p>
          </div>
          <div class="campo">
            <span class="bold">Nichollas Além</span>
            <p>consultoria jurídica</p>
          </div>
          <div class="campo">
            <span class="bold">Nina Farkas</span>
            <p>identidade visual</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
      <div class="footer rodaPe">
        <div class="text d-block d-md-none">
          <div class="info">
            <a class="bold" href="mailto:estudio@estudiobaile.org" target="_blank">estudio@estudiobaile.org</a>
            <p>
              rua cônego eugênio leite, 920
            </p>
            <p>pinheiros, são paulo</p>
            <p class="smoll">+55 11 23068579</p>
          </div>
        </div>
      </div>

@stop