<div id="carouselAgendaArea">

  <div class="carouselAgenda">

  @foreach($ibagens as $imagem)

    @php
      // randomizar valores gerais
      $numeroRandonia = rand(0, 2);
      $nomeProjeto = "Nome do projeto";

      // numero randomico especifico para atribuir "projeto tipo c"
      $randomC = rand(0, 4);
      $tipoC = ($randomC == 0 ? "cap-c" : ""); 
      
      // condicionais para teste
      if ($numeroRandonia == 0) {
        $epocaProjeto = "passado";
        $dataProjeto = "agosto 2019";
        $tag = "tag1";
      } else if ($numeroRandonia == 1) {
          $epocaProjeto = "presente";
          $dataProjeto = "setembro 2019";
          $tag = "tag2";
      } else {
        $epocaProjeto = "futuro";
        $dataProjeto = "janeiro 2020";
        $tag = "tag3";
      }

    @endphp

    <div class="slide">
      <div class="imagemAgenda {{ $epocaProjeto }}"><img src="{{ $imagem }}" alt=""></div>
      <div class="caption {{ $tipoC }}">
        <p class="data">{{  $dataProjeto }}</p>
        <p class="bold">{{ $nomeProjeto }}</p>
        <p>{{ $tag }} / {{ $tag }}</p>
      </div>
    </div>

  @endforeach
      
  </div>
</div>