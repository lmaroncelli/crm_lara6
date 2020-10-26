<template>
    <a haref="#" @click.prevent="load()">{{nome_prodotto}}</a>
</template>

<script>
    export default {
        props: ['servizio_id', 'nome_prodotto'],

        methods: {
            load() {
                this.$root.$refs.formServizioClienteComponent.loadServizio(this.servizio_id);
            }
        },
    }
</script>
