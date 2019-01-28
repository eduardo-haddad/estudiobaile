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
                            <p><a @click.prevent="navegar('projetos')">Projeto</a></p>
                            <p><a @click.prevent="navegar('pf')">Pessoa Física</a></p>
                            <p><a @click.prevent="navegar('pj')">Pessoa Jurídica</a></p>
                            <hr />
                            <p><a @click.prevent="navegar('usuarios')">Usuário</a></p>

                        </slot>
                    </div>

                    <!--<div class="modal-footer">-->
                        <!--<slot name="footer">-->
                            <!--<button class="modal-default-button" >-->
                                <!--Cancelar-->
                            <!--</button>-->
                        <!--</slot>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
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
            navegar: function(tipo) {
                this.$router.push({ name: `${tipo}-create`});
                this.$emit('close');
            }
        }
    }
</script>
