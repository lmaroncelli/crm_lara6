<template>
<div>
<form action="#" @submit.prevent="createScadenza()" method="post" accept-charset="utf-8">
  <div class="form-group row">
    <label class="col-md-2 text-change" for="cell">Titolo:</label>
    <div class="col-md-3">
      <input type="text" v-model="scadenza.titolo" name="titolo" id="titolo" value=""  class="form-control" placeholder="Titolo">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-2 text-change" for="skype">Descrizione:</label>
    <div class="col-md-3">
      <textarea class="form-control" name="descrizione" id="descrizione" v-model="scadenza.descrizione" >descrizione</textarea>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Crea</button>
</form>
<hr>
<table class="table">

  <tr v-for='scadenza in scadenze.data' v-bind:key='scadenza.id'>
    <td>{{ scadenza.data }}</td>
    <td>{{ scadenza.titolo }}</td>
    <td>{{ scadenza.categoria }}</td>
    <td>{{ scadenza.riferimento }}</td>
    <td><button @click="loadScadenza(scadenza.id)" class="btn btn-primary btn-xs">Edit</button></td>
  </tr>

</table> 
</div>
</template>

<script>


    export default {
        
          
        data() {

            return {
                scadenze: [],
                edit: false,
                scadenza: {
                    id:'',
                    data: '',
                    titolo: '',
                    categoria: '',
                    riferimento: '',
                    descrizione: ''
                }
            }
        },

        mounted() {
             this.getScadenze();
        },


        methods: {

            getScadenze() {
                axios.get('/api/memorex')
                  .then(response => {
                    this.scadenze = response.data;
                  });
            },

            createScadenza() {
              alert('submit');
            },

            loadScadenza: function(id) {
                  axios.get('api/memorex/' + id).
                  then(response => {
                    this.scadenza.id = response.id
                    this.scadenza.titolo = response.titolo
                    this.scadenza.categoria = response.categoria
                    this.scadenza.riferimento = response.riferimento
                    this.scadenza.descrizione = response.descrizione
                });
                this.edit = true
            },
        } 




    }
</script>
