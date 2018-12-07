<template>

    <div class="detalhe" :class="{ loading: !item_carregado, loaded: item_carregado }" style="width: 100%; border-left: 1px solid #babcbd;">

        <div id="container_conteudo" class="formulario">

            <div class="titulo">
                <div class="nome" style="padding-left: 0;">
                <span>Estúdio Baile - Interna</span>
                </div>
            </div>

            <br><br><br>

            <div class="valor">
                <span class="campo">Campo 1</span>
                <input autocomplete="off" type="text"
                       v-model="interna.campo1"
                       name="passaporte"
                />
            </div><br>

            <div class="valor">
                <span class="campo">Campo 2</span>
                <input autocomplete="off" type="text"
                       v-model="interna.campo2"
                       name="passaporte"
                />
            </div><br>

            <button @click.prevent="salvaForm">Salvar</button>
        </div>
    </div>



</template>

<script>

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
        },
        mounted() {
            //highlight menu
            this.highlight_menu();
        },
        data() {
            return {
                //Models
                interna: {campo1: '', campo2: ''},
                //Campos de inclusão
                root: '',
                //Condicionais
                item_carregado: true,
            }
        },
        watch: {
            '$route' (destino) {
            },
        },
        computed: {},
        methods: {
            getInterna: function(){
                console.log('interna');
            },
            salvaForm: function(){
                axios.post('/admin/ajax/tags/save', {
                    tag: this.tag,
                }).then(res => {
                    this.tag = res.data;
                    eventBus.$emit('foiSalvoTag', this.tag);
                });
            },
            highlight_menu: () => {
                const menu = document.getElementById('menu_principal');
                let items = menu.getElementsByTagName('li');
                let url = window.location.href.split('/admin#/')[1];
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