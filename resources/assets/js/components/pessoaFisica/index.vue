<template>

    <div>
        <div class="busca_lista">
            <div class="lupa_texto_container">
                <div class="lupa_texto">
                    <div class="lupa"></div>
                    <input type="text" placeholder="Buscar" />
                </div>
            </div>
            <nav class="lista" id="lista_pf">
                <ul>
                    <li v-for="(pessoa, index) in pessoas" :key="pessoa.id" :class="{ selecionado: itemAtual(pessoa.id, $route.params.id) }">
                        <router-link v-if="pessoa" :id="pessoa.id" :to="{ name: 'pf-view', params: { id: pessoa.id }}">{{ pessoa.nome_adotado }}</router-link>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="detalhe" :class="{ loading: !item_carregado, loaded: item_carregado }">
            <router-view></router-view>
        </div>
    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';

    export default {
        mounted() {
            axios.get('/admin/ajax/pf/index').then(res => {
                this.pessoas = res.data;
            });

            //highlight menu
            this.highlight_menu();

            //evento - registro salvo em pf-view
            eventBus.$on('foiSalvoPessoaFisica', pessoa => {
                this.$set(this.pessoas, this.pessoas.findIndex(p => p.id == this.$route.params.id), {
                    nome_adotado: pessoa.nome_adotado,
                    id: pessoa.id
                });
            });
            //evento - pessoa física carregada
            eventBus.$on('getPessoaFisica', () => {
                this.item_carregado = true;
                //Scroll
                if(this.primeiro_load) {
                    this.scroll(this.$route.params.id);
                    this.primeiro_load = false;
                }
            });
            //evento - mudança de pessoa física
            eventBus.$on('changePessoaFisica', () => this.item_carregado = false);
        },
        watch: {
            '$route' () {
                this.highlight_menu();
            },
        },
        data() {
            return {
                pessoas: [],
                item_selecionado: false,
                item_carregado: false,
                primeiro_load: true
            }
        },
        methods: {
            itemAtual: (id_pessoa, id_rota) => {
                this.item_selecionado = parseInt(id_pessoa, 10) === parseInt(id_rota, 10);
                return this.item_selecionado;
            },
            scroll: (id) => {
                let id_scroll = id.toString();
                let myElement = document.getElementById(id_scroll);
                let topPos = myElement.offsetTop;
                document.getElementById('lista_pf').scrollTop = topPos - 60;
            },
            highlight_menu: () => {
                const menu = document.getElementById('menu_principal');
                let items = menu.getElementsByTagName('li');
                let url = window.location.href.split('/admin#/')[1];
                for (let i = 0; i < items.length; ++i) {
                    if(url.includes(items[i].id))
                        items[i].className = "opcao selecionado";
                    else
                        items[i].className = "opcao";
                }
            },
        }
    }
</script>