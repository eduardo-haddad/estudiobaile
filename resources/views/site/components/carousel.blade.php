<div class="row justify-content-center" id="carouselProjetoArea">
  <div class="col-md-8">

      @php
        $imagens = [
        asset('/images/proja.png'),
        asset('/images/projb.png'),  
        asset('/images/projc.png')
        ];
      @endphp

      <div id="carouselProjeto" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner">
          @foreach($imagens as $i => $imagem)
            <div class="carousel-item {{$i == 0 ? "active" : ""}}">
              <img class="d-block w-100" src="{{ $imagem }}" alt="{{'slide'.$i}}">
            </div>
          @endforeach
        </div>

        <a class="carousel-control-prev" href="#carouselProjeto" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselProjeto" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
        
    </div>
  </div>
</div>