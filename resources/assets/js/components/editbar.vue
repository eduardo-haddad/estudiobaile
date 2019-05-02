<template>
    <div class="editbar">
        <div class="salvar">
            <a v-if="this.edit === true" @click.prevent="editar">Editar</a>
            <a v-if="this.edit === false" @click.prevent="salvar">Salvar</a>
        </div>
        <div class="exportar">
                <a v-if="this.export == 'true'" :href="link" download>
                    <!-- magenta -->
                    <!--<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ2MS44MzMgNDYxLjgzMyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDYxLjgzMyA0NjEuODMzOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTQ0Miw0NDQuODMzVjE0NC4yMTdjMC00LjgxNy0xLjk4My05LjM1LTUuMzgzLTEyLjQ2N0wyOTkuNzY3LDQuNTMzQzI5Ni42NSwxLjcsMjkyLjQsMCwyODguMTUsMEg3Ni41ICAgIGMtOS4zNSwwLTE3LDcuNjUtMTcsMTd2MTg5LjgzM2MwLDkuMzUsNy42NSwxNywxNywxN3MxNy03LjY1LDE3LTE3VjM0aDE3Mi44MzN2MTMwLjMzM2MwLDkuMzUsNy42NSwxNywxNywxN2gxMjEuODMzICAgIGMwLjg1LDAsMS45ODMsMCwyLjgzMy0wLjI4M3YyNDYuNzgzSDkzLjV2LTY4YzAtOS4zNS03LjY1LTE3LTE3LTE3cy0xNyw3LjY1LTE3LDE3djg1YzAsOS4zNSw3LjY1LDE3LDE3LDE3SDQyNSAgICBDNDM0LjM1LDQ2MS44MzMsNDQyLDQ1NC4xODMsNDQyLDQ0NC44MzN6IE0zMDAuMzMzLDUxLjU2N2wxMDIuODUsOTUuNzY3aC0xMDIuODVWNTEuNTY3eiIgZmlsbD0iI2VkMjQ4NyIvPgoJCTxwYXRoIGQ9Ik0xOS44MzMsMjgwLjVjMCw5LjM1LDcuNjUsMTcsMTcsMTdoMTc3LjA4M2wtNTQuNjgzLDQ4LjczM2MtNy4wODMsNi4yMzMtNy42NSwxNy0xLjQxNywyNC4wODMgICAgYzMuNCwzLjY4Myw3LjkzMyw1LjY2NywxMi43NSw1LjY2N2MzLjk2NywwLDcuOTMzLTEuNDE3LDExLjMzMy00LjI1bDg4LjQtNzguNzY3YzMuNjgzLTMuMTE3LDUuNjY3LTcuOTMzLDUuNjY3LTEyLjc1ICAgIHMtMS45ODMtOS4zNS01LjY2Ny0xMi43NUwxODEuOSwxODguN2MtNy4wODMtNi4yMzMtMTcuODUtNS42NjctMjQuMDgzLDEuNDE3Yy02LjIzMyw3LjA4My01LjY2NywxNy44NSwxLjQxNywyNC4wODNsNTUuNTMzLDQ5LjMgICAgSDM2LjgzM0MyNy40ODMsMjYzLjUsMTkuODMzLDI3MS4xNSwxOS44MzMsMjgwLjV6IiBmaWxsPSIjZWQyNDg3Ii8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />-->
                    <!-- cinza -->
                    <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ2MS44MzMgNDYxLjgzMyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDYxLjgzMyA0NjEuODMzOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTQ0Miw0NDQuODMzVjE0NC4yMTdjMC00LjgxNy0xLjk4My05LjM1LTUuMzgzLTEyLjQ2N0wyOTkuNzY3LDQuNTMzQzI5Ni42NSwxLjcsMjkyLjQsMCwyODguMTUsMEg3Ni41ICAgIGMtOS4zNSwwLTE3LDcuNjUtMTcsMTd2MTg5LjgzM2MwLDkuMzUsNy42NSwxNywxNywxN3MxNy03LjY1LDE3LTE3VjM0aDE3Mi44MzN2MTMwLjMzM2MwLDkuMzUsNy42NSwxNywxNywxN2gxMjEuODMzICAgIGMwLjg1LDAsMS45ODMsMCwyLjgzMy0wLjI4M3YyNDYuNzgzSDkzLjV2LTY4YzAtOS4zNS03LjY1LTE3LTE3LTE3cy0xNyw3LjY1LTE3LDE3djg1YzAsOS4zNSw3LjY1LDE3LDE3LDE3SDQyNSAgICBDNDM0LjM1LDQ2MS44MzMsNDQyLDQ1NC4xODMsNDQyLDQ0NC44MzN6IE0zMDAuMzMzLDUxLjU2N2wxMDIuODUsOTUuNzY3aC0xMDIuODVWNTEuNTY3eiIgZmlsbD0iIzU4NTk1YiIvPgoJCTxwYXRoIGQ9Ik0xOS44MzMsMjgwLjVjMCw5LjM1LDcuNjUsMTcsMTcsMTdoMTc3LjA4M2wtNTQuNjgzLDQ4LjczM2MtNy4wODMsNi4yMzMtNy42NSwxNy0xLjQxNywyNC4wODMgICAgYzMuNCwzLjY4Myw3LjkzMyw1LjY2NywxMi43NSw1LjY2N2MzLjk2NywwLDcuOTMzLTEuNDE3LDExLjMzMy00LjI1bDg4LjQtNzguNzY3YzMuNjgzLTMuMTE3LDUuNjY3LTcuOTMzLDUuNjY3LTEyLjc1ICAgIHMtMS45ODMtOS4zNS01LjY2Ny0xMi43NUwxODEuOSwxODguN2MtNy4wODMtNi4yMzMtMTcuODUtNS42NjctMjQuMDgzLDEuNDE3Yy02LjIzMyw3LjA4My01LjY2NywxNy44NSwxLjQxNywyNC4wODNsNTUuNTMzLDQ5LjMgICAgSDM2LjgzM0MyNy40ODMsMjYzLjUsMTkuODMzLDI3MS4xNSwxOS44MzMsMjgwLjV6IiBmaWxsPSIjNTg1OTViIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />
                    Exportar
                </a>
            <a v-if="this.delete == 'true'" @click.prevent="excluir">Excluir</a>
        </div>
    </div>
</template>

<script>
    import { eventBus } from '../estudiobaile';
    export default {
        props: ['save', 'export', 'delete', 'link', 'edit', 'origin'],
        data() {
            return {
                origin_data: '',
            }
        },
        mounted() {
            this.setOrigin(this.origin);
        },
        methods: {
            salvar: function() {
                eventBus.$emit('editbar-salvar-'+this.origin_data);
            },
            exportar: function() {
                eventBus.$emit('editbar-exportar-'+this.origin_data);
            },
            excluir: function() {
                eventBus.$emit('editbar-excluir-'+this.origin_data);
            },
            editar: function() {
                eventBus.$emit('editbar-editar-'+this.origin_data);
            },
            setOrigin: function(origin) {
                this.origin_data = origin;
            }
        }
    }

</script>