<template>
    <!--<img :src="img" alt="adicionar" title="adicionar" />-->
    <span>[+]</span>
</template>

<script>
    import { eventBus } from '../../estudiobaile';
    export default {
        props: [],
        created() {
            //basepath
            this.root = ROOT;
            //imagem
            this.img = `${this.root}/img/btn_add_form2.png`;
        },
        data() {
            return {
                root: '',
                img: '',
            }
        },
        methods: {
            // salvar: function() {
            //     eventBus.$emit('editbar-salvar');
            // },
        }
    }

</script>