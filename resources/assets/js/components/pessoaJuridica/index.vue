<template>

    <div class="lista_conteudo">
        <nav class="lista">
            <ul>
                <li v-for="(pessoa, index) in pessoas" :key="pessoa.id">
                    <router-link v-if="pessoa" :id="pessoa.id" :to="{ name: 'pj-view', params: { id: pessoa.id }}">{{ pessoa.nome_fantasia }}</router-link>
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

    export default {
        mounted() {
            axios.get('/admin/ajax/pj/index').then(res => {
                this.pessoas = res.data;
                //console.log(this.pessoas);
            });

            //evento - registro salvo em pj-view
            eventBus.$on('foiSalvoPj', pessoa => {

                let id_atual = this.$route.params.id;
                this.$set(this.pessoas, this.pessoas.findIndex(p => p.id == id_atual), {
                    nome_fantasia: pessoa.nome_fantasia,
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