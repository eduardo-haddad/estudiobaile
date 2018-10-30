<template v-if="this.pessoa">

    <div id="container_conteudo" class="formulario">

        <div class="titulo">{{ this.pessoa.nome_fantasia }}</div>
        <div class="titulo" style="font-size: 16px">{{ this.pessoa.razao_social }}</div>

        <br>
        <!-- Tags -->
        <span class="campo">Tags</span>
        <select @change="tags_atuais = $event.target.value" name="tags" id="tags_list" class="js-example-basic-single">
            <option v-for="tag in tags" :value="tag.id" v-model="tag.id">{{ tag.text }}</option>
        </select>

        <!-- Pessoa Física / Chancela -->
        <span class="campo">Pessoas Físicas</span>
        <div id="projetos_pf" class="valor" style="margin-top: 3px;">
            <span class="campo">Cargos</span><br>
            <div id="projetos">
                <table>
                    <tr v-for="pessoa in pessoas_fisicas_cargos_relacionados">
                        <td>
                            <router-link :id="pessoa.pessoa_fisica_id" :to="{ name: 'pf-view', params: { id: pessoa.pessoa_fisica_id }}">
                                {{ pessoa.pessoa_fisica_nome_adotado }}
                            </router-link>
                        </td>
                        <td>{{ pessoa.cargo }}</td>
                        <td>
                            <a @click.prevent="">[X]</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div><br>

        <form @submit.prevent="salvaForm" method="POST">

            <!---->
            <br>
            <br>
            <br>
            <button>Salvar</button>

        </form>

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
                tags: [],
                pessoas_fisicas_cargos_relacionados: [],
                //Campos de inclusão
                tags_atuais: [],
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
                    this.tags = dados.tags;
                    this.pessoas_fisicas_cargos_relacionados = dados.pessoas_fisicas_cargos_relacionados;
                    console.log(this.pessoas_fisicas_cargos_relacionados);
                } );
            },
            salvaForm: function(){
                axios.post('/admin/ajax/pj/save', {
                    pessoa: this.pessoa,
                    tags: this.tags_atuais,
                }).then(res => {
                    this.pessoa = res.data;
                    eventBus.$emit('foiSalvoPj', this.pessoa);
                });
            },

            jQuery: function(){

                //Instancia atual do Vue
                let Vue = this;

                $(document).ready(function(){
                    //Carrega select2 de tags
                    $('#tags_list').select2({
                        placeholder: "Digite as tags",
                        tags: true,
                        multiple: true,
                        tokenSeparators: [","],
                        createTag: function(newTag) {
                            if ($.trim(newTag.term) === '') { return null; }
                            return {
                                id: 'new:' + newTag.term,
                                text: newTag.term + ' (novo)'
                            };
                        }
                    });

                    //Preenche tags selecionadas (timeout 1s)
                    let id_atual = window.location.href.split('/view/')[1];
                    let tags_selecionadas = [];
                    $.get('/admin/ajax/pj/getTagsSelecionadas/' + id_atual).done(function(data) {
                        setTimeout(function(){
                            tags_selecionadas = data;
                            let tags_ids = [];
                            for (let i = 0; i < tags_selecionadas.length; i++) {
                                tags_ids.push(tags_selecionadas[i]['id']);
                            }
                            $('#tags_list').val(tags_ids).trigger('change');
                        }, 0);
                    }).fail(function() {
                        return false;
                    });

                    $('#tags_list').on('change', function(){
                        Vue.tags_atuais = $(this).val();
                    });

                });
            },
        }
    }
</script>