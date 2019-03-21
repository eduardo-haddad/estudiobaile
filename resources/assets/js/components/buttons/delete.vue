<template>
    <div :class="this.inline == 'true' ? 'btn btn_delete btn_inline' : 'btn btn_delete'">
        <div></div>
        <img :src="img" alt="remover" title="remover" />
        <!--<span>X</span>-->
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
            this.img = `${this.root}/img/btn_delete_magenta.png`;
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