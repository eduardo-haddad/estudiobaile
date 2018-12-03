<template v-if="this.pessoa">

    <div id="container_conteudo" class="formulario">

        <div class="titulo">
            <div class="imagem_destaque">
                <img :src="imagem_destaque" />
            </div>
            <div class="nome">
                <span>{{ this.pessoa.nome_adotado }}</span>
            </div>
        </div>
        <br>
        <br>
        <br>

        <!-- Tags -->
        <span class="campo" style="float: left;">Tags</span>
        <select @change="tags_atuais = $event.target.value" name="tags" id="tags_list" class="js-example-basic-single">
            <option v-for="tag in tags" :value="tag.id" v-model="tag.id"><a href="#">{{ tag.text }}</a></option>
        </select>
        <br><br>

        <label>Enviar arquivo
            <input type="file" id="arquivo" ref="arquivo" @change="uploadInfo" />
            <input type="text" @input="descricao_arquivo = $event.target.value" name="descricao_arquivo" v-model="descricao_arquivo" placeholder="Descrição"  />
        </label><br>
        <button @click="upload">Submit</button>
        <br><br>
        <div class="valor" style="margin-top: 3px;">
            <span class="campo">Arquivos anexos</span>
            <br>
            <div class="tabela_arquivos">
                <table>
                    <tr>
                        <th class="num_arquivo">#</th>
                        <th class="nome_arquivo">Nome</th>
                        <th class="descricao_arquivo">Descrição</th>
                        <th class="destaque_arquivo">Destaque</th>
                        <th class="tipo_arquivo">Tipo</th>
                        <th class="data_arquivo">Data</th>
                        <th class="remove_arquivo">Remover</th>
                    </tr>
                    <tr v-for="(arquivo, index) in arquivos">
                        <td class="num_arquivo">{{ index+1 }}</td>
                        <td class="nome_arquivo"><a :href="'/admin/download/pf/' + arquivo.id" download>{{ arquivo.nome.substr(15).trunc(30)  }}</a></td>
                        <td class="descricao_arquivo">
                            <input autocomplete="off" type="text" name="arquivo_descricao" v-model="arquivo.descricao" />
                        </td>
                        <td class="destaque_arquivo"><a @click.prevent="setImagemDestaque(arquivo.id)"><img v-if="arquivo.tipo === 'imagem'" class="btn_destaque" :src="id_destaque === arquivo.id ? root + '/img/btn_destaque_ativo.png' : root + '/img/btn_destaque.png'" /></a></td>
                        <td class="tipo_arquivo">{{ arquivo.tipo }}</td>
                        <td class="data_arquivo">{{ arquivo.data }}</td>
                        <td class="remove_arquivo"><a @click="removeArquivo(arquivo.id)">X</a></td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <br>
        <br>

        <!-- Pessoa Física / Chancela -->
        <div id="projetos_pf" class="valor" style="margin-top: 3px;">
            <span class="campo">Pessoas Jurídicas</span>
            <br>
            <div id="chancelas" class="cargos">
                <table>
                    <tr v-for="pessoa in pessoas_juridicas_relacionadas">
                        <td>
                            <router-link :id="pessoa.id" :to="{ name: 'pj-view',
                            params: { id: pessoa.id }}">{{ pessoa.nome_fantasia }}</router-link>&nbsp;/&nbsp;{{ pessoa.cargo }}</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <br>

        <hr style="clear:both">
        <span class="campo">Participação no(s) projeto(s) Estúdio Baile</span><br>
        <div id="projetos">
            <table>
                <tr v-for="projeto in projetos" v-model="projetos">
                    <td>
                        <router-link :id="projeto.id" :to="{ name: 'projetos-view', params: { id: projeto.id }}">{{ projeto['projeto'] }}</router-link>&nbsp;/&nbsp;{{ projeto['chancela'] }}</td>
                </tr>
            </table>
        </div>
        <hr>
        <!-- Emails -->
        <div>
            <div v-for="(email, index) in emails" class="valor" :key="email.id">
                <span class="campo">E-mail {{ index+1 }}</span>
                <input autocomplete="off" type="text" :id="email.id" v-model="email.valor" name="email" />
                <a @click.prevent="removeContato(email.id)">X</a>
            </div>
            <br>
            <a @click.prevent="adicionaEmail = true">[adicionar email]</a>
            <div v-if="adicionaEmail" class="adiciona_contato">
                <input @input="novo_email = $event.target.value" type="text" class="adiciona_contato" v-model="novo_email" name="novo_email" placeholder="adicionar email" />
                <a @click.prevent="adicionaContato()">+</a>
            </div>
        </div>
        <hr>

        <!-- Telefones -->
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
        <hr>
        <!-- Endereços -->
        <div v-for="(endereco, index) in enderecos" :key="endereco.id" class="form_endereco">

            <span class="campo">Endereço {{index+1}}:</span> <a @click="removeEndereco(endereco.id)">X</a> <br>
            <div class="valor">
                <span class="campo">Logradouro</span>
                <input autocomplete="off" type="text" name="endereco.rua" v-model="endereco.rua" />
            </div><br>
            <div class="valor">
                <span class="campo">Número</span>
                <input autocomplete="off" type="text" name="endereco.numero" v-model="endereco.numero" />
            </div><br>
            <div class="valor">
                <span class="campo">Complemento</span>
                <input autocomplete="off" type="text" name="endereco.complemento" v-model="endereco.complemento" />
            </div><br>
            <div class="valor">
                <span class="campo">Bairro</span>
                <input autocomplete="off" type="text" name="endereco.bairro" v-model="endereco.bairro" />
            </div><br>
            <div class="valor">
                <span class="campo">cep</span>
                <input autocomplete="off" type="text" name="endereco.cep" v-model="endereco.cep" />
            </div><br>
            <div class="valor">
                <span class="campo">cidade</span>
                <input autocomplete="off" type="text" name="endereco.cidade" v-model="endereco.cidade" />
            </div><br>
            <div class="valor">
                <span class="campo">uf</span>
                <input autocomplete="off" type="text" name="endereco.estado" v-model="endereco.estado" />
            </div><br>
            <div class="valor">
                <span class="campo">País</span>
                <input autocomplete="off" type="text" name="endereco.pais" v-model="endereco.pais" />
            </div><br>
        </div>

        <!--Add novo endereço-->
        <a @click="mostraEnderecoBox = true">[novo endereço]</a>
        <div v-if="mostraEnderecoBox">
            <span class="campo">--- Novo Endereço</span><br>
            <div class="valor">
                <span class="campo">Logradouro</span>
                <input @input="novo_endereco.rua = $event.target.value" autocomplete="off" type="text" name="novo_endereco.rua" v-model="novo_endereco.rua" />
            </div><br>
            <div class="valor">
                <span class="campo">Número</span>
                <input @input="novo_endereco.numero = $event.target.value" autocomplete="off" type="text" name="novo_endereco.numero" v-model="novo_endereco.numero" />
            </div><br>
            <div class="valor">
                <span class="campo">Complemento</span>
                <input @input="novo_endereco.complemento = $event.target.value" autocomplete="off" type="text" name="novo_endereco.complemento" v-model="novo_endereco.complemento" />
            </div><br>
            <div class="valor">
                <span class="campo">Bairro</span>
                <input @input="novo_endereco.bairro = $event.target.value" autocomplete="off" type="text" name="novo_endereco.bairro" v-model="novo_endereco.bairro" />
            </div><br>
            <div class="valor">
                <span class="campo">cep</span>
                <input @input="novo_endereco.cep = $event.target.value" autocomplete="off" type="text" name="novo_endereco.cep" v-model="novo_endereco.cep" />
            </div><br>
            <div class="valor">
                <span class="campo">cidade</span>
                <input @input="novo_endereco.cidade = $event.target.value" autocomplete="off" type="text" name="novo_endereco.cidade" v-model="novo_endereco.cidade" />
            </div><br>
            <div class="valor">
                <span class="campo">uf</span>
                <input @input="novo_endereco.estado = $event.target.value" autocomplete="off" type="text" name="novo_endereco.estado" v-model="novo_endereco.estado" />
            </div><br>
            <div class="valor">
                <span class="campo">País</span>
                <input @input="novo_endereco.pais = $event.target.value" autocomplete="off" type="text" name="novo_endereco.pais" v-model="novo_endereco.pais" />
            </div><br>
            <a @click.prevent="adicionaEndereco">[+]</a>

        </div>

        <hr>

        <!--DADOS GERAIS-->

        <div class="valor">
            <span class="campo">Nome</span>
            <input autocomplete="off" type="text"
                   v-model="pessoa.nome"
                   name="nome"
            />
        </div><br>

        <div class="valor">
            <span class="campo">Nome adotado</span>
            <input autocomplete="off" type="text"
                   v-model="pessoa.nome_adotado"
                   name="nome_adotado"
            />
        </div><br>

        <div class="valor">
            <span class="campo">Gênero</span>
            <select name="genero" v-model="pessoa.genero_id">
                <option v-for="genero in atributos.generos" :value="genero.id" :key="genero.id">
                    {{ genero.valor == 'F' ? 'Feminino' : 'Masculino' }}
                </option>
            </select>
        </div><br>

        <div class="valor">
            <span class="campo">Estado civil</span>
            <select name="estado_civil" v-model="pessoa.estado_civil_id">
                <option v-for="estado_civil in atributos.estados_civis" :value="estado_civil.id" :key="estado_civil.id">
                    {{ estado_civil.valor }}
                </option>
            </select>
        </div><br>

        <div class="valor">
            <span class="campo">Data de nascimento</span>
            <input autocomplete="off" type="text"
                   v-model="pessoa.dt_nascimento"
                   name="dt_nascimento"
            />
        </div><br>

        <div class="valor">
            <span class="campo">Nacionalidade</span>
            <input autocomplete="off" type="text"
                   v-model="pessoa.nacionalidade"
                   name="nacionalidade"
            />
        </div><br>

        <div class="valor">
            <span class="campo">Naturalidade</span>
            <input autocomplete="off" type="text"
                   v-model="pessoa.naturalidade"
                   name="naturalidade"
            />
        </div><br>

        <div class="valor">
            <span class="campo">Website</span>
            <input autocomplete="off" type="text"
                   v-model="pessoa.website"
                   name="website"
            />
        </div><br>

        <!-- DOCUMENTOS -->
        <div class="valor">
            <span class="campo">RG</span>
            <input autocomplete="off" type="text"
                   v-model="pessoa.rg"
                   name="rg"
            />
        </div><br>

        <div class="valor">
            <span class="campo">CPF</span>
            <input autocomplete="off" type="text"
                   v-model="pessoa.cpf"
                   name="cpf"
            />
        </div><br>

        <div class="valor">
            <span class="campo">Passaporte</span>
            <input autocomplete="off" type="text"
                   v-model="pessoa.passaporte"
                   name="passaporte"
            />
        </div><br>

        <br>
        <label><input type="checkbox" @click="mostraMei = !mostraMei" :checked="mostraMei" style="margin-right: 10px" />Possui MEI</label>
        <div v-if="mostraMei" style="margin-top: 15px">
            <div class="valor">
                <span class="campo">CNPJ</span>
                <input autocomplete="off" type="text"
                       v-model="pessoa.cnpj"
                       name="cnpj"
                />
            </div><br>

            <div class="valor">
                <span class="campo">Razão Social</span>
                <input autocomplete="off" type="text"
                       v-model="pessoa.razao_social"
                       name="razao_social"
                />
            </div>
        </div>


        <hr>

        <!-- Dados Bancários -->

        <div v-for="(dado_bancario, index) in dados_bancarios">
            <span class="campo">Dados Bancários {{index+1}}</span> <a @click="removeDadosBancarios(dado_bancario.id)">X</a> <br>
            <div class="valor">
                <span class="campo">Banco</span>
                <input autocomplete="off" type="text" name="dado_bancario.nome_banco" v-model="dado_bancario.nome_banco" />
            </div><br>
            <div class="valor">
                <span class="campo">Agência</span>
                <input autocomplete="off" type="text" name="dado_bancario.agencia" v-model="dado_bancario.agencia" />
            </div><br>
            <div class="valor">
                <span class="campo">Conta</span>
                <input autocomplete="off" type="text" name="dado_bancario.conta" v-model="dado_bancario.conta" />
            </div><br>
            <div class="valor">
                <span class="campo">Tipo</span>
                <select name="dado_bancario.tipo_conta_id" v-model="dado_bancario.tipo_conta_id">
                    <option v-for="tipo_conta in atributos.tipos_conta_bancaria" :value="tipo_conta.id">
                        {{ tipo_conta.valor }}
                    </option>
                </select>
            </div><br><br>

        </div>
        <!-- Add novos dados bancários -->
        <a @click="mostraDadosBancariosBox = true">[adicionar dados bancários]</a>
        <div v-if="mostraDadosBancariosBox">
            <span class="campo">--- Novos Dados Bancários</span><br>
            <div class="valor">
                <span class="campo">Banco</span>
                <input @input="novos_dados_bancarios.nome_banco = $event.target.value" autocomplete="off" type="text" name="novos_dados_bancarios.nome_banco" v-model="novos_dados_bancarios.nome_banco" />
            </div><br>
            <div class="valor">
                <span class="campo">Agência</span>
                <input @input="novos_dados_bancarios.agencia = $event.target.value" autocomplete="off" type="text" name="novos_dados_bancarios.agencia" v-model="novos_dados_bancarios.agencia" />
            </div><br>
            <div class="valor">
                <span class="campo">Conta</span>
                <input @input="novos_dados_bancarios.conta = $event.target.value" autocomplete="off" type="text" name="novos_dados_bancarios.conta" v-model="novos_dados_bancarios.conta" />
            </div><br>
            <div class="valor">
                <span class="campo">Tipo</span>
                <select @change="novos_dados_bancarios.tipo_conta_id = $event.target.value" name="dado_bancario.tipo_conta_id" v-model="novos_dados_bancarios.tipo_conta_id">
                    <option v-for="tipo_conta in atributos.tipos_conta_bancaria" :value="tipo_conta.id">
                        {{ tipo_conta.valor }}
                    </option>
                </select>
            </div><br>

            <a @click.prevent="adicionaDadosBancarios">[+]</a>

        </div>
        <br>
        <br>
        <button @click.prevent="salvaForm">Salvar</button>

    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';

    export default {
        created() {
            this.getPessoa(this.$route.params.id);
            this.jQuery();
            //reticências em strings maiores que "n"
            String.prototype.trunc = function(n){
                return this.substr(0, n-1) + (this.length > n ? '...' : '');
            };
            //basepath
            this.root = ROOT;
        },
        data() {
            return {
                //Models
                pessoa: {},
                contatos: [],
                enderecos: [],
                arquivos: [],
                dados_bancarios: [],
                tags: [],
                atributos: [],
                estados_civis: {},
                generos: {},
                projetos: [],
                pessoas_juridicas_relacionadas: [],
                //Campos de inclusão
                root: '',
                novo_email: '',
                novo_telefone: '',
                novo_endereco: {rua:'',numero:'',complemento:'',bairro:'',cep:'',cidade:'',estado:'',pais:''},
                novos_dados_bancarios: {nome_banco:'',agencia:'',conta:'',tipo_conta_id:''},
                tags_atuais: [],
                arquivo_atual: '',
                descricao_arquivo: '',
                mensagem_upload: '',
                id_destaque: '',
                imagem_destaque: '',
                //Condicionais
                adicionaEmail: false,
                adicionaTel: false,
                mostraEnderecoBox: false,
                mostraDadosBancariosBox: false,
                mostraMei: false,
            }
        },
        watch: {
            '$route' (destino) {
                this.getPessoa(destino.params.id);
                eventBus.$emit('changePessoaFisica');
                this.jQuery();
            },
            'mostraMei' (check) {
                if(!check) {
                    this.pessoa.cnpj = null;
                    this.pessoa.razao_social = null
                }
            }
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
                axios.get('/admin/ajax/pf/' + id).then(res => {
                    eventBus.$emit('getPessoaFisica');
                    let dados = res.data;
                    this.pessoa = dados.pessoa_fisica;
                    this.pessoa.genero = dados.genero;
                    this.pessoa.estado_civil = dados.estado_civil;
                    this.contatos = dados.contatos;
                    this.enderecos = dados.enderecos;
                    this.arquivos = dados.arquivos;
                    this.dados_bancarios = dados.dados_bancarios;
                    this.tags = dados.tags;
                    this.projetos = dados.projetos;
                    this.pessoas_juridicas_relacionadas = dados.pessoas_juridicas;
                    this.atributos = dados.atributos;

                    //campo MEI
                    if(this.pessoa.cnpj !== null || this.pessoa.razao_social !== null) {
                        this.mostraMei = true;
                    }

                    //imagem de destaque
                    this.imagem_destaque = this.root + '/img/perfil_vazio.png';
                    this.getImagemDestaque();
                });
            },
            salvaForm: function(){
                axios.post('/admin/ajax/pf/save', {
                    pessoa: this.pessoa,
                    contatos: this.contatos,
                    enderecos: this.enderecos,
                    arquivos: this.arquivos,
                    dados_bancarios: this.dados_bancarios,
                    tags: this.tags_atuais,
                }).then(res => {
                    this.pessoa = res.data;
                    eventBus.$emit('foiSalvoPessoaFisica', this.pessoa);
                });
            },
            adicionaContato: function(){
                axios.post('/admin/ajax/pf/addContato', {
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
                axios.post('/admin/ajax/pf/removeContato', {
                    contato_id: id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.contatos = res.data;
                    }
                });
            },
            adicionaEndereco: function(){
                axios.post('/admin/ajax/pf/addEndereco', {
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
                axios.post('/admin/ajax/pf/removeEndereco', {
                    endereco_id: id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    console.log(res.data);
                    this.enderecos = res.data;
                });
            },
            adicionaDadosBancarios: function(){
                axios.post('/admin/ajax/pf/addDadosBancarios', {
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
                axios.post('/admin/ajax/pf/removeDadosBancarios', {
                    dados_bancarios_id: id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    this.dados_bancarios = res.data;
                });
            },
            selecionaTags: function(data){
                //console.log(data);
            },
            upload: function() {
                let formData = new FormData();
                formData.append('arquivo', this.arquivo_atual);
                formData.append('pessoa_id', this.$route.params.id);
                formData.append('descricao_arquivo', this.descricao_arquivo);

                axios.post('/admin/ajax/pf/upload',
                    formData, {
                        headers: { 'Content-Type': 'multipart/form-data' },
                    }
                ).then(res => {
                    this.mensagem_upload = res.data['mensagem_upload'];
                    this.arquivos = res.data['arquivos'];
                    this.arquivo_atual = '';
                    this.descricao_arquivo = '';
                    this.$refs.arquivo.value = '';
                }).catch(res => {
                    console.log(res.data);
                });
            },
            removeArquivo: function(id) {
                axios.post('/admin/ajax/pf/removeArquivo', {
                    arquivo_id: id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    this.arquivos = res.data['arquivos'];
                    if(res.data['remove_destaque'] === true)
                        this.imagem_destaque = this.root + '/img/perfil_vazio.png';
                });
            },
            uploadInfo() {
                this.arquivo_atual = this.$refs.arquivo.files[0];
            },
            setImagemDestaque: function(arquivo_id) {
                axios.post('/admin/ajax/pf/setImagemDestaque', {
                    arquivo_id: arquivo_id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    this.id_destaque = res.data['imagem_destaque']['id'];
                    this.arquivos = res.data['arquivos'];
                    if(this.id_destaque === 0)
                        this.imagem_destaque = this.root + '/img/perfil_vazio.png';
                    else
                        this.imagem_destaque = this.root + '/thumbs/pessoas_fisicas/' + this.$route.params.id + '/' + res.data['imagem_destaque']['nome'];
                });
            },
            getImagemDestaque: function() {
                axios.post('/admin/ajax/pf/getImagemDestaque', {
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.id_destaque = res.data.id;
                        this.imagem_destaque = this.root + '/thumbs/pessoas_fisicas/' + this.$route.params.id + '/' + res.data.nome;
                    }
                    else
                        this.imagem_destaque = this.root + '/img/perfil_vazio.png';
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
                    $.get('/admin/ajax/pf/getTagsSelecionadas/' + id_atual).done(function(data) {
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

                    // $('#tags_list').on("select2:selecting", function(e) {
                    //
                    // });

                });
            },
        }
    }
</script>