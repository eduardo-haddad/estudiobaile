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
            <div>
                <table>
                    <tr v-for="pessoa in pessoas_fisicas_cargos_relacionados">
                        <td>
                            <router-link :id="pessoa.pessoa_fisica_id" :to="{ name: 'pf-view',
                            params: { id: pessoa.pessoa_fisica_id }}">{{ pessoa.pessoa_fisica_nome_adotado }}</router-link>&nbsp;/&nbsp;{{ pessoa.cargo }}
                        </td>
                        <td>
                            <a @click.prevent="removeCargoPf(pessoa.pessoa_fisica_id, pessoa.cargo_id)">[X]</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div><br>

        <!-- Add novo chancela pessoa física -->
        <a @click="mostraCargoPfBoxMetodo" style="margin-bottom: 7px; display:block">[adicionar pessoa física]</a>
        <div v-if="mostraCargoPfBox">
            <!--pessoa_fisica_id-->
            <!--novo_cargo-->
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

        <br>

        <span class="campo">Participação no(s) projeto(s) Estúdio Baile</span><br>
        <div>
            <table>
                <tr v-for="projeto in projetos" v-model="projetos">
                    <td>
                        <router-link
                                :id="projeto.id"
                                :to="{ name: 'projetos-view',
                                    params: { id: projeto.id }}">{{ projeto['projeto'] }}</router-link>&nbsp;/&nbsp;{{ projeto['chancela'] }}</td>
                </tr>
            </table>
        </div>
        <br>
        <br>

        <div class="resumo">

            <!-- Emails -->
            <div>
                <div v-for="email in emails" class="valor" :key="email.id">
                    <span class="campo">E-mail</span>
                    <input type="text" :id="email.id" v-model="email.valor" name="email" />
                    <a @click.prevent="removeContato(email.id)">X</a>
                </div>
                <br>
                <a @click.prevent="adicionaEmail = true">[adicionar email]</a>
                <div v-if="adicionaEmail" class="adiciona_contato">
                    <input @input="novo_email = $event.target.value" type="text" class="adiciona_contato" v-model="novo_email" name="novo_email" placeholder="adicionar email" />
                    <a @click.prevent="adicionaContato()">+</a>
                </div>
            </div>

            <!-- Telefones -->
            <br>
            <br>
            <div>
                <div v-for="telefone in telefones" class="valor" :key="telefone.id">
                    <span class="campo">Telefone</span>
                    <input type="text" :id="telefone.id" v-model="telefone.valor" name="telefone" />
                    <a @click.prevent="removeContato(telefone.id)">X</a>
                </div>

                <a @click.prevent="adicionaTel = true">[adicionar telefone]</a>
                <div v-if="adicionaTel" class="adiciona_contato">
                    <input @input="novo_telefone = $event.target.value" type="text" class="adiciona_contato" v-model="novo_telefone" name="novo_telefone" placeholder="adicionar telefone" />
                    <a @click.prevent="adicionaContato()">+</a>
                </div>

            </div>

            <br>
            <br>
            <br>
            <br>

            <!-- Endereços -->
            <div v-for="(endereco, index) in enderecos" :key="endereco.id">
                <span class="campo">--- Endereço {{index+1}}</span> <a @click="removeEndereco(endereco.id)">[x]</a> <br>
                <span class="campo">Logradouro</span>
                <div class="valor">
                    <input autocomplete="off" type="text" name="endereco.rua" v-model="endereco.rua" />
                </div><br>
                <span class="campo">Número</span>
                <div class="valor">
                    <input autocomplete="off" type="text" name="endereco.numero" v-model="endereco.numero" />
                </div><br>
                <span class="campo">Complemento</span>
                <div class="valor">
                    <input autocomplete="off" type="text" name="endereco.complemento" v-model="endereco.complemento" />
                </div><br>
                <span class="campo">Bairro</span>
                <div class="valor">
                    <input autocomplete="off" type="text" name="endereco.bairro" v-model="endereco.bairro" />
                </div><br>
                <span class="campo">cep</span>
                <div class="valor">
                    <input autocomplete="off" type="text" name="endereco.cep" v-model="endereco.cep" />
                </div><br>
                <span class="campo">cidade</span>
                <div class="valor">
                    <input autocomplete="off" type="text" name="endereco.cidade" v-model="endereco.cidade" />
                </div><br>
                <span class="campo">uf</span>
                <div class="valor">
                    <input autocomplete="off" type="text" name="endereco.estado" v-model="endereco.estado" />
                </div><br>
                <span class="campo">País</span>
                <div class="valor">
                    <input autocomplete="off" type="text" name="endereco.pais" v-model="endereco.pais" />
                </div><br>
            </div>
            <!--Add novo endereço-->
            <a @click="mostraEnderecoBox = true">[novo endereço]</a>
            <div v-if="mostraEnderecoBox">
                <span class="campo">Logradouro</span>
                <div class="valor">
                    <input @input="novo_endereco.rua = $event.target.value" autocomplete="off" type="text" name="novo_endereco.rua" v-model="novo_endereco.rua" />
                </div><br>
                <span class="campo">Número</span>
                <div class="valor">
                    <input @input="novo_endereco.numero = $event.target.value" autocomplete="off" type="text" name="novo_endereco.numero" v-model="novo_endereco.numero" />
                </div><br>
                <span class="campo">Complemento</span>
                <div class="valor">
                    <input @input="novo_endereco.complemento = $event.target.value" autocomplete="off" type="text" name="novo_endereco.complemento" v-model="novo_endereco.complemento" />
                </div><br>
                <span class="campo">Bairro</span>
                <div class="valor">
                    <input @input="novo_endereco.bairro = $event.target.value" autocomplete="off" type="text" name="novo_endereco.bairro" v-model="novo_endereco.bairro" />
                </div><br>
                <span class="campo">cep</span>
                <div class="valor">
                    <input @input="novo_endereco.cep = $event.target.value" autocomplete="off" type="text" name="novo_endereco.cep" v-model="novo_endereco.cep" />
                </div><br>
                <span class="campo">cidade</span>
                <div class="valor">
                    <input @input="novo_endereco.cidade = $event.target.value" autocomplete="off" type="text" name="novo_endereco.cidade" v-model="novo_endereco.cidade" />
                </div><br>
                <span class="campo">uf</span>
                <div class="valor">
                    <input @input="novo_endereco.estado = $event.target.value" autocomplete="off" type="text" name="novo_endereco.estado" v-model="novo_endereco.estado" />
                </div><br>
                <span class="campo">País</span>
                <div class="valor">
                    <input @input="novo_endereco.pais = $event.target.value" autocomplete="off" type="text" name="novo_endereco.pais" v-model="novo_endereco.pais" />
                </div><br>
                <a @click.prevent="adicionaEndereco">[+]</a>

            </div>



            <form @submit.prevent="salvaForm" method="POST">

                <!---->
                <br>
                <br>
                <br>
                <button>Salvar</button>

            </form>

        </div>

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
                contatos: [],
                enderecos: [],
                pessoas_fisicas_cargos_relacionados: [],
                projetos: [],
                //Campos de inclusão
                tags_atuais: [],
                pessoa_fisica_id: '',
                novo_cargo: '',
                novo_email: '',
                novo_telefone: '',
                novo_endereco: {rua:'',numero:'',complemento:'',bairro:'',cep:'',cidade:'',estado:'',pais:''},
                novos_dados_bancarios: {nome_banco:'',agencia:'',conta:'',tipo_conta_id:''},
                //Condicionais
                mostraCargoPfBox: false,
                adicionaEmail: false,
                adicionaTel: false,
                mostraEnderecoBox: false,
                mostraDadosBancariosBox: false,
            }
        },
        watch: {
            '$route' (destino) {
                this.getPessoa(destino.params.id);
                eventBus.$emit('changePessoaJuridica');
                this.jQuery();
            },
        },
        computed: {
            emails: function() {
                return this.contatos.filter(x => x.tipo_contato_id == 1);
            },
            telefones: function() {
                return this.contatos.filter(x => x.tipo_contato_id == 2);
            }
        },
        methods: {
            getPessoa: function(id){
                axios.get('/admin/ajax/pj/' + id).then(res => {
                    eventBus.$emit('getPessoaJuridica');
                    let dados = res.data;
                    this.pessoa = dados.pessoa_juridica;
                    this.tags = dados.tags;
                    this.contatos = dados.contatos;
                    this.enderecos = dados.enderecos;
                    this.projetos = dados.projetos;
                    this.atributos = dados.atributos;
                    this.pessoas_fisicas_cargos_relacionados = dados.pessoas_fisicas_cargos_relacionados;
                } );
            },
            salvaForm: function(){
                axios.post('/admin/ajax/pj/save', {
                    pessoa: this.pessoa,
                    tags: this.tags_atuais,
                }).then(res => {
                    this.pessoa = res.data;
                    eventBus.$emit('foiSalvoPessoaJuridica', this.pessoa);
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
            adicionaContato: function(){
                axios.post('/admin/ajax/pj/addContato', {
                    pessoa_id: this.$route.params.id,
                    email: this.novo_email,
                    telefone: this.novo_telefone
                }).then(res => {
                    console.log(res.data);
                    if(typeof res.data !== "string") {
                        this.contatos = res.data;
                    }
                    this.novo_email = '';
                    this.novo_telefone = '';
                    this.adicionaEmail = false;
                    this.adicionaTel = false;
                });
            },
            removeContato: function(id){
                axios.post('/admin/ajax/pj/removeContato', {
                    contato_id: id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.contatos = res.data;
                    }
                });
            },
            adicionaEndereco: function(){
                axios.post('/admin/ajax/pj/addEndereco', {
                    pessoa_id: this.$route.params.id,
                    endereco: this.novo_endereco
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.enderecos = res.data;
                        this.novo_endereco = {};
                        this.mostraEnderecoBox = false;
                    }
                });
            },
            removeEndereco: function(id){
                axios.post('/admin/ajax/pj/removeEndereco', {
                    endereco_id: id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    console.log(res.data);
                    this.enderecos = res.data;
                });
            },
            adicionaDadosBancarios: function(){
                axios.post('/admin/ajax/pj/addDadosBancarios', {
                    pessoa_id: this.$route.params.id,
                    dados_bancarios: this.novos_dados_bancarios
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.dados_bancarios = res.data;
                        this.novos_dados_bancarios = {};
                        this.mostraDadosBancariosBox = false;
                    }
                });
            },
            removeDadosBancarios: function(id){
                axios.post('/admin/ajax/pj/removeDadosBancarios', {
                    dados_bancarios_id: id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    this.dados_bancarios = res.data;
                });
            },
            jQuery: function(){
                //Instancia atual do Vue
                let Vue = this;

                $(document).ready(function(){
                    //Carrega select2 de tags
                    $('#tags_list').val('').select2({
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
                    }).on('change', function(){
                        Vue.tags_atuais = $(this).val();
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
                        }, 1000);
                    }).fail(function() {
                        return false;
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
                    }).on('change', function(){
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
                    }).on('change', function(){
                        Vue.novo_cargo = $(this).val();
                    });

                });
            },
        }
    }
</script>