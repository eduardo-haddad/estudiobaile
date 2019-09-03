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
      <div class="imagemAgenda {{ $epocaProjeto }}">
        <div class="captionMobile {{ $tipoC }}">
          <p>
            {{ $nomeProjeto }}
          </p>
          <h1 class="atividade data">
            Atividade do projeto
          </h1>
          <p class="bold mb-0 eventoMobile">
            {{ $dataProjeto }}
          </p>
          <p class="eventoMobile">local</p>
          <div class="eventoMobile d-none">
            <p class="mb-0">
              com <span class="bold">fulano de tal</span>
            </p>
            <p class="mb-0">
              {{ $dataProjeto }}
            </p>
            <p>
              <a href="#">inscrições aqui</a>
            </p>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt similique necessitatibus odit repudiandae mollitia est amet velit deserunt fugiat unde laudantium suscipit animi sapiente, iste delectus beatae hic modi consequatur?
            </p>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt similique necessitatibus odit repudiandae mollitia est amet velit deserunt fugiat unde laudantium suscipit animi sapiente, iste delectus beatae hic modi consequatur?
            </p>
            <div class="fechar">
              {{-- <img src="{{ asset('images/mobile/fecharAgenda.png') }}" alt=""> --}}
            </div>
          </div>
        </div>
        <img src="{{ $imagem }}" alt="">
      </div>
      <div class="caption {{ $tipoC }}">
        <p class="data">{{  $dataProjeto }}</p>
        <p class="bold">{{ $nomeProjeto }}</p>
        <p>{{ $tag }} / {{ $tag }}</p>
      </div>
    </div>

  @endforeach
      
  </div>
</div>