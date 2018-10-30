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

        <br><br>
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
                            <a @click.prevent="removeCargoPf(pessoa.pessoa_fisica_id, pessoa.cargo_id)">[X]</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div><br>

        <!-- Add novo chancela pessoa física -->
        <a @click="mostraCargoPfBoxMetodo">[nova chancela pessoa física]</a>
        <div v-if="mostraCargoPfBox">
            <!--pessoa_fisica_id-->
            <!--novo_cargo-->
            <span class="campo">--- Nova Chancela PF</span><br>
            <span class="campo">Nome</span>
            <select @change="" name="pessoas_fisicas" class="pf_lista">
                <option disabled selected value> -- Selecione um nome -- </option>
                <option v-for="pessoa in atributos.pessoas_fisicas" :value="pessoa.id">
                    {{ pessoa.nome_adotado }}
                </option>
            </select><br>
            <span class="campo">Chancela</span>
            <select @change="" name="chancelas" class="cargos_pf_lista">
                <option disabled selected value> -- Selecione uma chancela -- </option>
                <option v-for="cargo in atributos.cargos_pf" :value="cargo.id">{{ cargo.valor }}</option>
            </select>
            <a @click.prevent="adicionaCargoPf">[+]</a>

        </div>

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
                pessoa_fisica_id: '',
                novo_cargo: '',
                //Condicionais
                mostraCargoPfBox: false
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
                    this.atributos = dados.atributos;
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
            adicionaCargoPf: function(){
                axios.post('/admin/ajax/pj/ajaxAddCargoPf', {
                    pessoa_juridica_id: this.$route.params.id,
                    pessoa_fisica_id: this.pessoa_fisica_id,
                    novo_cargo: this.novo_cargo,

                }).then(res => {
                    if(typeof res.data[0] !== "string") {
                        this.pessoas_fisicas_cargos_relacionados = res.data[0];
                        this.atributos.cargos = res.data[1];
                        this.pessoa_fisica_id = '';
                        this.novo_cargo = '';
                        this.mostraCargoPfBox = false;
                    }
                });
            },
            removeCargoPf: function(pessoa_fisica_id, cargo_id){
                axios.post('/admin/ajax/pj/ajaxRemoveCargoPf', {
                    cargo: cargo_id,
                    pessoa_fisica_id: pessoa_fisica_id,
                    pessoa_juridica_id: this.$route.params.id,
                }).then(res => {
                    this.pessoas_fisicas_cargos_relacionados = res.data;
                });
            },
            mostraCargoPfBoxMetodo: function(){
                this.mostraCargoPfBox = true;
                this.jQuery();
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

                    //Carrega select2 de pessoas físicas
                    $('.pf_lista').select2({
                        placeholder: "Digite um nome",
                        tags: false,
                        multiple: false,
                        tokenSeparators: [","],
                        dropdownAutoWidth : true,
                        //dropdownCssClass : 'select2-dropdown-custom',
                        //minimumInputLength: 1,
                        createTag: function(newTag) {
                            if ($.trim(newTag.term) === '') { return null; }
                            return {
                                id: 'new:' + newTag.term,
                                text: newTag.term + ' (novo)'
                            };
                        },
                    });

                    $('.pf_lista').on('change', function(){
                        Vue.pessoa_fisica_id = $(this).val();
                    });

                    //Cargos

                    //Carrega select2 de cargos
                    $('.cargos_pf_lista').select2({
                        placeholder: "Digite um cargo",
                        tags: true,
                        multiple: false,
                        tokenSeparators: [","],
                        createTag: function(newTag) {
                            if ($.trim(newTag.term) === '') { return null; }
                            return {
                                id: 'new:' + newTag.term,
                                text: newTag.term + ' (novo)'
                            };
                        }
                    });

                    $('.cargos_pf_lista').on('change', function(){
                        Vue.novo_cargo = $(this).val();
                    });

                });
            },
        }
    }
</script>