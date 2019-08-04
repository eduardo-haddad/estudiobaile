  <div id="header">
    <div class="row justify-content-center">
      <div class="col-6 col-md-2">
        <div id="logo">
          <a href='{!! url('/site'); !!}'><img src="/images/logo.png"></a>
        </div>
      </div>
      <div class="col-6 d-md-none menuMobile">
        <div class="hamburguer">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </div>
      <div class="col-md-1 d-none d-md-block"> 
        {{-- TODO highlight item ativo no menu --}}
        <div class="nave">
          <a href="{{ url('/site/sobre') }}">sobre</a>
        </div>
      </div>
      <div class="col-1 d-none d-md-block">
        <div class="nave">
          <a href="{{ url('/site/projetos') }}">projetos</a>
        </div>
      </div>
      <div class="col-1 d-none d-md-block">
        <div class="nave">
          <a href="{{ url('/site/agenda') }}">agenda</a>
        </div>
      </div>
      <div class="col-1"></div>
      <div class="col-md-2 d-none d-md-block">
        <div id="redes">
          <img src="/images/loc.png" class="tooltipster loc" data-tooltip-content="#tooltip_content">
          <div id="tooltip_templates">
            <div id="tooltip_content">
              <p class="">teste</p>
              <p>teste</p>
              <p>teste</p>
              <p>teste</p>
            </div>
          </div>
          <a href="https://www.facebook.com/baile.estudio/" target="_blank"><img src="/images/fb.png" alt=""></a>
          <a href="https://www.instagram.com/estudio_baile/" target="_blank"><img src="/images/insta.png" alt=""></a>
          <p><a href="#">PT</a> / <a href="#">EN</a></p>
        </div>
      </div>
    </div>
  </div>