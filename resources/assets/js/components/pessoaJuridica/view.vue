<template v-if="this.pessoa">

    <div id="container_conteudo" class="formulario">

        <div class="titulo">
            <div class="imagem_destaque">
                <img :src="imagem_destaque" />
            </div>
            <div class="nome">
                <span>
                    <input autocomplete="off" type="text"
                             v-model="pessoa.nome_fantasia"
                             name="nome_adotado" style="border:none" />
                </span>
            </div>
        </div>

        <br>
        <!-- Tags -->
        <span class="campo">Tags</span>
        <select @change="tags_atuais = $event.target.value" name="tags" id="tags_list" class="js-example-basic-single">
            <option v-for="tag in tags" :value="tag.id" v-model="tag.id">{{ tag.text }}</option>
        </select>
        <br><br>

        <!-- Arquivos -->
        <div class="valor" style="margin-top: 3px;">
            <span class="campo">Arquivos anexos</span>
            <br>
            <input type="file" class="inputfile" id="arquivo" ref="arquivo" @change="setArquivoAtual" />
            <label for="arquivo">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                </svg>
                <span v-text="typeof arquivo_atual.name !== 'undefined' ? arquivo_atual.name.trunc(30) : 'Selecione um arquivo'" v-model="arquivo_atual.name"></span>
            </label>&nbsp;&nbsp;
            <input type="text" @input="descricao_arquivo = $event.target.value" name="descricao_arquivo" v-model="descricao_arquivo" placeholder="Descrição" autocomplete="off" style="width: 200px; min-width: unset; margin-right: 10px;" />
            <button @click.prevent="upload">Submit</button>
            <br><br>
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
                    <tr v-for="(arquivo, index) in arquivos" :key="arquivo.id">
                        <td class="num_arquivo">{{ index+1 }}</td>
                        <td class="nome_arquivo"><a :title="arquivo.nome.substr(15)" :href="`/admin/download/pj/${pessoa.id}/${arquivo.id}`" download>{{ arquivo.nome.substr(15).trunc(30) }}</a></td>
                        <td class="descricao_arquivo">
                            <input autocomplete="off" type="text" name="arquivo_descricao" v-model="arquivo.descricao" />
                        </td>
                        <td class="destaque_arquivo"><a @click.prevent="setImagemDestaque(arquivo.id)"><img v-if="arquivo.tipo === 'imagem'" class="btn_destaque" :src="id_destaque === arquivo.id ? root + '/img/btn_destaque_ativo.png' : root + '/img/btn_destaque.png'" /></a></td>
                        <td class="tipo_arquivo">{{ arquivo.tipo }}</td>
                        <td class="data_arquivo">{{ arquivo.data }}</td>
                        <td class="remove_arquivo"><a @click.prevent="removeArquivo(arquivo.id)">X</a></td>
                    </tr>
                </table>
            </div>
        </div>
        <br><br>

        <!-- Pessoa Física / Chancela -->
        <span class="campo">Pessoas Físicas Relacionadas</span>
        <div id="projetos_pf" class="valor" style="margin-top: 3px;">
            <div>
                <div class="tabela_arquivos">
                    <table>
                        <tr>
                            <th class="num_arquivo">#</th>
                            <th class="nome_arquivo">Nome</th>
                            <th class="descricao_arquivo">Cargo</th>
                            <th class="remove_arquivo">Remover</th>
                        </tr>
                        <tr v-for="(pessoa, index) in pessoas_fisicas_cargos_relacionados" :key="pessoa.id">
                            <td class="num_arquivo">{{ index+1 }}</td>
                            <td class="nome_arquivo"><router-link :id="pessoa.pessoa_fisica_id" :to="{ name: 'pf-view',
                            params: { id: pessoa.pessoa_fisica_id }}">{{ pessoa.pessoa_fisica_nome_adotado }}</router-link></td>
                            <td class="descricao_arquivo">{{ pessoa.cargo }}</td>
                            <td class="remove_arquivo"><a @click.prevent="removeCargoPf(pessoa.pessoa_fisica_id, pessoa.cargo_id)">X</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div><br>

        <!-- Add novo chancela pessoa física -->
        <a @click="mostraCargoPfBoxMetodo" class="link_abrir_box">[adicionar pessoa física]</a>
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
            <div class="tabela_arquivos">
                <table>
                    <tr>
                        <th class="num_arquivo">#</th>
                        <th class="nome_arquivo">Nome</th>
                        <th class="descricao_arquivo">Chancela</th>
                        <th class="remove_arquivo">Remover</th>
                    </tr>
                    <tr v-for="(projeto, index) in projetos" :key="projeto.id">
                        <td class="num_arquivo">{{ index+1 }}</td>
                        <td class="nome_arquivo"><router-link
                                :id="projeto.id"
                                :to="{ name: 'projetos-view',
                                    params: { id: projeto.id }}">{{ projeto['projeto'] }}</router-link></td>
                        <td class="descricao_arquivo">{{ projeto['chancela'] }}</td>
                        <td class="remove_arquivo"><a @click.prevent="console.log('remover')">X</a></td>
                    </tr>
                </table>
            </div>
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
                <a @click.prevent="adicionaEmail = !adicionaEmail" class="link_abrir_box">[adicionar email]</a>
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

                <a @click.prevent="adicionaTel = !adicionaTel" class="link_abrir_box">[adicionar telefone]</a>
                <div v-if="adicionaTel" class="adiciona_contato">
                    <input @input="novo_telefone = $event.target.value" type="text" class="adiciona_contato" v-model="novo_telefone" name="novo_telefone" placeholder="adicionar telefone" />
                    <a @click.prevent="adicionaContato()">+</a>
                </div>

            </div>

            <br>
            <br>

            <!--DADOS GERAIS-->

            <div class="valor">
                <span class="campo">Razão social</span>
                <input autocomplete="off" type="text"
                       v-model="pessoa.razao_social"
                       name="nome"
                />
            </div><br>

            <div class="valor">
                <span class="campo">Nome fantasia</span>
                <input autocomplete="off" type="text"
                       v-model="pessoa.nome_fantasia"
                       name="nome"
                />
            </div><br>

            <div class="valor">
                <span class="campo">CNPJ</span>
                <input autocomplete="off" type="text"
                       v-model="pessoa.cnpj"
                       name="nome"
                />
            </div><br>

            <div class="valor">
                <span class="campo">IE</span>
                <input autocomplete="off" type="text"
                       v-model="pessoa.inscricao_estadual"
                       name="nome"
                />
            </div><br>

            <div class="valor">
                <span class="campo">IM</span>
                <input autocomplete="off" type="text"
                       v-model="pessoa.inscricao_municipal"
                       name="nome"
                />
            </div>

            <div class="valor">
                <span class="campo">Website</span>
                <input autocomplete="off" type="text"
                       v-model="pessoa.website"
                       name="website"
                />
            </div>
            <br>
            <br>
            <br>

            <!-- Endereços -->
            <div v-for="(endereco, index) in enderecos" :key="endereco.id">
                <span class="campo">--- Endereço {{index+1}}</span> <a @click="removeEndereco(endereco.id)">X</a> <br>
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
            <a @click="mostraEnderecoBox = !mostraEnderecoBox" class="link_abrir_box">[adicionar endereço]</a>
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

            <br>
            <br>
            <br>
            <button @click.prevent="salvaForm">Salvar</button>

        </div>

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
                tags: [],
                contatos: [],
                enderecos: [],
                arquivos: [],
                pessoas_fisicas_cargos_relacionados: [],
                projetos: [],
                //Campos de inclusão
                root: '',
                tags_atuais: [],
                pessoa_fisica_id: '',
                novo_cargo: '',
                novo_email: '',
                novo_telefone: '',
                novo_endereco: {rua:'',numero:'',complemento:'',bairro:'',cep:'',cidade:'',estado:'',pais:''},
                novos_dados_bancarios: {nome_banco:'',agencia:'',conta:'',tipo_conta_id:''},
                arquivo_atual: {name: 'Selecione um arquivo'},
                descricao_arquivo: '',
                mensagem_upload: '',
                id_destaque: '',
                imagem_destaque: '',
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
                this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                axios.get('/admin/ajax/pj/' + id).then(res => {
                    eventBus.$emit('getPessoaJuridica', this.$route.params.id);
                    let dados = res.data;
                    this.pessoa = dados.pessoa_juridica;
                    this.tags = dados.tags;
                    this.contatos = dados.contatos;
                    this.enderecos = dados.enderecos;
                    this.arquivos = dados.arquivos;
                    this.projetos = dados.projetos;
                    this.atributos = dados.atributos;
                    this.pessoas_fisicas_cargos_relacionados = dados.pessoas_fisicas_cargos_relacionados;

                    //imagem de destaque
                    this.getImagemDestaque();
                } );
            },
            salvaForm: function(){
                axios.post('/admin/ajax/pj/save', {
                    pessoa: this.pessoa,
                    tags: this.tags_atuais,
                    arquivos: this.arquivos,
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
                this.mostraCargoPfBox = !this.mostraCargoPfBox;
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
            upload: function() {
                let formData = new FormData();
                formData.append('arquivo', this.arquivo_atual);
                formData.append('pessoa_id', this.$route.params.id);
                formData.append('descricao_arquivo', this.descricao_arquivo);

                axios.post('/admin/ajax/pj/upload',
                    formData, {
                        headers: { 'Content-Type': 'multipart/form-data' },
                    }
                ).then(res => {
                    if(typeof res.data !== "string") {
                        this.mensagem_upload = res.data['mensagem_upload'];
                        this.arquivos = res.data['arquivos'];
                        this.arquivo_atual = {};
                        this.descricao_arquivo = '';
                        this.$refs.arquivo.value = '';
                    } else {
                        console.log('Arquivo inválido');
                    }
                });
            },
            removeArquivo: function(id) {
                axios.post('/admin/ajax/pj/removeArquivo', {
                    arquivo_id: id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    this.arquivos = res.data['arquivos'];
                    if(res.data['remove_destaque'] === true)
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                });
            },
            setArquivoAtual() {
                this.arquivo_atual = this.$refs.arquivo.files[0];
            },
            setImagemDestaque: function(arquivo_id) {
                axios.post('/admin/ajax/pj/setImagemDestaque', {
                    arquivo_id: arquivo_id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    this.id_destaque = res.data['imagem_destaque']['id'];
                    this.arquivos = res.data['arquivos'];
                    if(this.id_destaque === 0)
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                    else
                        this.imagem_destaque = `${this.root}/thumbs/pessoas_juridicas/${this.$route.params.id}/${res.data['imagem_destaque']['nome']}`;
                });
            },
            getImagemDestaque: function() {
                axios.post('/admin/ajax/pj/getImagemDestaque', {
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.id_destaque = res.data.id;
                        this.imagem_destaque = `${this.root}/thumbs/pessoas_juridicas/${this.$route.params.id}/${res.data.nome}`;
                    }
                    else
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
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