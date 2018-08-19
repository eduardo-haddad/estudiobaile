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
    
        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet">
    </head>
<body>

    <div id="app">

        

        <div id="principal">

                <header id="cabecalho">
                    @include('admin/elements/cabecalho')
                </header>

            <nav id="sidebar">
                @include('admin/elements/sidebar')
            </nav>

            

            <div id="conteudo">
                @yield('content')
            </div>

        </div>


    </div>
    

    
</body>
</html>