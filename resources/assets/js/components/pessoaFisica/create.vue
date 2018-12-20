<template>

    <div id="container_conteudo" class="formulario">

        <div class="titulo">
            <div class="imagem_destaque">
                <img :src="imagem_destaque" />
            </div>
            <div class="nome">
                <span v-model="nome_adotado" v-text="nome_adotado"></span>
            </div>
        </div>
        <br>
        <br>
        <br>



        <!--DADOS GERAIS-->

        <div class="valor">
            <span class="campo">Nome adotado</span>
            <input autocomplete="off" type="text"
                   name="nome_adotado"
                   @input="nome_adotado = $event.target.value"
            />
        </div>
        <br>
        <br>
        <br>
        <button @click.prevent="criar(nome_adotado)">Salvar</button>

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
            eventBus.$emit('pessoaFisicaCreate');
        },
        data() {
            return {
                root: ROOT,
                imagem_destaque: '',
                nome_adotado: 'Nova Pessoa Física',
            }
        },
        watch: {},
        computed: {},
        methods: {
            criar: function(nome) {
                axios.post('/ajax/pf/create', {
                    nome_adotado: nome,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.$router.push({ name: 'pf-view', params: { id: res.data }});
                    } else
                        console.log('Erro ao criar pessoa física');
                });
            }
        }
    }
</script>