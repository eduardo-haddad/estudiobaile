<template>

    <div class="lista_conteudo">
        <nav class="lista">
            <ul>
                <li v-for="(pessoa, index) in pessoas" :key="pessoa.id">
                    <router-link v-if="pessoa" :id="pessoa.id" :to="{ name: 'pf-view', params: { id: pessoa.id }}">{{ pessoa.nome_adotado }}</router-link>
                </li>
            </ul>
        </nav>

        <div class="conteudo">
            <router-view></router-view>
        </div>
    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';

    console.log(eventBus);

    export default {
        mounted() {
            axios.get('/admin/ajax/pf/index').then(res => {
                this.pessoas = res.data;
            });

            //evento - registro salvo em pf-view
            eventBus.$on('foiSalvo', pessoa => {
                let id_atual = this.$route.params.id;
                this.$set(this.pessoas, this.pessoas.findIndex(p => p.id === id_atual), {
                    nome_adotado: pessoa.nome_adotado,
                    id: pessoa.id
                });
            });
        },
        data() {
            return {
                pessoas: [],
            }
        },
        methods: {}
    }
</script>