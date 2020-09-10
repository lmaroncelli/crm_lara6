<template>
<table class="table">

  <tr v-for='scadenza in scadenze' v-bind:key='scadenza.id'>
    <td>{{ scadenza.data }}</td>
    <td>{{ scadenza.titolo }}</td>
    <td>{{ scadenza.categoria }}</td>
    <td>{{ scadenza.riferimento }}</td>
  </tr>

</table> 
</template>

<script>


    export default {
        props: ['scadenze'],
        
      /*  data() {

            return {
                scadenze: []
            }
        },
*/
        mounted() {
             this.getScadenze();
        },


        methods: {

            getScadenze() {
                axios.get('/api/memorex')
                  .then(response => {
                    this.scadenze = response.data;
                  });
            }
        } 




    }
</script>
