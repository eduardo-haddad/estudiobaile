@if(Auth::check()) 
<ul>
    {{-- Home --}}
    {{--<li class="grupo">--}}
        {{--<span>Pessoas físicas</span>--}}
    {{--</li>--}}

    {{-- Pessoa física --}}
    <li class="opcao">
        {{--<a href="{{ route('pf.create') }}">Cadastrar</a>--}}
        <router-link :to="{ name: 'pf-index'}">Pessoas Físicas</router-link>
    </li>
    <li class="opcao">
        {{--<a href="{{ route('pf.create') }}">Cadastrar</a>--}}
        <router-link :to="{ name: 'pj-index'}">Pessoas Jurídicas</router-link>
    </li>
    <li class="opcao">
        <router-link :to="{ name: 'projetos-index'}">Projetos</router-link>
    </li>
    
    {{-- Post --}}
    {{-- <li>
        <a href="{{ route('post.create') }}">Create new post</a>
    </li> --}}

    {{-- Category --}}
    {{-- <li>
        <a href="{{ route('category.create') }}">Create new category</a>
    </li>
    <li>
        <a href="{{ route('categories') }}">View all categories</a>
    </li> --}}
</ul> 
<div id="inferior">
    {{-- Registrar novo usuário --}}
    @if(Auth::user()->hasRole('administrador')) 
        <div class="registrar">
            <a href="{{ route('register') }}">
                {{ __('Register new user') }}
            </a>
        </div>
    @endif
</div>
@endif