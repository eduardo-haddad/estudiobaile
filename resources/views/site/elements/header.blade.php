  <div id="header">
    <div class="row justify-content-center">
      <div class="col-6 col-md-2">
        <div id="logo">
          <a href='{!! url('/site'); !!}'><img src="/images/logo.png"></a>
        </div>
      </div>
      <div class="col-6 d-md-none" id="menuMobileArea">
        <div class="hamburguer toggleMenu">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>

        @include('site.elements.menuMobile')
        
      </div>
      <div class="col-md-1 d-none d-md-block"> 
        <div class="nave">
          <a href="{{ route('sobre') }}" 
          @if(Route::currentRouteName() === 'sobre') class="itemAtivo" @endif>
            sobre
          </a>
        </div>
      </div>
      <div class="col-1 d-none d-md-block">
        <div class="nave">
          <a href="{{ route('projetos') }}" 
          @if (Route::currentRouteName() === 'projetos') class="itemAtivo" @endif>
            projetos
          </a>
        </div>
      </div>
      <div class="col-1 d-none d-md-block">
        <div class="nave">
          <a href="{{ route('agenda') }}" 
          @if(Route::currentRouteName() === 'agenda') class="itemAtivo" @endif>
            agenda
          </a>
        </div>
      </div>
      <div class="col-1"></div>
      <div class="col-md-2 d-none d-md-block">
        <div id="redes">
          <div class="tooltipster icon loc" data-tooltip-content="#tooltip_content"></div>
          <div id="tooltip_templates">
            <div id="tooltip_content">
              <div class="localizacao">
                <a href="mailto:estudio@estudiobaile.org" target="_blank">estudio@estudiobaile.org</a>
                <p>rua cônego eugênio leite, 920</p>
                <p>piniheiros, são paulo</p>
                <p>+55 11 2306 8679</p>
              </div>
            </div>
          </div>
          <div class="icon">
            <a href="https://www.facebook.com/baile.estudio/" target="_blank">
              <img src="/images/fb.png" alt="">
            </a>
          </div>
          <div class="icon">
            <a href="https://www.instagram.com/estudio_baile/" target="_blank">
              <img src="/images/insta.png" alt="">
            </a>
          </div>
          <p><a href="#">PT</a> / <a href="#">EN</a></p>
        </div>
      </div>
    </div>
  </div>