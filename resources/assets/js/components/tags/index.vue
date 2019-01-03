<template>

    <div>
        <div class="busca_lista">
            <div class="lupa_texto_container">
                <div class="lupa_texto">
                    <div class="lupa"></div>
                    <input type="text" placeholder="Buscar" />
                </div>
            </div>
            <nav class="lista" id="lista_tags">
                <ul>
                    <li v-for="(tag, index) in tags" :key="tag.id" :class="{ selecionado: itemAtual(tag.id, $route.params.id) }">
                        <router-link v-if="tag" :id="tag.id" :to="{ name: 'tags-view', params: { id: tag.id }}">{{ tag.text }}</router-link>
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
        mounted() {
            axios.get('/ajax/tags/index').then(res => {
                this.tags = res.data;
            });

            //highlight menu
            this.highlight_menu();

            //evento - registro salvo em tags-view
            eventBus.$on('foiSalvoTag', tag => {
                let id_atual = this.$route.params.id;
                this.$set(this.tags, this.tags.findIndex(p => p.id == id_atual), {
                    text: tag.text,
                    id: tag.id
                });
            });
            //evento - tag carregada
            eventBus.$on('getTag', (id) => {
                //Scroll
                if(this.primeiro_load) {
                    this.scroll(id);
                    this.primeiro_load = false;
                }
            });
            //evento - mudança de projeto
            eventBus.$on('changeTag', () => {});
            //evento - tag removida - atualiza lista de tags se não atribuída a ninguém
            eventBus.$on('tagRemovida', (tags) => this.tags = tags);
        },
        watch: {
            '$route' () {
                this.highlight_menu();
            },
        },
        data() {
            return {
                tags: [],
                item_selecionado: false,
                primeiro_load: true
            }
        },
        methods: {
            itemAtual: (id_tag, id_rota) => {
                this.item_selecionado = parseInt(id_tag, 10) === parseInt(id_rota, 10);
                return this.item_selecionado;
            },
            scroll: (id) => {
                let myElement = document.getElementById(id);
                let topPos = myElement.offsetTop;
                document.getElementById('lista_tags').scrollTop = topPos - 60;
            },
            highlight_menu: () => {
                const menu = document.getElementById("menu_principal");
                let items = menu.getElementsByTagName("li");
                let url = window.location.hash;
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