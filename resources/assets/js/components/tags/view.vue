<template v-if="this.tag">

    <div id="container_conteudo" class="formulario">

        <div class="titulo">
            <div class="nome" style="padding-left: 0;">
                <span><input autocomplete="off" type="text"
                             v-if="tag.text"
                             v-model="tag.text"
                             name="nome_adotado" style="border:none" /></span>
            </div>
        </div>

        <!--DADOS GERAIS-->
        <form @submit.prevent="salvaForm" method="POST">
            <button>Salvar</button>
        </form>

        <hr>

        <!-- Pessoas Físicas relacionadas -->
        <div class="valor" style="margin-top: 3px;">
            <span class="campo">Pessoas físicas relacionadas</span>
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
            <span class="campo">Pessoas jurídicas relacionadas</span>
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

</template>

<script>

    import { eventBus } from '../../estudiobaile';

    export default {
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
                tag: {},
                tags: [],
                pessoas_fisicas_relacionadas: [],
                pessoas_juridicas_relacionadas: [],
                //Campos de inclusão
                root: '',
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
                axios.get('/ajax/tags/' + id).then(res => {
                    eventBus.$emit('getTag', this.$route.params.id);
                    this.tag = res.data['tag'];
                    this.pessoas_fisicas_relacionadas = res.data['pessoas_fisicas_relacionadas'];
                    this.pessoas_juridicas_relacionadas = res.data['pessoas_juridicas_relacionadas'];
                } );
            },
            removeTag: function(pessoa_id, tipo){
                axios.post('/ajax/tags/ajaxRemoveTag/' + this.tag.id, {
                    pessoa_id: pessoa_id,
                    pessoa_tipo: tipo
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.tags = res.data;
                        eventBus.$emit('tagRemovida', this.tags);
                        this.$router.push({ name: "tags-index"});
                    }
                    this.getTag(this.tag.id);
                });
            },
            salvaForm: function(){
                axios.post('/ajax/tags/save', {
                    tag: this.tag,
                }).then(res => {
                    this.tag = res.data;
                    eventBus.$emit('foiSalvoTag', this.tag);
                });
            },
        }
    }
</script>