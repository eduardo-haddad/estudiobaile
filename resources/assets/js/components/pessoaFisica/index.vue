<template>

    <div>
        <div class="busca_lista">
            <div class="lupa_texto_container">
                <div class="lupa_texto">
                    <div class="lupa"></div>
                    <input type="text" v-model="busca" placeholder="Buscar" />
                </div>
            </div>
            <nav class="lista" id="lista_pf">
                <ul>
                    <li v-for="(pessoa, index) in listaFiltrada" :key="pessoa.id" :class="{ selecionado: itemAtual(pessoa.id, $route.params.id) }">
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
        beforeDestroy() {console.log('beforeDestroy')},
        destroyed() {console.log('destroyed')},
        beforeUpdate() {console.log('beforeUpdate')},
        updated() {
            console.log('updated');
            if(this.item_carregado) this.item_carregado = false;
        },
        created() {
            //carrega lista
            this.getLista();
        },
        mounted() {
            //highlight menu principal
            this.highlight_menu();

            //evento - pessoa física carregada
            eventBus.$on('getPessoaFisica', (id) => {
                this.getLista(id);
                this.item_carregado = true;
                console.log(`item_carregado em getPessoaFisica: ${this.item_carregado}`);
            });

            //evento - página de criação de pessoa física
            eventBus.$on('pessoaFisicaCreate', () => {
                this.item_carregado = true;
                console.log(`item_carregado em pessoaFisicaCreate: ${this.item_carregado}`);
                this.create = true;
            });

            //evento - registro salvo em pf-view
            eventBus.$on('foiSalvoPessoaFisica', pessoa => {
                this.$set(this.pessoas, this.pessoas.findIndex(p => p.id == this.$route.params.id), {
                    nome_adotado: pessoa.nome_adotado,
                    id: pessoa.id
                });
            });

            //evento - mudança de pessoa física
            eventBus.$on('changePessoaFisica', () => {
                this.item_carregado = false
                console.log(`item_carregado em changePessoaFisica: ${this.item_carregado}`);
            });
        },
        watch: {
            '$route' () {
                //this.highlight_menu();
            },
            //'item_carregado' (valor) {console.log(`item_carregado: ${valor}`)},

        },
        data() {
            return {
                //Models
                pessoas: [],
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
                return this.pessoas.filter(item => {
                    return item.nome_adotado.toLowerCase().includes(this.busca.toLowerCase())
                })
            }
        },
        methods: {
            getLista: function(id) {
                axios.get('/ajax/pf/index')
                    .then(res => {
                        this.pessoas = res.data;
                    })
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
                document.getElementById('lista_pf').scrollTop = topPos - 60;
            },
            scrollOnLoad: function(id) {
                if(this.primeiro_load) this.primeiro_load = false;
                if(this.create) this.create = false;
                if(this.primeiro_load || this.create) this.scroll(id);
                // this.item_carregado = false;
                // console.log(`item_carregado em scrollOnLoad: ${this.item_carregado}`);
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
            },
        }
    }
</script>