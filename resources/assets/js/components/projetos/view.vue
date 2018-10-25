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

            <!-- Pessoa Física / Cargo -->
            <span class="campo">Pessoas Físicas</span>
            <div id="projetos_pf" class="valor" style="margin-top: 3px;">
                <span class="campo">Participação no(s) projeto(s) Estúdio Baile</span><br>
                <div id="projetos">
                    <table>
                        <tr v-for="pessoa in pessoas_fisicas_cargos_relacionados">
                            <td>
                                <router-link :id="pessoa.pessoa_fisica_id" :to="{ name: 'pf-view', params: { id: pessoa.pessoa_fisica_id }}">
                                    {{ pessoa.nome }}
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

            <!-- Add novo cargo pessoa física -->
            <a @click="mostraCargoPfBoxMetodo">[novo cargo pessoa física]</a>
            <div v-if="mostraCargoPfBox">
                <span class="campo">--- Novo Cargo PF</span><br>
                <span class="campo">Nome</span>
                <select @change="" name="pessoas_fisicas" class="pf_lista">
                    <option disabled selected value> -- Selecione um nome -- </option>
                    <option v-for="pessoa in atributos.pessoas_fisicas" :value="pessoa.id">
                        {{ pessoa.nome_adotado }}
                    </option>
                </select><br>
                <span class="campo">Cargo</span>
                <select @change="" name="cargos" class="cargos_pf_lista">
                    <option disabled selected value> -- Selecione um cargo -- </option>
                    <option v-for="cargo in atributos.cargos" :value="cargo.id">{{ cargo.valor }}</option>
                </select>
                <a @click.prevent="adicionaCargoPf">[+]</a>

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
                pessoas_fisicas_cargos_relacionados: [],
                //Campos de inclusão
                pessoas_fisicas_atuais: [],
                cargos_pf_atuais: [],
                novo_cargo_pf: {pessoa_fisica: '', cargo: ''},
                //Condicionais
                mostraCargoPfBox: false,
            }
        },
        watch: {
            '$route' (destino) {
                this.getProjeto(destino.params.id);
                this.jQuery();
            },
            'novo_cargo_pf' (val) {
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
                    this.pessoas_fisicas_cargos_relacionados = dados.pessoas_fisicas_cargos_relacionados;
                    console.log(this.pessoas_fisicas_cargos_relacionados);
                } );
            },
            salvaForm: function(){
                axios.post('/admin/ajax/projetos/save', {
                    projeto: this.projeto,
                    pessoas_fisicas: this.pessoas_fisicas_atuais,
                    cargos_pf: this.cargos_pf_atuais,
                }).then(res => {
                    this.projeto = res.data;
                    eventBus.$emit('foiSalvo', this.projeto);
                });
            },
            adicionaCargoPf: function(){
                axios.post('/admin/ajax/projetos/ajaxAddCargoPf', {
                    projeto_id: this.$route.params.id,
                    novo_cargo: this.novo_cargo_pf
                }).then(res => {
                    if(typeof res.data[0] !== "string") {
                        this.pessoas_fisicas_cargos_relacionados = res.data[0];
                        this.atributos.cargos = res.data[1];
                        this.novo_cargo_pf = {};
                        this.mostraCargoPfBox = false;
                    }
                });
            },
            removeCargoPf: function(pessoa_fisica_id, cargo_id){
                axios.post('/admin/ajax/projetos/ajaxRemoveCargoPf', {
                    pessoa_fisica_id: pessoa_fisica_id,
                    cargo_id: cargo_id,
                    projeto_id: this.$route.params.id,
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
                        Vue.novo_cargo_pf.pessoa_fisica = $(this).val();
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
                        Vue.novo_cargo_pf.cargo = $(this).val();
                    });

                });
            },
        }
    }
</script>