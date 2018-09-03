@if(Auth::check()) 
<ul>
    {{-- Home --}}
    <li class="grupo">
        <span>Pessoas físicas</span>
    </li>

    {{-- Pessoa física --}}
    <li class="opcao">
        {{--<a href="{{ route('pf.create') }}">Cadastrar</a>--}}
        <router-link :to="{ name: 'ajax-pf-index'}">Lista</router-link>
    </li>
    <li class="opcao">
        {{--<a href="{{ route('pf.index') }}">(ver todas)</a>--}}
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