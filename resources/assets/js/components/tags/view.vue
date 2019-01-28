<template v-if="this.tag">

    <div id="container_conteudo" class="formulario" :class="{ loading: !item_carregado, loaded: item_carregado }">

        <editbar export="false" delete="false"></editbar>

        <div class="titulo">
            <div class="nome" style="padding-left: 0;">
                <span>
                    <!--<input autocomplete="off" type="text"-->
                             <!--v-if="tag.text"-->
                             <!--v-model="tag.text"-->
                             <!--name="nome_adotado" style="border:none" />-->
                    {{ tag.text }}
                </span>
            </div>
        </div>

        <hr>

        <!--DADOS GERAIS-->
        <span class="titulo_bloco">Dados gerais</span>

        <div class="dados">
            <div class="valor">
                <span class="campo">Tipo</span>
                <input disabled="disabled" type="text" placeholder=" "
                       v-model="tipo"
                />
            </div><br>

            <div class="valor">
                <span class="campo">Valor</span>
                <input autocomplete="off" type="text" placeholder=" "
                       v-model="tag.text"
                />
            </div>
        </div>

        <br>
        <hr>

        <div v-if="tipo === 'tag'">
            <!-- Pessoas Físicas relacionadas -->
            <div class="valor" style="margin-top: 3px;">
                <span class="titulo_bloco">Pessoas físicas relacionadas</span>
                <br>
                <div class="tabela_arquivos">
                    <table>
                        <tr>
                            <th class="num_arquivo">#</th>
                            <th class="nome_arquivo">Nome</th>
                            <th class="remove_arquivo">Remover</th>
                        </tr>
                        <tr v-for="(pessoa, index) in pessoas_fisicas_relacionadas" :key="pessoa.id">
                            <td class="num_arquivo">{{ index+1 }}</td>
                            <td class="nome_arquivo"><router-link :title="pessoa.nome_adotado" :id="pessoa.id" :to="{ name: 'pf-view', params: { id: pessoa.id }}">{{ pessoa.nome_adotado.trunc(30) }}</router-link></td>
                            <td class="remove_arquivo"><a @click.prevent="removeTag(pessoa.id, 1)">X</a></td>
                        </tr>
                    </table>
                </div>
            </div>

            <br>
            <hr>

            <!-- Pessoas Jurídicas relacionadas -->
            <div class="valor" style="margin-top: 3px;">
                <span class="titulo_bloco">Pessoas jurídicas relacionadas</span>
                <br>
                <div class="tabela_arquivos">
                    <table>
                        <tr>
                            <th class="num_arquivo">#</th>
                            <th class="nome_arquivo">Nome</th>
                            <th class="remove_arquivo">Remover</th>
                        </tr>
                        <tr v-for="(pessoa, index) in pessoas_juridicas_relacionadas" :key="pessoa.id">
                            <td class="num_arquivo">{{ index+1 }}</td>
                            <td class="nome_arquivo"><router-link :title="pessoa.nome_fantasia" :id="pessoa.id" :to="{ name: 'pj-view', params: { id: pessoa.id }}">{{ pessoa.nome_fantasia.trunc(30) }}</router-link></td>
                            <td class="remove_arquivo"><a @click.prevent="removeTag(pessoa.id, 2)">X</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div v-if="tipo === 'cargo'">
            <!-- Pessoas Físicas relacionadas -->
            <div class="valor" style="margin-top: 3px;">
                <span class="titulo_bloco">Cargos relacionados</span>
                <br>
                <div class="tabela_arquivos">
                    <table>
                        <tr>
                            <th class="num_arquivo">#</th>
                            <th class="tipo">Tipo</th>
                            <th class="nome_arquivo">Pessoa Física</th>
                            <th class="nome_arquivo">Pessoa Jurídica</th>
                            <th class="remove_arquivo">Remover</th>
                        </tr>
                        <tr v-for="(pessoa, index) in pessoas_cargos_relacionados" :key="'pessoas_cargos_relacionados'+index">
                            <td class="num_arquivo">{{ index+1 }}</td>
                            <td class="tipo">{{ tipo }}</td>
                            <td class="nome_arquivo"><router-link :title="pessoa.pessoa_fisica.nome_adotado" :id="pessoa.pessoa_fisica.id" :to="{ name: 'pf-view', params: { id: pessoa.pessoa_fisica.id }}">{{ pessoa.pessoa_fisica.nome_adotado.trunc(30) }}</router-link></td>
                            <td class="nome_arquivo"><router-link :title="pessoa.pessoa_juridica.nome_fantasia" :id="pessoa.pessoa_juridica.id" :to="{ name: 'pj-view', params: { id: pessoa.pessoa_juridica.id }}">{{ pessoa.pessoa_juridica.nome_fantasia.trunc(30) }}</router-link></td>
                            <td class="remove_arquivo"><a @click.prevent="removeCargo(pessoa.pessoa_fisica.id, pessoa.pessoa_juridica.id)">X</a></td>
                        </tr>
                    </table>
                </div>
            </div>


        </div>

        <div v-if="tipo === 'chancela'">
            <!-- Pessoas Físicas relacionadas -->
            <div class="valor" style="margin-top: 3px;">
                <span class="titulo_bloco">Pessoas físicas relacionadas</span>
                <br>
                <div class="tabela_arquivos">
                    <table>
                        <tr>
                            <th class="num_arquivo">#</th>
                            <th class="nome_arquivo">Nome</th>
                            <th class="nome_arquivo">Projeto</th>
                            <th class="remove_arquivo">Remover</th>
                        </tr>
                        <tr v-for="(pessoa, index) in pessoas_fisicas_chancelas_relacionadas" :key="pessoa.id">
                            <td class="num_arquivo">{{ index+1 }}</td>
                            <td class="nome_arquivo"><router-link :title="pessoa.nome_adotado" :id="pessoa.id" :to="{ name: 'pf-view', params: { id: pessoa.id }}">{{ pessoa.nome_adotado.trunc(30) }}</router-link></td>
                            <td class="nome_arquivo"><router-link :title="pessoa.projeto_nome" :id="pessoa.projeto_id" :to="{ name: 'projetos-view', params: { id: pessoa.projeto_id }}">{{ pessoa.projeto_nome.trunc(30) }}</router-link></td>
                            <td class="remove_arquivo"><a @click.prevent="removeChancela(pessoa.projeto_id, pessoa.id, null)">X</a></td>
                        </tr>
                    </table>
                </div>
            </div>

            <br>
            <hr>

            <!-- Pessoas Jurídicas relacionadas -->
            <div class="valor" style="margin-top: 3px;">
                <span class="titulo_bloco">Pessoas jurídicas relacionadas</span>
                <br>
                <div class="tabela_arquivos">
                    <table>
                        <tr>
                            <th class="num_arquivo">#</th>
                            <th class="nome_arquivo">Nome</th>
                            <th class="nome_arquivo">Projeto</th>
                            <th class="remove_arquivo">Remover</th>
                        </tr>
                        <tr v-for="(pessoa, index) in pessoas_juridicas_chancelas_relacionadas" :key="pessoa.id">
                            <td class="num_arquivo">{{ index+1 }}</td>
                            <td class="nome_arquivo"><router-link :title="pessoa.nome_fantasia" :id="pessoa.id" :to="{ name: 'pj-view', params: { id: pessoa.id }}">{{ pessoa.nome_fantasia.trunc(30) }}</router-link></td>
                            <td class="nome_arquivo"><router-link :title="pessoa.projeto_nome" :id="pessoa.projeto_id" :to="{ name: 'projetos-view', params: { id: pessoa.projeto_id }}">{{ pessoa.projeto_nome.trunc(30) }}</router-link></td>
                            <td class="remove_arquivo"><a @click.prevent="removeChancela(pessoa.projeto_id, null, pessoa.id)">X</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';
    //barra superior - salvar
    import editbar from '../editbar';

    export default {
        components: {
            editbar
        },
        mounted(){
            //evento - salvar formulário
            eventBus.$on('editbar-salvar', () => {
                this.salvaForm();
            });
        },
        created() {
            this.getTag(this.$route.params.id);
            //basepath
            this.root = ROOT;
            //reticências em strings maiores que "n"
            String.prototype.trunc = function(n){
                return this.substr(0, n-1) + (this.length > n ? '...' : '');
            };
        },
        data() {
            return {
                //Models
                tipo: '',
                tag: {},
                tags: [],
                pessoas_fisicas_relacionadas: [],
                pessoas_juridicas_relacionadas: [],
                pessoas_cargos_relacionados: [],
                pessoas_fisicas_chancelas_relacionadas: [],
                pessoas_juridicas_chancelas_relacionadas: [],
                //Campos de inclusão
                root: '',
                //Condicionais
                item_carregado: false
            }
        },
        watch: {
            '$route' (destino) {
                this.getTag(destino.params.id);
                eventBus.$emit('changeTag');
            },
        },
        computed: {},
        methods: {
            getTag: function(id){
                this.item_carregado = false;
                axios.get('/ajax/tags/view/' + id)
                    .then(res => {
                        eventBus.$emit('getTag', this.$route.params.id);
                        this.tag = res.data['tag'];
                        this.tipo = this.tag.tipo;

                        if(this.tipo === "tag") {
                            this.pessoas_fisicas_relacionadas = res.data['pessoas_fisicas_relacionadas'];
                            this.pessoas_juridicas_relacionadas = res.data['pessoas_juridicas_relacionadas'];
                        } else if(this.tipo === "cargo") {
                            this.pessoas_cargos_relacionados = res.data['pessoas_relacionadas'];
                        } else if(this.tipo === "chancela") {
                            this.pessoas_fisicas_chancelas_relacionadas = res.data['pessoas_fisicas_relacionadas'];
                            this.pessoas_juridicas_chancelas_relacionadas = res.data['pessoas_juridicas_relacionadas'];
                        }

                    })
                    .then(() => this.item_carregado = true);
            },
            removeTag: function(pessoa_id, tipo){
                this.item_carregado = false;
                axios.post('/ajax/tags/ajaxRemoveTag/' + this.tag.id, {
                    pessoa_id: pessoa_id,
                    pessoa_tipo: tipo
                }).then(res => {
                    if(res.data['empty']) {
                        this.tags = res.data['index'];
                        eventBus.$emit('tagRemovida', this.tags);
                        this.$router.push({ name: "tags-index"});
                    } else {
                        //Atualiza tag se não foi excluída
                        this.getTag(this.tag.id);
                    }
                });
            },
            removeCargo: function(pessoa_fisica_id, pessoa_juridica_id){
                this.item_carregado = false;
                axios.post('/ajax/tags/ajaxRemoveCargo', {
                    tag_id: this.tag.id,
                    pessoa_fisica_id: pessoa_fisica_id,
                    pessoa_juridica_id: pessoa_juridica_id
                }).then(res => {
                    if(res.data['empty']) {
                        this.tags = res.data['index'];
                        eventBus.$emit('tagRemovida', this.tags);
                        this.$router.push({ name: "tags-index"});
                    } else {
                        //Atualiza tag se não foi excluída
                        this.getTag(this.tag.id);
                    }
                });
            },
            removeChancela: function(projeto_id, pessoa_fisica_id, pessoa_juridica_id){
                this.item_carregado = false;
                axios.post('/ajax/tags/ajaxRemoveChancela', {
                    tag_id: this.tag.id,
                    projeto_id: projeto_id,
                    pessoa_fisica_id: pessoa_fisica_id,
                    pessoa_juridica_id: pessoa_juridica_id
                }).then(res => {
                    if(res.data['empty']) {
                        this.tags = res.data['index'];
                        eventBus.$emit('tagRemovida', this.tags);
                        this.$router.push({ name: "tags-index"});
                    } else {
                        //Atualiza tag se não foi excluída
                        this.getTag(this.tag.id);
                    }
                });
            },
            salvaForm: function(){
                this.item_carregado = false;
                axios.post('/ajax/tags/save', {
                    tag: this.tag,
                }).then(res => {
                    this.tags = res.data;
                    eventBus.$emit('foiSalvoTag', this.tag);
                    this.item_carregado = true;
                });
            },
        }
    }
</script>