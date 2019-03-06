@php
    $logado = Auth::check();
@endphp

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>BD - Estúdio Baile</title>

        <!-- Variáveis globais -->
        <script>
            const ROOT = "{{ url('/') }}";
            const ISADMIN = "@php echo $logado ? Auth::user()->hasRole('administrador') : '' @endphp";
            const USERID = "@php echo $logado ? Auth::user()->id : '' @endphp";
        </script>
    
        <!-- Scripts -->
        @if(Auth::check())
            <script src="{{ asset('js/app.js') }}" defer></script>
        @endif

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        {{--<link href="{{ asset('css/bootstrap/bootstrap.css') }}" rel="stylesheet">--}}
        {{--<link href="{{ asset('css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet">--}}

    </head>
<body>

    <div id="app">

        <div id="principal">

            <div id="container_geral">

                {{-- Cabeçalho --}}
                <header id="cabecalho">
                    @include('admin/elements/cabecalho')
                </header>

                {{-- Sidebar --}}
                @if(Auth::check())
                <nav id="sidebar">
                    @include('admin/elements/sidebar')
                </nav>
                @endif

                {{-- Conteúdo geral --}}
                @if(!Auth::check())
                    @yield('login')
                @else
                    <div id="conteudo_geral">
                        <router-view></router-view>
                    </div>
                @endif

                {{-- Modal novos registros --}}
                @if(Auth::check())
                    <modal v-if="showModal" @close="showModal = false">
                        <h3 slot="header">Novo registro</h3>
                    </modal>
                @endif

            </div>



        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>--}}

</body>
</html>