<template>

    <div>
        <div class="busca_lista">
            <div class="lupa_texto_container">
                <div class="lupa_texto">
                    <div class="lupa"></div>
                    <input type="text" placeholder="Buscar" />
                </div>
            </div>
            <nav class="lista" id="lista_pj">
                <ul>
                    <li v-for="(pessoa, index) in pessoas" :key="pessoa.id" :class="{ selecionado: itemAtual(pessoa.id, $route.params.id) }">
                        <router-link v-if="pessoa" :id="pessoa.id" :to="{ name: 'pj-view', params: { id: pessoa.id }}">{{ pessoa.nome_fantasia }}</router-link>
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
            axios.get('/admin/ajax/pj/index').then(res => {
                this.pessoas = res.data;
            });

            //highlight menu
            this.highlight_menu();

            //evento - registro salvo em pj-view
            eventBus.$on('foiSalvoPessoaJuridica', pessoa => {
                let id_atual = this.$route.params.id;
                this.$set(this.pessoas, this.pessoas.findIndex(p => p.id == id_atual), {
                    nome_fantasia: pessoa.nome_fantasia,
                    id: pessoa.id
                });
            });
            //evento - pessoa física carregada
            eventBus.$on('getPessoaJuridica', () => {
                this.item_carregado = true;
                //Scroll
                if(this.primeiro_load) {
                    this.scroll(this.$route.params.id);
                    this.primeiro_load = false;
                }
            });
            //evento - mudança de pessoa física
            eventBus.$on('changePessoaJuridica', () => this.item_carregado = false);
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
                let myElement = document.getElementById(id);
                let topPos = myElement.offsetTop;
                document.getElementById('lista_pj').scrollTop = topPos - 60;
            },
            highlight_menu: () => {
                const menu = document.getElementById("menu_principal");
                let items = menu.getElementsByTagName("li");
                let url = window.location.href.split('/admin#/')[1];
                for (let i = 0; i < items.length; ++i) {
                    if(url.includes(items[i].id))
                        items[i].className = "opcao selecionado";
                    else
                        items[i].className = "opcao";
                }
            }
        }
    }
</script>