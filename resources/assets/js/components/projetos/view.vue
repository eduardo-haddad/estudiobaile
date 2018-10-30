<template v-if="this.pessoa">

    <div id="container_conteudo" class="formulario">

        <div class="titulo">{{ this.projeto.nome }}</div>

        <!--DADOS GERAIS-->
        <form @submit.prevent="salvaForm" method="POST">

            <span class="campo">Nome</span>
            <div class="valor">
                <input autocomplete="off" type="text"
                       v-model="projeto.nome"
                       name="projeto-nome"
                />
            </div><br>
            <!-- -->
            <span class="campo">Data de início</span>
            <div class="valor">
                <input autocomplete="off" type="date"
                       v-model="projeto.dt_inicio"
                       name="projeto-data-inicio"
                />
            </div><br>
            <!-- -->
            <span class="campo">Data de término</span>
            <div class="valor">
                <input autocomplete="off" type="date"
                       v-model="projeto.dt_fim"
                       name="projeto-data-fim"
                />
            </div><br>

            <!-- Pessoa Física / Chancela -->
            <span class="campo">Pessoas Físicas</span>
            <div id="projetos_pf" class="valor" style="margin-top: 3px;">
                <span class="campo">Participação no(s) projeto(s) Estúdio Baile</span><br>
                <div id="projetos">
                    <table>
                        <tr v-for="pessoa in pessoas_fisicas_chancelas_relacionadas">
                            <td>
                                <router-link :id="pessoa.pessoa_fisica_id" :to="{ name: 'pf-view', params: { id: pessoa.pessoa_fisica_id }}">
                                    {{ pessoa.nome }}
                                </router-link>
                            </td>
                            <td>{{ pessoa.chancela }}</td>
                            <td>
                                <a @click.prevent="removeChancelaPf(pessoa.pessoa_fisica_id, pessoa.chancela_id)">[X]</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div><br>

            <!-- Add novo chancela pessoa física -->
            <a @click="mostraChancelaPfBoxMetodo">[nova chancela pessoa física]</a>
            <div v-if="mostraChancelaPfBox">
                <span class="campo">--- Nova Chancela PF</span><br>
                <span class="campo">Nome</span>
                <select @change="" name="pessoas_fisicas" class="pf_lista">
                    <option disabled selected value> -- Selecione um nome -- </option>
                    <option v-for="pessoa in atributos.pessoas_fisicas" :value="pessoa.id">
                        {{ pessoa.nome_adotado }}
                    </option>
                </select><br>
                <span class="campo">Chancela</span>
                <select @change="" name="chancelas" class="chancelas_pf_lista">
                    <option disabled selected value> -- Selecione uma chancela -- </option>
                    <option v-for="chancela in atributos.chancelas" :value="chancela.id">{{ chancela.valor }}</option>
                </select>
                <a @click.prevent="adicionaChancelaPf">[+]</a>

            </div>

            <button>Salvar</button>

        </form>

    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';

    export default {
        created() {
            this.getProjeto(this.$route.params.id);
            this.jQuery();
        },
        data() {
            return {
                //Models
                projeto: {},
                atributos: [],
                pessoas_fisicas_chancelas_relacionadas: [],
                //Campos de inclusão
                pessoas_fisicas_atuais: [],
                chancelas_pf_atuais: [],
                nova_chancela_pf: {pessoa_fisica: '', chancela: ''},
                //Condicionais
                mostraChancelaPfBox: false,
            }
        },
        watch: {
            '$route' (destino) {
                this.getProjeto(destino.params.id);
                this.jQuery();
            },
            'nova_chancela_pf' (val) {
                console.log(val);
            }
        },
        computed: {

        },
        methods: {
            getProjeto: function(id){
                axios.get('/admin/ajax/projetos/' + id).then(res => {
                    let dados = res.data;
                    this.projeto = dados.projeto;
                    this.atributos = dados.atributos;
                    this.pessoas_fisicas_chancelas_relacionadas = dados.pessoas_fisicas_chancelas_relacionadas;
                    console.log(this.pessoas_fisicas_chancelas_relacionadas);
                } );
            },
            salvaForm: function(){
                axios.post('/admin/ajax/projetos/save', {
                    projeto: this.projeto,
                    pessoas_fisicas: this.pessoas_fisicas_atuais,
                    chancelas_pf: this.chancelas_pf_atuais,
                }).then(res => {
                    this.projeto = res.data;
                    eventBus.$emit('foiSalvo', this.projeto);
                });
            },
            adicionaChancelaPf: function(){
                axios.post('/admin/ajax/projetos/ajaxAddChancelaPf', {
                    projeto_id: this.$route.params.id,
                    nova_chancela: this.nova_chancela_pf
                }).then(res => {
                    if(typeof res.data[0] !== "string") {
                        this.pessoas_fisicas_chancelas_relacionadas = res.data[0];
                        this.atributos.chancelas = res.data[1];
                        this.nova_chancela_pf = {};
                        this.mostraChancelaPfBox = false;
                    }
                });
            },
            removeChancelaPf: function(pessoa_fisica_id, chancela_id){
                axios.post('/admin/ajax/projetos/ajaxRemoveChancelaPf', {
                    pessoa_fisica_id: pessoa_fisica_id,
                    chancela_id: chancela_id,
                    projeto_id: this.$route.params.id,
                }).then(res => {
                    this.pessoas_fisicas_chancelas_relacionadas = res.data;
                });
            },
            mostraChancelaPfBoxMetodo: function(){
                this.mostraChancelaPfBox = true;
                this.jQuery();
            },
            jQuery: function(){

                //Instancia atual do Vue
                let Vue = this;

                $(document).ready(function(){

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
                        Vue.nova_chancela_pf.pessoa_fisica = $(this).val();
                    });


                    //Chancelas

                    //Carrega select2 de chancelas
                    $('.chancelas_pf_lista').select2({
                        placeholder: "Digite uma chancela",
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

                    $('.chancelas_pf_lista').on('change', function(){
                        Vue.nova_chancela_pf.chancela = $(this).val();
                    });

                });
            },
        }
    }
</script>