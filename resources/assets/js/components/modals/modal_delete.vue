<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-close-container">
                        <div class="modal-close"><a @click.prevent="$emit('close')">x</a></div>
                    </div>

                    <div class="modal-header">
                        <slot name="header"></slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            <p>Esta ação é permanente!</p>
                            <p>Aviso: todos os arquivos anexos serão excluídos</p>
                        </slot>
                    </div>

                    <div class="modal-footer">
                    <slot name="footer">
                        <a @click.prevent="excluir">excluir</a>
                    </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import { eventBus } from '../../estudiobaile';
    export default {
        mounted() {
            this.isAdmin = ISADMIN;
        },
        data() {
            return {
                isAdmin: '',
            }
        },
        methods: {
            excluir: function() {
                let url = window.location.href;
                let tipo = '';

                if(url.indexOf('/projetos/view/') !== -1) tipo = 'projeto';
                if(url.indexOf('/pf/view/') !== -1) tipo = 'pf';
                if(url.indexOf('/pj/view/') !== -1) tipo = 'pj';

                eventBus.$emit('excluir-'+tipo);
                this.$emit('close');
            }
        }
    }
</script>
