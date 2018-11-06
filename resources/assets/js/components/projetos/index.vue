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
                    <li v-for="(projeto, index) in projetos" :key="projeto.id">
                        <router-link v-if="projeto" :id="projeto.id" :to="{ name: 'projetos-view', params: { id: projeto.id }}">{{ projeto.nome }}</router-link>
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
            axios.get('/admin/ajax/projetos/index').then(res => {
                this.projetos = res.data;
                //console.log(this.pessoas);
            });

            //evento - registro salvo em projetos-view
            eventBus.$on('foiSalvoProjeto', projeto => {
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