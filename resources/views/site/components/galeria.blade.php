<div class="col-12">
  <div class="row">
    <div class="col {{ $display }}">
      <div class="galeria">
        <h2 class="bold">galeria</h2>
        
        @foreach ($ibagens as $i => $imagem)
          
          @php

            //0 ou 1, randômico
            if($i % 2 == 0){
              $rand = mt_rand(0, 1);  
            } 
            
            $orientacao = ["portrait", "landscape"];
            $classe = $orientacao[$rand];

            $legenda = "Legenda";
            $credito = "Crédito";

          @endphp
            
          <div class="thumb {{ $classe }}">
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

          @php

            $rand = !$rand;

          @endphp
            
        @endforeach

      </div>
    </div>
  </div>
</div>
