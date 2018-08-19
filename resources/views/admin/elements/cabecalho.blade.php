<div class="container">

    <div class="logo">
        {{-- <a href="{{ url('/') }}">
            {{ config('app.name') }}
        </a> --}}
        <img src="{{ asset('img/logo.png') }}" />
    </div>
            
    <div class="usuario">    

        @guest
        <div class="login"><a href="{{ route('login') }}">{{ __('Login') }}</a></div>
        @else
        
        <div class="nome_usuario">
            {{ Auth::user()->name }} 
        </div>
            
        <div class="logout">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>    
        
        @endguest

    </div>

</div>