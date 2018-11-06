<template>

    <div>
        <div class="busca_lista">
            <div class="lupa_texto_container">
                <div class="lupa_texto">
                    <div class="lupa"></div>
                    <input type="text" placeholder="Buscar" />
                </div>
            </div>
            <nav class="lista">
                <ul>
                    <li v-for="(pessoa, index) in pessoas" :key="pessoa.id" :class="{ selecionado: itemAtual(pessoa.id, $route.params.id) }">
                        <router-link v-if="pessoa" :id="pessoa.id" :to="{ name: 'pf-view', params: { id: pessoa.id }}">{{ pessoa.nome_adotado }}</router-link>
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
            axios.get('/admin/ajax/pf/index').then(res => {
                this.pessoas = res.data;
                console.log(this.pessoas);
                //Scroll item selecionado
                this.scroll(this.id_atual);
            });

            //evento - registro salvo em pf-view
            eventBus.$on('foiSalvoPessoaFisica', pessoa => {
                this.$set(this.pessoas, this.pessoas.findIndex(p => p.id == this.id_atual), {
                    nome_adotado: pessoa.nome_adotado,
                    id: pessoa.id
                });
            });
        },
        data() {
            return {
                pessoas: [],
                item_selecionado: false,
                id_atual: this.$route.params.id
            }
        },
        methods: {
            itemAtual: (id_pessoa, id_rota) => {
                this.item_selecionado = parseInt(id_pessoa, 10) === parseInt(id_rota, 10);
                return this.item_selecionado;
            },
            scroll: (item) => {
                let elemento = $(item);
                console.log(this.item_selecionado);
                let top = elemento.offsetTop;
                if(this.item_selecionado) {
                    window.scrollTo(0, top);
                }
            },
        }
    }
</script>