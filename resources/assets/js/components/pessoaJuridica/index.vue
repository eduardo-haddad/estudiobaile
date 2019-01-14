<template>

    <div>
        <div class="busca_lista">
            <div class="lupa_texto_container">
                <div class="lupa_texto">
                    <div class="lupa"></div>
                    <input type="text" v-model="busca" placeholder="Buscar" />
                </div>
            </div>
            <nav class="lista" id="lista_pj">
                <ul>
                    <li v-for="(pessoa, index) in listaFiltrada" :key="pessoa.id" :class="{ selecionado: itemAtual(pessoa.id, $route.params.id) }">
                        <router-link v-if="pessoa" :id="pessoa.id" :to="{ name: 'pj-view', params: { id: pessoa.id }}">{{ pessoa.nome_fantasia }}</router-link>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="detalhe">
            <router-view></router-view>
        </div>
    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';

    export default {
        created() {
            //carrega lista
            this.getLista();
        },
        mounted() {
            //highlight menu
            this.highlight_menu();

            //evento - pessoa física carregada
            eventBus.$on('getPessoaJuridica', (id) => this.getLista(id));

            //evento - página de criação de pessoa jurídica
            eventBus.$on('pessoaJuridicaCreate', () => {
                this.create = true;
            });

            //evento - pessoa física deletada
            eventBus.$on('deletePessoaJuridica', (pessoas) => {
                this.pessoas = pessoas;
            });

            //evento - registro salvo em pj-view
            eventBus.$on('foiSalvoPessoaJuridica', pessoa => {
                //let id_atual = this.$route.params.id;
                // this.$set(this.pessoas, this.pessoas.findIndex(p => p.id == id_atual), {
                //     nome_fantasia: pessoa.nome_fantasia,
                //     id: pessoa.id
                // });
                this.getLista(pessoa.id);
            });

            //evento - mudança de pessoa física
            eventBus.$on('changePessoaJuridica', () => {});
        },
        watch: {
            '$route' () {
                //this.highlight_menu();
            },
        },
        data() {
            return {
                //Models
                pessoas: [],
                busca: '',
                //Condicionais
                item_selecionado: false,
                primeiro_load: true,
                create: false,
            }
        },
        computed: {
            listaFiltrada() {
                return this.pessoas.filter(item => {
                    return item.nome_fantasia.toLowerCase().includes(this.busca.toLowerCase())
                })
            }
        },
        methods: {
            getLista: function(id) {
                axios.get('/ajax/pj/index')
                    .then(res => this.pessoas = res.data)
                    .then(() => this.highlight_menu)
                    .then(() => {
                        if(typeof id !== "undefined") this.scrollOnLoad(id);
                    })
            },
            itemAtual: (id_pessoa, id_rota) => {
                this.item_selecionado = parseInt(id_pessoa, 10) === parseInt(id_rota, 10);
                return this.item_selecionado;
            },
            scroll: (id) => {
                let myElement = document.getElementById(id);
                let topPos = myElement.offsetTop;
                document.getElementById('lista_pj').scrollTop = topPos - 60;
            },
            scrollOnLoad: function(id) {
                if(this.primeiro_load) this.primeiro_load = false;
                if(this.create) this.create = false;
                if(this.primeiro_load || this.create) this.scroll(id);
            },
            highlight_menu: () => {
                const menu = document.getElementById('menu_principal');
                let items = menu.getElementsByTagName('li');
                let url = window.location.hash;
                for (let i = 0; i < items.length; ++i) {
                    if(url.includes(items[i].id))
                        items[i].className = 'opcao selecionado';
                    else
                        items[i].className = 'opcao';
                }
            }
        }
    }
</script>