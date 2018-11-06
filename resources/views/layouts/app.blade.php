<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>{{ config('app.name', 'Estúdio Baile') }}</title>
    
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet">
    </head>
<body>

    <div id="app">

        <div id="principal">

            <div id="container_geral">

                <header id="cabecalho">
                    @include('admin/elements/cabecalho')
                </header>

                <nav id="sidebar">
                    @include('admin/elements/sidebar')
                </nav>

                <div id="conteudo_geral">
                    @if(!Auth::check())
                        @yield('login')
                    @endif
                    <router-view></router-view>
                </div>

            </div>

        </div>


    </div>

</body>
</html>