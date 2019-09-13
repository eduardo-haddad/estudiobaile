<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Estúdio Baile')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/site/app.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('css/swipebox.css') }}"> --}}
    <script src="{{ asset('js/site.js') }}"></script>
    {{-- <script src="{{ asset('js/jquery.swipebox.js') }}"></script> --}}

    @stack('scripts')
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
