<template>
    <div>

    </div>
</template>

<script>
    export default {
        name: 'dt-nascimento',
        props: ['value', 'dia'],
        data() {
            return {
                dia: this.dia,
                // mes: this.value,
                // ano: this.value,
            }
        },
        watch: {
            dia(val) { this.$emit('dia', val); },
            mes(val) { this.$emit('mes', val); },
            ano(val) { this.$emit('ano', val); },
        },
        mounted() {},
        methods: {}
    }
</script>