<template v-if="this.pessoa">

    <div id="container_conteudo" class="formulario">

            <div class="titulo">{{ this.pessoa.nome_fantasia }}</div>
            <br>

    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';

    export default {
        created() {
            this.getPessoa(this.$route.params.id);
            this.jQuery();
          },
        data() {
            return {
                //Models
                pessoa: {},

                //Campos de inclusão

                //Condicionais

            }
        },
        watch: {
            '$route' (destino) {
                this.getPessoa(destino.params.id);
                this.jQuery();
            },
        },
        computed: {

        },
        methods: {
            getPessoa: function(id){
                axios.get('/admin/ajax/pj/' + id).then(res => {
                    let dados = res.data;
                    this.pessoa = dados.pessoa_juridica;
                    console.log(dados);
                } );
            },
            salvaForm: function(){
                axios.post('/admin/ajax/pj/save', {
                    pessoa: this.pessoa,
                }).then(res => {
                    this.pessoa = res.data;
                    eventBus.$emit('foiSalvoPj', this.pessoa);
                });
            },

            jQuery: function(){

                //Instancia atual do Vue
                let Vue = this;
            },
        }
    }
</script>