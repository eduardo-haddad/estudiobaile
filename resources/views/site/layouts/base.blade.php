<!DOCTYPE html>
<html>
  <head>
    <title>{{ env('APP_NAME')  }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/site/app.css') }}" />
    <script src="{{ asset('js/app.js') }}"></script>
  </head>

  <body>
    <div class="container-fluid" id="geral">
      {{-- Header --}}
      @include('site.elements.header')

      {{-- Conteúdo --}}
      @yield('conteudo')
    </div>
  </body>
</html>
