<template v-if="nomes">
    <div class="lista_conteudo">
        <nav class="lista">
            <ul>
                <li v-for="nome_pf in nomes">
                    <a @click="linkPf(nome_pf.id)">{{ nome_pf.nome_adotado }}</a>
                </li>
            </ul>
        </nav>

        <div class="conteudo">
            <span>{{ this.pessoa.pessoa_fisica.id }}</span>
        </div>
    </div>

</template>

<script>
    export default {
        mounted() {
            axios.get(this.rota_prefixo + 'index').then(res => this.nomes = res.data);
        },
        data() {
            return {
                nomes: [],
                pessoa: {
                    pessoa_fisica: {
                        id: ''
                    }
                },
                rota_prefixo: '/admin/ajax/pf/',
            }
        },
        methods: {
            linkPf: function(pf_id) {
                axios.get(this.rota_prefixo + pf_id).then(res => this.pessoa = res.data);
                this.$router.push({
                    name: 'ajax-pf-view',
                    params: { id: pf_id }
                });

            }
        },
    }
</script>