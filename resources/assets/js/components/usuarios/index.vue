<template>

    <div>
        <div class="busca_lista">
            <div class="lupa_texto_container">
                <div class="lupa_texto">
                    <div class="lupa"></div>
                    <input type="text" v-model="busca" placeholder="Buscar" />
                </div>
            </div>
            <nav class="lista" id="lista_usuarios">
                <ul>
                    <li v-for="(usuario, index) in listaFiltrada" :key="usuario.id" :class="{ selecionado: itemAtual(usuario.id, $route.params.id) }">
                        <router-link v-if="usuario" :id="usuario.id" :to="{ name: 'usuarios-view', params: { id: usuario.id }}">{{ usuario.name }}</router-link>
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
            //highlight menu principal
            this.highlight_menu();

            //evento - pessoa física carregada
            eventBus.$on('getUsuario', (id) => this.getLista(id));

            //evento - página de criação de pessoa física
            eventBus.$on('usuarioCreate', () => {
                this.create = true;
            });

            //evento - registro salvo em usuario-view
            eventBus.$on('foiSalvoUsuario', usuario => {
                this.$set(this.usuarios, this.usuarios.findIndex(p => p.id == this.$route.params.id), {
                    name: usuario.name,
                    id: usuario.id
                });
            });

            //evento - mudança de usuario
            eventBus.$on('changeUsuario', () => {});
            //evento - usuario removido - atualiza lista de usuarios
            eventBus.$on('usuarioRemovido', (usuarios) => this.usuarios = usuarios);
        },
        watch: {
            '$route' () {
                //this.highlight_menu();
            },
        },
        data() {
            return {
                //Models
                usuarios: [],
                busca: '',
                //Condicionais
                item_selecionado: false,
                primeiro_load: true,
                create: false,
            }
        },
        computed: {
            listaFiltrada() {
                return this.usuarios.filter(item => {
                    return item.name.toLowerCase().includes(this.busca.toLowerCase())
                })
            }
        },
        methods: {
            getLista: function(id) {
                axios.get('/ajax/usuarios/index')
                    .then(res => this.usuarios = res.data)
                    .then(() => this.highlight_menu)
                    .then(() => {
                        if(typeof id !== "undefined") this.scrollOnLoad(id);
                    })
            },
            itemAtual: (id_usuario, id_rota) => {
                this.item_selecionado = parseInt(id_usuario, 10) === parseInt(id_rota, 10);
                return this.item_selecionado;
            },
            scroll: (id) => {
                let myElement = document.getElementById(id);
                let topPos = myElement.offsetTop;
                document.getElementById('lista_usuarios').scrollTop = topPos - 60;
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
            },
        }
    }
</script>