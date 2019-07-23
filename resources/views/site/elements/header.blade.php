<div class="row justify-content-center" id="header">
  <div class="col-2">
    <div id="logo">
      <a href='{!! url('/site'); !!}'><img src="/images/logo.png"></a>
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
      <a href="">agenda</a>
    </div>
  </div>
  <div class="col-1"></div>
  <div class="col-md-2 d-none d-md-block">
    <div id="redes">
      <img src="/images/loc.png" data-toggle="tooltip" class="loc">
      <img src="/images/fb.png" alt="">
      <img src="/images/insta.png" alt="">
      <p><a href="#">PT</a> / <a href="#">EN</a></p>
    </div>
  </div>
</div>