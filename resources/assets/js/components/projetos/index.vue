<template>

    <div class="lista_conteudo">
        <nav class="lista">
            <ul>
                <li v-for="(projeto, index) in projetos" :key="projeto.id">
                    <router-link v-if="projeto" :id="projeto.id" :to="{ name: 'projetos-view', params: { id: projeto.id }}">{{ projeto.nome }}</router-link>
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
            axios.get('/admin/ajax/projetos/index').then(res => {
                this.projetos = res.data;
                //console.log(this.pessoas);
            });

            //evento - registro salvo em projetos-view
            eventBus.$on('foiSalvo', projeto => {
                let id_atual = this.$route.params.id;
                this.$set(this.projetos, this.projetos.findIndex(p => p.id == id_atual), {
                    nome: projeto.nome,
                    id: projeto.id
                });
            });
        },
        data() {
            return {
                projetos: [],
            }
        },
        methods: {}
    }
</script>