<div class="container">

    <div class="logo">
        <router-link :to="{ name: 'home'}">
            <img src="{{ asset('img/logo.png') }}" />
        </router-link>
    </div>
            
    <div class="usuario">    

        @guest
            <div class="login"><a href="{{ route('login') }}">{{ __('Login') }}</a></div>
        @else
        
            <div id="nome_usuario">
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