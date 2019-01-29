<template v-if="this.projeto">

    <div id="container_conteudo" class="formulario" :class="{ loading: !item_carregado, loaded: item_carregado }">

        <modal v-if="modalDelete" @close="modalDelete = false">
            <h3 slot="header">Excluir registro?</h3>
        </modal>

        <editbar export="false" delete="true"></editbar>

        <div class="titulo">
            <div v-if="destaqueAtivo" class="imagem_destaque">
                <a :href="imagem_destaque_original" data-lightbox="imagem_destaque" :data-title="projeto.nome">
                    <img :src="imagem_destaque" />
                </a>
            </div>
            <div v-else class="imagem_destaque">
                <img :src="imagem_destaque" />
            </div>
            <div class="nome">
                <span>
                    <!--<input autocomplete="off" type="text"-->
                           <!--v-model="projeto.nome"-->
                           <!--name="nome_adotado" style="border:none" />-->
                    {{ projeto.nome }}
                </span>
            </div>
        </div>

        <br>
        <br>

        <div class="valor">
            <span class="campo">Descrição</span>
            <textarea v-model="projeto.descricao"
                      name="projeto-descricao"
                      rows="2"
                      placeholder=" ">
            </textarea>
        </div>

        <br>
        <hr>

        <!-- Arquivos -->
        <div class="valor" style="margin-top: 3px;">
            <span class="titulo_bloco">Arquivos anexos</span>
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
                        <th class="preview_arquivo">Visualizar</th>
                        <th class="destaque_arquivo">Destaque</th>
                        <th class="tipo_arquivo">Tipo</th>
                        <th class="data_arquivo">Data</th>
                        <th class="remove_arquivo">Remover</th>
                    </tr>
                    <tr v-for="(arquivo, index) in arquivos" :key="'arquivo-'+index+arquivo.id">
                        <td class="num_arquivo">{{ index+1 }}</td>
                        <td class="nome_arquivo"><a :title="arquivo.nome.substr(15)" :href="`/download/projeto/${projeto.id}/${arquivo.id}`" download>{{ arquivo.nome.substr(15).trunc(30) }}</a></td>
                        <td class="descricao_arquivo">
                            <input autocomplete="off" type="text" name="arquivo_descricao" v-model="arquivo.descricao" />
                        </td>
                        <td class="preview_arquivo">
                            <a v-if="arquivo.tipo === 'imagem'"
                               :href="`/uploads/projetos/${projeto.id}/${arquivo.nome}`"
                               :data-lightbox="'imagem_preview'+index" :data-title="arquivo.nome.substr(15)">
                                <img class="btn_preview"
                                     :src="root + '/img/btn_preview.png'" />
                            </a>
                        </td>
                        <td class="destaque_arquivo">
                            <a @click.prevent="setImagemDestaque(arquivo.id)">
                                <img v-if="arquivo.tipo === 'imagem'"
                                     class="btn_destaque"
                                     :src="id_destaque === arquivo.id ? root + '/img/btn_destaque_ativo.png' : root + '/img/btn_destaque.png'" />
                            </a>
                        </td>
                        <td class="tipo_arquivo">{{ arquivo.tipo }}</td>
                        <td class="data_arquivo">{{ arquivo.data }}</td>
                        <td class="remove_arquivo"><a @click.prevent="removeArquivo(arquivo.id)">X</a></td>
                    </tr>
                </table>
            </div>
        </div>

        <br><hr>

        <!--DADOS GERAIS-->
        <div class="dados">

            <span class="titulo_bloco">Dados gerais</span>

            <div class="valor">
                <span class="campo">Nome</span>
                <input autocomplete="off" type="text"
                       v-model="projeto.nome"
                       name="projeto-nome"
                       class="nome"
                />
            </div><br><br>
            <!-- -->
            <div class="valor">
                <span class="campo">Data de início</span>
                <input autocomplete="off" type="date"
                       v-model="projeto.dt_inicio"
                       name="projeto-data-inicio"
                />
            </div><br><br>
            <!-- -->
            <div class="valor">
                <span class="campo">Data de término</span>
                <input autocomplete="off" type="date"
                       v-model="projeto.dt_fim"
                       name="projeto-data-fim"
                />
            </div><br><br>
            <!-- -->
            <div class="valor">
                <span class="campo">Website</span>
                <input autocomplete="off" type="text"
                       v-model="projeto.website"
                       name="projeto-website"
                />
            </div>

            <br>
            <hr>

            <!-- Pessoas Físicas relacionadas -->
            <span class="titulo_bloco">Pessoas Físicas relacionadas</span>

            <div id="projetos_pf" class="valor">
                <div id="projetos">
                    <div class="tabela_arquivos">
                        <table>
                            <tr>
                                <th class="num_arquivo">#</th>
                                <th class="nome_arquivo">Nome</th>
                                <th class="descricao_arquivo">Chancela</th>
                                <th class="destaque_arquivo"></th>
                                <th class="tipo_arquivo"></th>
                                <th class="data_arquivo"></th>
                                <th class="remove_arquivo">Remover</th>
                            </tr>
                            <tr v-for="(pessoa, index) in pessoas_fisicas_chancelas_relacionadas" :key="'pf-'+index+pessoa.id">
                                <td class="num_arquivo">{{ index+1 }}</td>
                                <td class="nome_arquivo"><router-link :id="pessoa.pessoa_id" :to="{ name: 'pf-view',
                                params: { id: pessoa.pessoa_id }}">{{ pessoa.nome }}</router-link></td>
                                <td class="descricao_arquivo">{{ pessoa.tag }}</td>
                                <td class="destaque_arquivo"></td>
                                <td class="tipo_arquivo"></td>
                                <td class="data_arquivo"></td>
                                <td class="remove_arquivo"><a @click.prevent="removeChancela(pessoa.pessoa_id, pessoa.tag_id, true)">X</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div><br>

            <!-- Add novo chancela pessoa física -->
            <a @click="mostraChancelaBoxMetodo(true)" class="link_abrir_box">[nova chancela pessoa física]</a>
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
                    <option v-for="chancela in atributos.chancelas" :value="chancela.id">{{ chancela.text }}</option>
                </select>
                <a @click.prevent="adicionaChancela(true)">[+]</a>

            </div>

            <hr>

            <!-- Pessoa Jurídica / Chancela -->
            <span class="titulo_bloco">Pessoas Jurídicas relacionadas</span>

            <div id="" class="valor" style="margin-top: 3px;">
                <div id="projetos_pj">
                    <div class="tabela_arquivos">
                        <table>
                            <tr>
                                <th class="num_arquivo">#</th>
                                <th class="nome_arquivo">Nome</th>
                                <th class="descricao_arquivo">Chancela</th>
                                <th class="destaque_arquivo"></th>
                                <th class="tipo_arquivo"></th>
                                <th class="data_arquivo"></th>
                                <th class="remove_arquivo">Remover</th>
                            </tr>
                            <tr v-for="(pessoa, index) in pessoas_juridicas_chancelas_relacionadas" :key="'pj-'+index+pessoa.id">
                                <td class="num_arquivo">{{ index+1 }}</td>
                                <td class="nome_arquivo"><router-link
                                        :id="pessoa.pessoa_id" :to="{ name: 'pj-view',
                                        params: { id: pessoa.pessoa_id }}">{{ pessoa.nome }}</router-link></td>
                                <td class="descricao_arquivo">{{ pessoa.tag }}</td>
                                <td class="destaque_arquivo"></td>
                                <td class="tipo_arquivo"></td>
                                <td class="data_arquivo"></td>
                                <td class="remove_arquivo"><a @click.prevent="removeChancela(pessoa.pessoa_id, pessoa.tag_id, false)">X</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div><br>

            <!-- Add novo chancela pessoa jurídica -->
            <a @click="mostraChancelaBoxMetodo(false)" class="link_abrir_box">[nova chancela pessoa jurídica]</a>
            <div v-if="mostraChancelaPjBox">
                <span class="campo">--- Nova Chancela PJ</span><br>
                <span class="campo">Nome</span>
                <select name="pessoas_juridicas" class="pj_lista">
                    <option disabled selected value> -- Selecione um nome -- </option>
                    <option v-for="pessoa in atributos.pessoas_juridicas" :value="pessoa.id">
                        {{ pessoa.nome_fantasia }}
                    </option>
                </select><br>
                <span class="campo">Chancela</span>
                <select name="chancelas" class="chancelas_pj_lista">
                    <option disabled selected value> -- Selecione uma chancela -- </option>
                    <option v-for="chancela in atributos.chancelas" :value="chancela.id">{{ chancela.text }}</option>
                </select>
                <a @click.prevent="adicionaChancela(false)">[+]</a>

            </div>

        </div>

    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';
    import modal from '../modals/modal_delete';
    import editbar from '../editbar';

    export default {
        components: {
            modal,
            editbar
        },
        created() {
            this.getProjeto(this.$route.params.id);
            this.jQuery();
            //reticências em strings maiores que "n"
            String.prototype.trunc = function(n){
                return this.substr(0, n-1) + (this.length > n ? '...' : '');
            };
            //basepath
            this.root = ROOT;
            //lightbox
            lightbox.option({
                'disableScrolling': true,
            });
        },
        mounted() {
            //evento - salvar formulário
            eventBus.$on('editbar-salvar', () => {
                this.salvaForm();
            });
            //evento - mostrar modal de exclusão
            eventBus.$on('editbar-excluir', () => {
                this.modalDelete = true;
            });
            //evento - excluir registro
            eventBus.$on('excluir-projeto', () => {
                this.deleteProjeto();
            });
            //evento - exportar
            eventBus.$on('editbar-exportar', () => {
                //
            });
        },
        data() {
            return {
                //Models
                projeto: {},
                descricao: '',
                atributos: [],
                pessoas_fisicas_chancelas_relacionadas: [],
                pessoas_juridicas_chancelas_relacionadas: [],
                arquivos: [],
                website: '',
                //Campos de inclusão
                root: '',
                pessoas_fisicas_atuais: [],
                pessoas_juridicas_atuais: [],
                chancelas_pf_atuais: [],
                chancelas_pj_atuais: [],
                nova_chancela_pf: {pessoa_fisica: '', chancela: ''},
                nova_chancela_pj: {pessoa_juridica: '', chancela: ''},
                arquivo_atual: {name: 'Selecione um arquivo'},
                descricao_arquivo: '',
                mensagem_upload: '',
                id_destaque: '',
                imagem_destaque: '',
                imagem_destaque_original: '',
                //Condicionais
                mostraChancelaPfBox: false,
                mostraChancelaPjBox: false,
                destaqueAtivo: false,
                item_carregado: false,
                modalDelete: false,
            }
        },
        watch: {
            '$route' (destino) {
                this.getProjeto(destino.params.id);
                eventBus.$emit('changeProjeto');
                this.jQuery();
            },
        },
        computed: {},
        methods: {
            getProjeto: function(id){
                this.item_carregado = false;
                this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                axios.get('/ajax/projetos/' + id)
                    .then(res => {
                        eventBus.$emit('getProjeto', this.$route.params.id);
                        let dados = res.data;
                        this.projeto = dados.projeto;
                        this.arquivos = dados.arquivos;
                        this.pessoas_fisicas_chancelas_relacionadas = dados.pessoas_fisicas_chancelas_relacionadas;
                        this.pessoas_juridicas_chancelas_relacionadas = dados.pessoas_juridicas_chancelas_relacionadas;
                        this.atributos = dados.atributos;

                        //imagem de destaque
                        this.getImagemDestaque();
                    })
                    .then(() => this.item_carregado = true);
            },
            salvaForm: function(){
                this.item_carregado = false;
                axios.post('/ajax/projetos/save', {
                    projeto: this.projeto,
                    pessoas_fisicas: this.pessoas_fisicas_atuais,
                    chancelas_pf: this.chancelas_pf_atuais,
                    arquivos: this.arquivos,
                })
                .then(res => {
                    this.projeto = res.data;
                    eventBus.$emit('foiSalvoProjeto', this.projeto);
                })
                .then(() => this.item_carregado = true);
            },
            deleteProjeto: function(){
                axios.post('/ajax/projetos/delete', {
                    projeto: this.$route.params.id,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        eventBus.$emit('deleteProjeto', res.data);
                        this.$router.push({ name: 'projetos-index'});
                    } else
                        console.log('Erro ao deletar projeto');
                });
            },
            adicionaChancela: function(isPf){
                this.item_carregado = false;
                const nova_chancela = isPf ? this.nova_chancela_pf : this.nova_chancela_pj;
                axios.post('/ajax/projetos/ajaxAddChancela', {
                    projeto_id: this.$route.params.id,
                    nova_chancela: nova_chancela
                })
                .then(res => {
                    if(typeof res.data[0] !== "string") {
                        if(isPf) {
                            this.pessoas_fisicas_chancelas_relacionadas = res.data[0];
                            this.nova_chancela_pf = {};
                            this.mostraChancelaPfBox = false;
                        }
                        else {
                            this.pessoas_juridicas_chancelas_relacionadas = res.data[0];
                            this.nova_chancela_pj = {};
                            this.mostraChancelaPjBox = false;
                        }
                        this.atributos.chancelas = res.data[1];
                    }
                })
                .then(() => this.item_carregado = true);
            },
            removeChancela: function(pessoa_id, tag_id, isPf){
                this.item_carregado = false;
                let pessoa_fisica_id, pessoa_juridica_id;
                pessoa_fisica_id = isPf === true ? pessoa_id : false;
                pessoa_juridica_id = isPf === true ? false : pessoa_id;

                axios.post('/ajax/projetos/ajaxRemoveChancela', {
                    pessoa_fisica_id: pessoa_fisica_id,
                    pessoa_juridica_id: pessoa_juridica_id,
                    tag_id: tag_id,
                    projeto_id: this.$route.params.id,
                })
                .then(res => {
                    if(isPf === true) this.pessoas_fisicas_chancelas_relacionadas = res.data;
                    else this.pessoas_juridicas_chancelas_relacionadas = res.data;
                })
                .then(() => this.item_carregado = true);
            },
            mostraChancelaBoxMetodo: function(isPf){
                if(isPf) this.mostraChancelaPfBox = !this.mostraChancelaPfBox;
                else this.mostraChancelaPjBox = !this.mostraChancelaPjBox;
                this.jQuery();
            },
            setArquivoAtual() {
                this.arquivo_atual = this.$refs.arquivo.files[0];
            },
            upload: function() {
                this.item_carregado = false;
                let formData = new FormData();
                formData.append('arquivo', this.arquivo_atual);
                formData.append('projeto_id', this.$route.params.id);
                formData.append('descricao_arquivo', this.descricao_arquivo);

                axios.post('/ajax/projetos/upload',
                    formData, {
                        headers: { 'Content-Type': 'multipart/form-data' },
                    }
                )
                .then(res => {
                    if(typeof res.data !== "string") {
                        this.mensagem_upload = res.data['mensagem_upload'];
                        this.arquivos = res.data['arquivos'];
                        this.arquivo_atual = {};
                        this.descricao_arquivo = '';
                        this.$refs.arquivo.value = '';
                    } else {
                        console.log('Arquivo inválido');
                    }
                })
                .then(() => this.item_carregado = true);
            },
            removeArquivo: function(id) {
                this.item_carregado = false;
                axios.post('/ajax/projetos/removeArquivo', {
                    arquivo_id: id,
                    projeto_id: this.$route.params.id,
                })
                .then(res => {
                    this.arquivos = res.data['arquivos'];
                    if(res.data['remove_destaque'] === true) {
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                        this.destaqueAtivo = false;
                    }
                })
                .then(() => this.item_carregado = true);
            },
            setImagemDestaque: function(arquivo_id) {
                axios.post('/ajax/projetos/setImagemDestaque', {
                    arquivo_id: arquivo_id,
                    projeto_id: this.$route.params.id,
                }).then(res => {
                    this.id_destaque = res.data['imagem_destaque']['id'];
                    this.arquivos = res.data['arquivos'];
                    if(this.id_destaque === 0) {
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                        this.destaqueAtivo = false;
                    }
                    else {
                        this.imagem_destaque = `${this.root}/thumbs/projetos/${this.$route.params.id}/${res.data['imagem_destaque']['nome']}`;
                        this.imagem_destaque_original = `${this.root}/uploads/projetos/${this.$route.params.id}/${res.data['imagem_destaque']['nome']}`;
                        this.destaqueAtivo = true;
                    }
                });
            },
            getImagemDestaque: function() {
                axios.post('/ajax/projetos/getImagemDestaque', {
                    projeto_id: this.$route.params.id,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.id_destaque = res.data.id;
                        this.imagem_destaque = `${this.root}/thumbs/projetos/${this.$route.params.id}/${res.data.nome}`;
                        this.imagem_destaque_original = `${this.root}/uploads/projetos/${this.$route.params.id}/${res.data.nome}`;
                        this.destaqueAtivo = true;
                    }
                    else {
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                        this.destaqueAtivo = false;
                    }
                });
            },
            jQuery: function(){

                //Instancia atual do Vue
                let Vue = this;

                $(document).ready(function(){

                    //Carrega select2 de pessoas físicas e jurídicas
                    $('.pf_lista, .pj_lista').select2({
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

                    //Carrega select2 de chancelas
                    $('.chancelas_pf_lista, .chancelas_pj_lista').select2({
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

                    //Atualiza valores onChange
                    $('.pf_lista').on('change', function(){
                        Vue.nova_chancela_pf.pessoa_fisica = $(this).val();
                    });

                    $('.chancelas_pf_lista').on('change', function(){
                        Vue.nova_chancela_pf.chancela = $(this).val();
                    });

                    $('.pj_lista').on('change', function(){
                        Vue.nova_chancela_pj.pessoa_juridica = $(this).val();
                    });

                    $('.chancelas_pj_lista').on('change', function(){
                        Vue.nova_chancela_pj.chancela = $(this).val();
                    });

                });
            },
        }
    }
</script>