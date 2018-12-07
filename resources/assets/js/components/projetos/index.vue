<template>

    <div>
        <div class="busca_lista">
            <div class="lupa_texto_container">
                <div class="lupa_texto">
                    <div class="lupa"></div>
                    <input type="text" v-model="busca" placeholder="Buscar" />
                </div>
            </div>
            <nav class="lista" id="lista_projetos">
                <ul>
                    <li v-for="(projeto, index) in listaFiltrada" :key="projeto.id" :class="{ selecionado: itemAtual(projeto.id, $route.params.id) }">
                        <router-link v-if="projeto" :id="projeto.id" :to="{ name: 'projetos-view', params: { id: projeto.id }}">{{ projeto.nome }}</router-link>
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
        created() {
            //carrega lista
            this.getLista();
        },
        mounted() {
            //highlight menu
            this.highlight_menu();

            //evento - pessoa física carregada
            eventBus.$on('getProjeto', (id) => this.getLista(id));

            //evento - página de criação de projeto
            eventBus.$on('projetoCreate', () => {
                this.item_carregado = true;
                this.create = true;
            });

            //evento - registro salvo em projetos-view
            eventBus.$on('foiSalvoProjeto', projeto => {
                let id_atual = this.$route.params.id;
                this.$set(this.projetos, this.projetos.findIndex(p => p.id == id_atual), {
                    nome: projeto.nome,
                    id: projeto.id
                });
            });

            //evento - mudança de projeto
            eventBus.$on('changeProjeto', () => this.item_carregado = false);
        },
        watch: {
            '$route' () {
                //this.highlight_menu();
            },
        },
        data() {
            return {
                //Models
                projetos: [],
                busca: '',
                //Condicionais
                item_selecionado: false,
                item_carregado: false,
                primeiro_load: true,
                create: false,
            }
        },
        computed: {
            listaFiltrada() {
                return this.projetos.filter(item => {
                    return item.nome.toLowerCase().includes(this.busca.toLowerCase())
                })
            }
        },
        methods: {
            getLista: function(id) {
                axios.get('/admin/ajax/projetos/index')
                    .then(res => this.projetos = res.data)
                    .then(() => this.highlight_menu)
                    .then(() => this.scrollOnLoad(id));
            },
            itemAtual: (id_pessoa, id_rota) => {
                this.item_selecionado = parseInt(id_pessoa, 10) === parseInt(id_rota, 10);
                return this.item_selecionado;
            },
            scroll: (id) => {
                let myElement = document.getElementById(id);
                let topPos = myElement.offsetTop;
                document.getElementById('lista_projetos').scrollTop = topPos - 60;
            },
            scrollOnLoad: function(id) {
                if(this.primeiro_load) this.primeiro_load = false;
                if(this.create) this.create = false;
                if(this.primeiro_load || this.create) this.scroll(id);
                this.item_carregado = true;
            },
            highlight_menu: () => {
                const menu = document.getElementById('menu_principal');
                let items = menu.getElementsByTagName('li');
                let url = window.location.href.split('/admin#/')[1];
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