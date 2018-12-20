<template>

    <div id="container_conteudo" class="formulario">

        <div class="titulo">
            <div class="imagem_destaque">
                <img :src="imagem_destaque" />
            </div>
            <div class="nome">
                <span v-model="nome" v-text="nome"></span>
            </div>
        </div>
        <br>
        <br>
        <br>



        <!--DADOS GERAIS-->

        <div class="valor">
            <span class="campo">Nome</span>
            <input autocomplete="off" type="text"
                   name="nome"
                   @input="nome = $event.target.value"
            />
        </div>
        <br>
        <br>
        <br>
        <button @click.prevent="criar(nome)">Salvar</button>

    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';

    export default {
        mounted() {
            //imagem
            this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
        },
        beforeUpdate() {
            //carregado
            eventBus.$emit('projetoCreate');
        },
        data() {
            return {
                root: ROOT,
                imagem_destaque: '',
                nome: 'Novo Projeto',
            }
        },
        watch: {},
        computed: {},
        methods: {
            criar: function(nome) {
                axios.post('/ajax/projetos/create', {
                    nome: nome,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.$router.push({ name: 'projetos-view', params: { id: res.data }});
                    } else
                        console.log('Erro ao criar projeto');
                });
            }
        }
    }
</script>