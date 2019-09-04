<div id="carouselAgendaArea">

  <div class="carouselAgenda">

  @foreach($ibagens as $imagem)

    @php
      // randomizar valores gerais
      $numeroRandonia = mt_rand(0, 2);
      
      // numero randomico especifico para atribuir "projeto tipo c"
      $randomC = mt_rand(0, 4);
      $tipoC = ($randomC == 0 ? "cap-c" : ""); 
      
      // condicionais para teste
      if ($numeroRandonia == 0) {
        $epocaAgenda = "passado";
        $dataAgenda = "agosto 2019";
        $tag = "tag1";
      } else if ($numeroRandonia == 1) {
        $epocaAgenda = "presente";
        $dataAgenda = "setembro 2019";
        $tag = "tag2";
      } else {
        $epocaAgenda = "futuro";
        $dataAgenda = "janeiro 2020";
        $tag = "tag3";
      }

      //variaveis hardcoded
      $tituloAgenda = "Nome do projeto";
      $autorAgenda = "fulano de tal";
      $localAgenda = "local";
      $atividadeAgenda = "Atividade do projeto";
      $textoAgenda = <<<EOT

      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt similique necessitatibus odit repudiandae mollitia est amet velit deserunt fugiat unde laudantium suscipit animi sapiente, iste delectus beatae hic modi consequatur?
      </p>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt similique necessitatibus odit repudiandae mollitia est amet velit deserunt fugiat unde laudantium suscipit animi sapiente, iste delectus beatae hic modi consequatur?
      </p>
      
EOT;
      
    @endphp

    <div class="slide">
      <div class="imagemAgenda {{ $epocaAgenda }}">
        <div class="conteudoMobile {{ $tipoC }}">
          <p>
            {{ $tituloAgenda }}
          </p>
          <h1 class="atividade data">
            {{ $atividadeAgenda }}
          </h1>
          <p class="bold mb-0 eventoMobile">
            {{ $dataAgenda }}
          </p>
          <p class="eventoMobile">
            {{ $localAgenda }}
          </p>
          <div class="eventoMobile d-none">
            <p class="mb-0">
              com <span class="bold">{{ $autorAgenda }}</span>
            </p>
            <p class="mb-0">
              {{ $dataAgenda }}
            </p>
            <p>
              <a href="#">inscrições aqui</a>
            </p>
              {!! $textoAgenda !!}
            <div class="fecharMob"></div>
          </div>
        </div>
        <img src="{{ $imagem }}" alt="" class="abrir">
      </div>
      <div class="caption {{ $tipoC }}">
        <p class="data">{{  $dataAgenda }}</p>
        <p class="bold">{{ $tituloAgenda }}</p>
        <p>{{ $tag }} / {{ $tag }}</p>
      </div>
      <div class="conteudo d-none {{ $epocaAgenda }} {{ $tipoC }}">
        <div class="fechar"></div>
        <p>
          {{ $tituloAgenda }}
        </p>
        <h1>
          {{ $atividadeAgenda }}
        </h1>
        <p class="bold mb-0 eventoMobile">
          {{ $dataAgenda }}
        </p>
        <p class="eventoMobile">
          {{ $localAgenda }}
        </p>
    
        <p class="mb-0">
          com <span class="bold">{{ $autorAgenda }}</span>
        </p>
        <p>
          <a href="#">inscrições aqui</a>
        </p>
          {!! $textoAgenda !!}
    
      </div>
    </div>
    
    @endforeach
    
  </div>
</div>