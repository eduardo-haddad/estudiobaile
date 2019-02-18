<template v-if="this.usuario">

    <div id="container_conteudo" class="formulario" :class="{ loading: !item_carregado, loaded: item_carregado }">

        <div class="titulo">
            <div v-if="destaqueAtivo" class="imagem_destaque">
                <a :href="imagem_destaque_original" data-lightbox="imagem_destaque" :data-title="usuario.name">
                    <img :src="imagem_destaque" />
                </a>
            </div>
            <div v-else class="imagem_destaque">
                <img :src="imagem_destaque" />
            </div>
            <div class="nome">
                <span>
                    <!--<input autocomplete="off" type="text" placeholder=" "-->
                             <!--v-model="usuario.name"-->
                             <!--name="name" style="border:none" />-->
                    {{ usuario.name }}
                </span>
            </div>
        </div>
        <br>
        <br>
        <br>

        <div class="dados">

            <span class="titulo_bloco">Dados gerais</span>

            <!-- Função -->
            <div class="valor">
                <span class="campo">Função</span>
                <select name="funcao" v-model="funcao.id" :disabled="usuario.id === 1">
                    <option v-for="(funcao, index) in atributos.funcoes" :value="funcao.id" :key="'funcao-'+index+funcao.id">
                        {{ funcao.name }}
                    </option>
                </select>
            </div><br>

            <!-- Nome -->
            <div class="valor">
                <span class="campo">Nome</span>
                <input autocomplete="off" type="text" placeholder=" " name="usuario.name" v-model="usuario.name" />
            </div><br>

            <!-- Usuário -->
            <div class="valor">
                <span class="campo">Usuário</span>
                <input autocomplete="off" type="text" placeholder=" " name="usuario.username" v-model="usuario.username" />
            </div><br>

            <!-- Senha -->
            <!--<div class="valor">-->
                <!--<span class="campo">Senha atual</span>-->
                <!--<input autocomplete="off" type="password" name="usuario.oldpassword" @input="nova_senha = $event.target.value" />-->
            <!--</div><br>-->
            <div class="valor">
                <span class="campo">Nova senha</span>
                <input autocomplete="off" type="password" placeholder=" " name="usuario.newpassword" v-model="usuario.password" />
            </div>

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
                    <tr v-for="(arquivo, index) in arquivos" :key="'arquivo'+index+arquivo.id">
                        <td class="num_arquivo">{{ index+1 }}</td>
                        <td class="nome_arquivo"><a :title="arquivo.nome.substr(15)" :href="`/download/usuario/${usuario.id}/${arquivo.id}`" download>{{ arquivo.nome.substr(15).trunc(30) }}</a></td>
                        <td class="descricao_arquivo">
                            <input autocomplete="off" type="text" placeholder=" " name="arquivo_descricao" v-model="arquivo.descricao" />
                        </td>
                        <td class="preview_arquivo">
                            <a v-if="arquivo.tipo === 'imagem'"
                               :href="`/uploads/usuarios/${usuario.id}/${arquivo.nome}`"
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
        <br><br>


        <button @click.prevent="salvaForm">Salvar</button>

        <br><br>
        <a
            v-if="!usuario_atual_logado && usuario.id !== 1"
            class="link_abrir_box delete"
            @click.prevent="removeUsuario(usuario.id)">[remover usuário]</a>

    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';

    export default {
        created() {
            this.getUsuario(this.$route.params.id);
            //reticências em strings maiores que "n"
            String.prototype.trunc = function(n){
                return this.substr(0, n-1) + (this.length > n ? '...' : '');
            };
            //basepath
            this.root = ROOT;
            //usuário logado
            this.usuario_logado = USERID;
            //lightbox
            lightbox.option({
                'disableScrolling': true,
            });
        },
        data() {
            return {
                //Models
                usuario: {},
                usuario_logado: '',
                arquivos: [],
                funcao: '',
                atributos: [],
                //Campos de inclusão
                root: '',
                arquivo_atual: {name: 'Selecione um arquivo'},
                descricao_arquivo: '',
                mensagem_upload: '',
                id_destaque: '',
                imagem_destaque: '',
                imagem_destaque_original: '',
                nova_senha: '',
                //Condicionais
                usuario_atual_logado: false,
                destaqueAtivo: false,
                item_carregado: false
            }
        },
        watch: {
            '$route' (destino) {
                this.getUsuario(destino.params.id);
                eventBus.$emit('changeUsuario');
            },
        },
        computed: {},
        methods: {
            getUsuario: function(id){
                this.item_carregado = false;
                this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                axios.get('/ajax/usuarios/' + id)
                    .then(res => {
                        eventBus.$emit('getUsuario', this.$route.params.id);
                        let dados = res.data;
                        this.usuario = dados.usuario;
                        this.funcao = dados.funcao;
                        this.arquivos = dados.arquivos;
                        this.atributos = dados.atributos;
                        //imagem de destaque
                        this.getImagemDestaque();
                        //atual
                        // this.usuarioAtualLogado(this.usuario.id);
                        this.usuario_atual_logado = parseInt(id, 10) === parseInt(this.usuario_logado, 10);
                        //console.log(`usuario_logado: ${this.usuario_logado} / usuario_atual_logado: ${this.usuario_atual_logado}`);
                    })
                    .then(() => this.item_carregado = true);
            },
            // usuarioAtualLogado: function(id = 0){
            //     this.usuario_atual_logado = parseInt(id, 10) === parseInt(this.usuario_logado, 10);
            // },
            salvaForm: function(){
                axios.post('/ajax/usuarios/save', {
                    usuario: this.usuario,
                    usuario_logado: this.usuario_logado,
                    arquivos: this.arquivos,
                    funcao: this.funcao.id,
                    nova_senha: this.nova_senha
                }).then(res => {
                    if(typeof res.data !== "string"){
                        this.usuario = res.data;
                        eventBus.$emit('foiSalvoUsuario', this.usuario);
                        //atualiza nome do usuário logado no cabeçalho
                        this.atualizaNomeUsuario(this.usuario, this.usuario_logado);
                    } else {
                        alert(res.data);
                        this.$router.push({ name: 'usuarios-index'});
                    }

                });
            },
            upload: function() {
                let formData = new FormData();
                formData.append('arquivo', this.arquivo_atual);
                formData.append('usuario_id', this.$route.params.id);
                formData.append('descricao_arquivo', this.descricao_arquivo);

                axios.post('/ajax/usuarios/upload',
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
                axios.post('/ajax/usuarios/removeArquivo', {
                    arquivo_id: id,
                    usuario_id: this.$route.params.id,
                }).then(res => {
                    this.arquivos = res.data['arquivos'];
                    if(res.data['remove_destaque'] === true) {
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                        this.destaqueAtivo = false;
                    }
                });
            },
            setArquivoAtual() {
                this.arquivo_atual = this.$refs.arquivo.files[0];
            },
            setImagemDestaque: function(arquivo_id) {
                axios.post('/ajax/usuarios/setImagemDestaque', {
                    arquivo_id: arquivo_id,
                    usuario_id: this.$route.params.id,
                }).then(res => {
                    this.id_destaque = res.data['imagem_destaque']['id'];
                    this.arquivos = res.data['arquivos'];
                    if(this.id_destaque === 0) {
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                        this.destaqueAtivo = false;
                    }
                    else {
                        this.imagem_destaque = `${this.root}/thumbs/usuarios/${this.$route.params.id}/${res.data['imagem_destaque']['nome']}`;
                        this.imagem_destaque_original = `${this.root}/uploads/usuarios/${this.$route.params.id}/${res.data['imagem_destaque']['nome']}`;
                        this.destaqueAtivo = true;
                    }
                });
            },
            getImagemDestaque: function() {
                axios.post('/ajax/usuarios/getImagemDestaque', {
                    usuario_id: this.$route.params.id,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.id_destaque = res.data.id;
                        this.imagem_destaque = `${this.root}/thumbs/usuarios/${this.$route.params.id}/${res.data.nome}`;
                        this.imagem_destaque_original = `${this.root}/uploads/usuarios/${this.$route.params.id}/${res.data.nome}`;
                        this.destaqueAtivo = true;
                    }
                    else {
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                        this.destaqueAtivo = false;
                    }
                });
            },
            removeUsuario: function(id) {
                axios.post('/ajax/usuarios/removeUsuario/' + id, {
                    usuario_logado: this.usuario_logado
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.usuarios = res.data;
                        eventBus.$emit('usuarioRemovido', this.usuarios);
                        this.$router.push({ name: "usuarios-index"});
                    }
                });
            },
            atualizaNomeUsuario: (usuario_atual, id_usuario_logado) => {
                if(parseInt(usuario_atual.id, 10) === parseInt(id_usuario_logado, 10))
                    document.getElementById('nome_usuario').innerHTML = usuario_atual.name;
            },
        }
    }
</script>