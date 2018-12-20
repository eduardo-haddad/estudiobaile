@if(Auth::check()) 
<ul id="menu_principal">
    <li class="opcao" id="estudiobaile">
        <router-link :to="{ name: 'pj-view', params: { id: 1 }}">Estúdio Baile</router-link>
    </li>
    <li class="opcao" id="projetos">
        <router-link :to="{ name: 'projetos-index'}">Projetos</router-link>
    </li>
    <li class="opcao" id="pf">
        <router-link :to="{ name: 'pf-index'}">Pessoas Físicas</router-link>
    </li>
    <li class="opcao" id="pj">
        <router-link :to="{ name: 'pj-index'}">Pessoas Jurídicas</router-link>
    </li>
    <li class="opcao" id="tags">
        <router-link :to="{ name: 'tags-index'}">Tags</router-link>
    </li>
    <li class="opcao" id="interna">
        <router-link :to="{ name: 'interna-view'}">Interna</router-link>
    </li>

    @if(!Auth::user()->hasRole('usuario'))
        <li class="opcao" id="usuarios">
            <router-link :to="{ name: 'usuarios-index'}">Usuários</router-link>
        </li>
    @endif

</ul>

<div id="inferior">
    <div class="add_contato">
        <div class="botao">
            <div class="botao_inner">
                <img src="{{ asset('img/btn_add.png') }}" id="show-modal" @click="showModal = true" />
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

{{--<div class="modal" tabindex="-1" role="dialog" id="user_modal">--}}
    {{--<div class="modal-dialog" role="document">--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
                {{--<h5 class="modal-title">Modal title</h5>--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                    {{--<span aria-hidden="true">&times;</span>--}}
                {{--</button>--}}
            {{--</div>--}}
            {{--<div class="modal-body">--}}
                {{--<p>Modal body text goes here.</p>--}}
            {{--</div>--}}
            {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
@endif

