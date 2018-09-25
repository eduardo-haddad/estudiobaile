<template v-if="this.pessoa">

    <div id="container_conteudo" class="formulario">

        <div class="titulo">{{ this.pessoa.nome_adotado }}</div>

        <hr>

        <div class="resumo">

            <!--DADOS GERAIS-->
            <h2 class="nome_grupo">Dados Gerais <div class="editar"><a href="#">Editar</a></div></h2>

            <form @submit.prevent="salvaForm" method="POST">

                <span class="campo">Nome</span>
                <div class="valor">
                    <input autocomplete="off" type="text"
                       v-model="pessoa.nome"
                       name="nome"
                    />
                </div><br>

                <span class="campo">Nome adotado</span>
                <div class="valor">
                    <input autocomplete="off" type="text"
                           v-model="pessoa.nome_adotado"
                           name="nome_adotado"
                    />
                </div><br>

                <span class="campo">Gênero</span>
                <div class="valor">
                    <select name="genero" v-model="pessoa.genero_id">
                        <option v-for="genero in atributos.generos" :value="genero.id">
                            {{ genero.valor == 'F' ? 'Feminino' : 'Masculino' }}
                        </option>
                    </select>
                </div><br>

                <span class="campo">Estado civil</span>
                <div class="valor">
                    <select name="estado_civil" v-model="pessoa.estado_civil_id">
                        <option v-for="estado_civil in atributos.estados_civis" :value="estado_civil.id">
                            {{ estado_civil.valor }}
                        </option>
                    </select>
                </div><br>

                <span class="campo">Data de nascimento</span>
                <div class="valor">
                    <input autocomplete="off" type="text"
                           v-model="pessoa.dt_nascimento"
                           name="dt_nascimento"
                    />
                </div><br>

                <span class="campo">Nacionalidade</span>
                <div class="valor">
                    <input autocomplete="off" type="text"
                           v-model="pessoa.nacionalidade"
                           name="nacionalidade"
                    />
                </div><br>

                <span class="campo">Naturalidade</span>
                <div class="valor">
                    <input autocomplete="off" type="text"
                           v-model="pessoa.naturalidade"
                           name="naturalidade"
                    />
                </div><br>

                <!-- DOCUMENTOS -->
                <h2 class="nome_grupo">Documentos <div class="editar"><a href="#">Editar</a></div></h2>

                <span class="campo">RG</span>
                <div class="valor">
                    <input autocomplete="off" type="text"
                           v-model="pessoa.rg"
                           name="rg"
                    />
                </div><br>

                <span class="campo">CPF</span>
                <div class="valor">
                    <input autocomplete="off" type="text"
                           v-model="pessoa.cpf"
                           name="cpf"
                    />
                </div><br>

                <span class="campo">Passaporte</span>
                <div class="valor">
                    <input autocomplete="off" type="text"
                           v-model="pessoa.passaporte"
                           name="passaporte"
                    />
                </div><br>

                <h2 class="nome_grupo">Contatos <div class="editar"><a href="#">Adicionar</a></div></h2>


                <div>
                        <div v-for="email in emails" class="valor">
                            <span class="campo">{{ email.tipo }}</span>
                            <input type="text" :id="email.id" v-model="email.valor" name="email" />
                            <a @click.prevent="removeContato(email.id)">X</a>
                        </div>
                    <!--<span class="campo">adicionar email:</span>-->
                    <br style="clear: both;"><br><br>
                    <input @input="novo_contato = $event.target.value" type="text" class="adiciona_contato" v-model="novo_email" placeholder="adicionar email" />
                    <a @click.prevent="adicionaContato()">+email</a>

                </div>

                <div>
                        <div v-for="telefone in telefones" class="valor">
                            <span class="campo">{{ telefone.tipo }}</span>
                            <input type="text" :id="telefone.id" v-model="telefone.valor" name="telefone" />
                            <a @click.prevent="removeContato(telefone.id)">X</a>
                        </div>
                    <!--<span class="campo">adicionar email:</span>-->
                    <br style="clear: both;"><br><br>
                    <input @input="novo_contato = $event.target.value" type="text" class="adiciona_contato" v-model="novo_telefone" placeholder="adicionar telefone" />
                    <a @click.prevent="adicionaContato">+telefone</a>

                </div>

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
          },
        watch: {
            '$route' (destino) {
                this.getPessoa(destino.params.id);
            }
        },
        data() {
            return {
                novo_email: '',
                novo_telefone: '',
                pessoa: {},
                contatos: [],
                atributos: [],
                estados_civis: {},
                generos: {},
            }
        },
        computed: {
            emails: function() {
                return this.contatos.filter(function(x){
                    return x.tipo == "e-mail";
                });
            },
            telefones: function() {
                return this.contatos.filter(function(x){
                    return x.tipo == "telefone";
                });
            }
        },
        methods: {
            getPessoa: function(id){
                axios.get('/admin/ajax/pf/' + id).then(res => {
                    let dados = res.data;
                    this.pessoa = dados.pessoa_fisica;
                    this.pessoa.genero = dados.genero;
                    this.pessoa.estado_civil = dados.estado_civil;
                    this.contatos = dados.contatos;
                    this.atributos = dados.atributos;
                    console.log(dados);
                } );
            },
            salvaForm: function(){
                axios.post('/admin/ajax/pf/save', {
                    pessoa: this.pessoa,
                    contatos: this.contatos
                }).then(res => {
                    this.pessoa = res.data;
                    eventBus.$emit('foiSalvo', this.pessoa);
                });
            },
            adicionaContato: function(){
                axios.post('/admin/ajax/pf/addContato', {
                    pessoa_id: this.$route.params.id,
                    email: this.novo_email,
                    telefone: this.novo_telefone
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.contatos = res.data;
                    }
                    this.novo_email = '';
                    this.novo_telefone = '';
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
        }
    }
</script>