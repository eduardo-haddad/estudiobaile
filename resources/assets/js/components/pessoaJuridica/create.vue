<template>

    <div id="container_conteudo" class="formulario">

        <div class="titulo">
            <div class="imagem_destaque">
                <img :src="imagem_destaque" />
            </div>
            <div class="nome">
                <span v-model="nome_fantasia" v-text="nome_fantasia"></span>
            </div>
        </div>
        <br>
        <br>
        <br>



        <!--DADOS GERAIS-->

        <div class="valor">
            <span class="campo">Nome fantasia</span>
            <input autocomplete="off" type="text"
                   name="nome_fantasia"
                   @input="nome_fantasia = $event.target.value"
            />
        </div>
        <br>
        <br>
        <br>
        <button @click.prevent="criar(nome_fantasia)">Salvar</button>

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
            eventBus.$emit('pessoaJuridicaCreate');
        },
        data() {
            return {
                root: ROOT,
                imagem_destaque: '',
                nome_fantasia: 'Nova Pessoa Jurídica',
            }
        },
        watch: {},
        computed: {},
        methods: {
            criar: function(nome) {
                axios.post('/admin/ajax/pj/create', {
                    nome_fantasia: nome,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.$router.push({ name: 'pj-view', params: { id: res.data }});
                    } else
                        console.log('Erro ao criar pessoa jurídica');
                });
            }
        }
    }
</script>