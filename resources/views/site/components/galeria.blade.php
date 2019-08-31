<div class="col-12">
  <div class="row">
    <div class="col {{ $display }}">
      <div class="galeria">
        <h2 class="bold">galeria</h2>
        
        @foreach ($ibagens as $i => $imagem)
          
          @php
            //orientação de acordo com a altura e a largura da imagem

            // list($width, $height) = getimagesize("$_SERVER[DOCUMENT_ROOT]$imagem");
            
            // if ($width > $height) {
            //   $orientacao = "landscape";
            // } else {
            //   $orientacao = "portrait";
            // }

            // orientação randomica (2 thumbs por iteração)
            
            $randOrient = rand(0, 1);

            // if ($i % 2 != 0) {
            $orientacao = ($randOrient == 0 ? "portrait" : "landscape");
            // } else {
            $orientacao2 = ($randOrient == 1 ? "portrait" : "landscape");
            // }
            $legenda = "Legenda";
            $credito = "Crédito";
            
          @endphp
            
          <div class="thumb {{ $orientacao }}">
            <div class="hoverThumb transparente">
              <div class="captionGaleria">
                <p>{{ $legenda }}</p>
                <p>{{ $credito }}</p>
              </div>
            </div>
            <a href="{{ $imagem }}" class="swipebox" title="caption">
              <img src="{{ $imagem }}" alt="image" class="imgProj">
            </a>
          </div>

          <div class="thumb {{ $orientacao2 }}">
            <div class="hoverThumb transparente">
              <div class="captionGaleria">
                <p>{{ $legenda }}</p>
                <p>{{ $credito }}</p>
              </div>
            </div>
            <a href="{{ $imagem }} " class="swipebox" title="caption">
              <img src="{{ $imagem }}" alt="image" class="imgProj">
            </a>
          </div>
            
        @endforeach
        {{-- <div class="thumb landscape">
          <a href="{{ asset('/images/galeria1/RM2.png') }}" class="swipebox" title="caption">
            <img src="{{ asset('/images/galeria1/RM2.png') }}" alt="image" class="imgProj">
          </a>
        </div>
        <div class="thumb portrait">
          <a href="{{ asset('/images/galeria1/RM1.png') }}" class="swipebox" title="caption">
            <img src={{ asset('/images/galeria1/RM1.png') }} class="ble">
          </a>
        </div>
        <div class="thumb portrait">
          <a href="{{ asset('/images/galeria1/RM4.jpg') }}" class="swipebox" title="caption">
            <img src={{ asset('/images/galeria1/RM4.jpg') }}>
          </a>
        </div>
        <div class="thumb landscape">
          <a href="{{ asset('/images/galeria1/RM5.jpg') }}" class="swipebox" title="caption">
            <img src={{ asset('/images/galeria1/RM5.jpg') }}>
          </a>
        </div>
        <div class="thumb portrait">
          <a href="{{ asset('/images/galeria1/RM2.png') }}" class="swipebox" title="caption">
            <img src={{ asset('/images/galeria1/RM2.png') }}>
          </a>
        </div>
        <div class="thumb landscape">
          <a href="{{ asset('/images/galeria1/RM1.png') }}" class="swipebox" title="caption">
            <img src={{ asset('/images/galeria1/RM1.png') }}>
          </a>
        </div> --}}
      </div>
    </div>
  </div>
</div>
