<!DOCTYPE html>
<html>
  <head>
    <title>##!!!Estúdio Baile!!!###</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/site/app.css') }}" />
    <script src="{{ asset('js/app.js') }}"></script>
  </head>

  <body>
    <div class="container-fluid" id="geral">
      <div class="row" id="header">
        <div class="col-2">
          <div class="logo">
            <a href='{!! url('/'); !!}'><img src="images/logo.png"></a>
          </div>
        </div>
        <div class="col-1 nav">
          <a href="">sobre</a>
        </div>
        <div class="col-1 nav">
          <a href="">projetos</a>
        </div>
        <div class="col-1 nav">
          <a href="">agenda</a>
        </div>
        <div class="col-1"></div>
        <div class="col-2">
          <div id="redes">
            <img src="images/loc.png" data-toggle="tooltip" class="loc">
            <img src="images/fb.png" alt="">
            <img src="images/insta.png" alt="">
            <p>PT / EN</p>
          </div>
        </div>
      </div>
      @yield('conteudo')
    </div>
  </body>
</html>
