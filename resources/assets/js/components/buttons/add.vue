<template>
    <div :class="this.inline == 'true' ? 'btn btn_inline' : 'btn'">
        <div></div>
        <img :src="img" alt="adicionar" title="adicionar" />
        <!--<span>[+]</span>-->
    </div>
</template>

<script>
    import { eventBus } from '../../estudiobaile';
    export default {
        props: ['inline'],
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