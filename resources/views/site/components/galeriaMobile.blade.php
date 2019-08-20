<div class="row justify-content-center" id="carouselGaleriaArea">
  <div class="col-md-8 {{ $display }}">

      @php
        $imagensg = [
        asset('/images/galeria1/MissBaker.png'),
        asset('/images/galeria1/RM1.png'),  
        asset('/images/galeria1/RM2.png'),
        asset('/images/galeria1/RM4.jpg'),
        asset('/images/galeria1/RM6.png'),

        ];
      @endphp
      <div class="campo bold">galeria</div>

      <div id="carouselGaleriaMobile" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          @foreach($imagensg as $ig => $imagemg)
            <div class="carousel-item {{$ig == 0 ? "active" : ""}}">
              <img class="d-block w-100" src="{{ $imagemg }}" alt="{{'slide'.$ig}}">
            </div>
          @endforeach
        </div>

        <a class="carousel-control-prev" href="#carouselGaleriaMobile" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselGaleriaMobile" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

  </div>
</div>