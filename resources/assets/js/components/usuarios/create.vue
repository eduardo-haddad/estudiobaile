<template>

    <div id="container_conteudo" class="formulario">

        <div class="titulo">
            <div class="imagem_destaque">
                <img :src="imagem_destaque" />
            </div>
            <div class="nome">
                <span>Novo usuário</span>
            </div>
        </div>
        <br>
        <br>
        <br>



        <!--DADOS GERAIS-->

        <!-- Função -->
        <div class="valor">
            <span class="campo">Função</span>
            <select name="funcao" @change="funcao_id = $event.target.value">
                <option v-for="funcao in funcoes" :value="funcao.id" :key="funcao.id">
                    {{ funcao.name }}
                </option>
            </select>
        </div><br>

        <div class="valor">
            <span class="campo">Nome</span>
            <input autocomplete="off" type="text"
                   name="usuario.name"
                   @input="name = $event.target.value"
            />
        </div>
        <br>
        <div class="valor">
            <span class="campo">Usuário</span>
            <input autocomplete="off" type="text"
                   name="usuario.username"
                   @input="username = $event.target.value"
            />
        </div>
        <br>
        <div class="valor">
            <span class="campo">Senha</span>
            <input autocomplete="off" type="password"
                   name="usuario.password"
                   @input="password = $event.target.value"
            />
        </div>
        <br>
        <br>
        <br>
        <button @click.prevent="criar(funcao_id, name, username, password)">Salvar</button>

    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';

    export default {
        mounted() {
            //imagem
            this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
            //funções
            this.getFuncoes();
        },
        beforeUpdate() {
            //carregado
            eventBus.$emit('usuarioCreate');
        },
        data() {
            return {
                root: ROOT,
                imagem_destaque: '',
                name: '',
                username: '',
                password: '',
                funcao_id: '1',
                funcoes: [],
            }
        },
        watch: {},
        computed: {},
        methods: {
            getFuncoes: function() {
                axios.get('/ajax/usuarios/funcoes').then(res => {
                    console.log(`funcoes: ${res.data}`);
                    this.funcoes = res.data;
                });
            },
            criar: function(funcao_id, nome, usuario, senha) {
                console.log(`funcao_id: ${funcao_id} / typeof funcao_id: ${typeof funcao_id}`);
                axios.post('/ajax/usuarios/create', {
                    role: funcao_id,
                    name: nome,
                    username: usuario,
                    password: senha,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.$router.push({ name: 'usuarios-view', params: { id: res.data }});
                    } else
                        console.log('Erro ao criar usuário');
                });
            }
        }
    }
</script>