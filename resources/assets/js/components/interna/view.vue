<template>

    <div class="detalhe" :class="{ loading: !item_carregado, loaded: item_carregado }" style="width: 100%; border-left: 1px solid #babcbd;">

        <div id="container_conteudo" class="formulario">

            <div class="titulo">
                <div class="nome" style="padding-left: 0;">
                <span>Estúdio Baile - Interna</span>
                </div>
            </div>

            <div id="editor" style="height: 400px"></div>

            <br><br>

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
                        <tr v-for="(arquivo, index) in arquivos" :key="arquivo.id">
                            <td class="num_arquivo">{{ index+1 }}</td>
                            <td class="nome_arquivo"><a :title="arquivo.nome.substr(15)" :href="`/download/interna/${arquivo.id}`" download>{{ arquivo.nome.substr(15).trunc(30) }}</a></td>
                            <td class="descricao_arquivo">
                                <input autocomplete="off" type="text" name="arquivo_descricao" v-model="arquivo.descricao" />
                            </td>
                            <td class="preview_arquivo">
                                <a v-if="arquivo.tipo === 'imagem'"
                                   :href="`/uploads/interna/${arquivo.nome}`"
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

            <br><br><br>

            <button @click.prevent="salvaForm">Salvar</button>


        </div>
    </div>



</template>

<script>

    const toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike', 'link'],        // toggled buttons
        ['image'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        //[{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        //[{ 'font': [] }],
        [{ 'align': [] }],
        ['clean', 'divider']                                         // remove formatting button
    ];

    import { eventBus } from '../../estudiobaile';

    export default {
        created() {
            this.getInterna();
            //basepath
            this.root = ROOT;
            //reticências em strings maiores que "n"
            String.prototype.trunc = function(n){
                return this.substr(0, n-1) + (this.length > n ? '...' : '');
            };
            //lightbox
            lightbox.option({
                'disableScrolling': true,
            });
        },
        mounted() {
            //highlight menu
            this.highlight_menu();

            //Quill
            const Quill = this.Quill = window.quill;

            const container = document.getElementById('editor');
            const opcoesEditor = {
                modules: {
                    toolbar: {
                        container: toolbarOptions
                    }
                },
                theme: 'snow',
                bounds: '#editor',
            };

            //linha horizontal no menu
            const BlockEmbed = Quill.import('blots/block/embed');
            class DividerBlot extends BlockEmbed { }
            DividerBlot.blotName = 'divider';
            DividerBlot.tagName = 'hr';
            Quill.register(DividerBlot);
            //inicialização
            const editor = new Quill(container, opcoesEditor);
            //botão linha horizontal
            this.$el.querySelector('.ql-divider').style.cssText = `
                background: url('img/hr.png') center center / 10px 10px no-repeat;
            `;
        },
        data() {
            return {
                //Models
                arquivos: [],
                //Campos de inclusão
                root: '',
                conteudoEditor: '',
                arquivo_atual: {name: 'Selecione um arquivo'},
                descricao_arquivo: '',
                mensagem_upload: '',
                //Condicionais
                item_carregado: false,
                Quill: null,
            }
        },
        watch: {
            '$route' (destino) {
            },
        },
        computed: {},
        methods: {
            quillDivider: function(){
                let range = quill.getSelection(true);
                quill.insertText(range.index, '\n', Quill.sources.USER);
                quill.insertEmbed(range.index + 1, 'divider', true, Quill.sources.USER);
                quill.setSelection(range.index + 2, Quill.sources.SILENT);
            },
            getInterna: function(){
                axios.get('/ajax/interna/getInterna').then(res => {
                    // eventBus.$emit('getInterna');
                    let dados = res.data;
                    this.item_carregado = true;
                    this.conteudoEditor = dados.conteudoEditor;
                    this.arquivos = dados.arquivos;

                    document.querySelector('#editor').children[0].innerHTML = this.conteudoEditor;
                });
            },
            salvaForm: function(){
                this.item_carregado = false;
                this.conteudoEditor = document.querySelector('#editor').children[0].innerHTML;

                axios.post('/ajax/interna/saveInterna', {
                    conteudoEditor: this.conteudoEditor,
                    arquivos: this.arquivos,
                }).then(res => {
                    eventBus.$emit('foiSalvoEditor');
                    this.item_carregado = true;
                });
            },
            upload: function() {
                let formData = new FormData();
                formData.append('arquivo', this.arquivo_atual);
                formData.append('descricao_arquivo', this.descricao_arquivo);

                axios.post('/ajax/interna/upload',
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
                axios.post('/ajax/interna/removeArquivo', {
                    arquivo_id: id,
                }).then(res => {
                    this.arquivos = res.data['arquivos'];
                });
            },
            setArquivoAtual() {
                this.arquivo_atual = this.$refs.arquivo.files[0];
            },
            highlight_menu: () => {
                const menu = document.getElementById('menu_principal');
                let items = menu.getElementsByTagName('li');
                let url = window.location.hash;
                for (let i = 0; i < items.length; ++i) {
                    if(url.includes(items[i].id))
                        items[i].className = 'opcao selecionado';
                    else
                        items[i].className = 'opcao';
                }
            }
        }
    }
</script>