@if(Auth::check()) 
<ul id="menu_principal">
    {{-- Pessoa física --}}
    <li class="opcao" id="pf">
        <router-link :to="{ name: 'pf-index'}">Pessoas Físicas</router-link>
    </li>
    <li class="opcao" id="pj">
        <router-link :to="{ name: 'pj-index'}">Pessoas Jurídicas</router-link>
    </li>
    <li class="opcao" id="projetos">
        <router-link :to="{ name: 'projetos-index'}">Projetos</router-link>
    </li>
</ul>

<div id="inferior">
    <div class="add_contato">
        <div class="botao">
            <div class="botao_inner">
                <img src="{{ asset('img/btn_add.png') }}" />
            </div>
        </div>
    </div>


    {{-- Registrar novo usuário --}}
    {{--@if(Auth::user()->hasRole('administrador')) --}}
        {{--<div class="registrar">--}}
            {{--<a href="{{ route('register') }}">--}}
                {{--{{ __('Register new user') }}--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--@endif--}}
</div>
@endif

