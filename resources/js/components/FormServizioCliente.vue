<template>
  <div>
    <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
    <form id="servizio-cliente" action="#" @submit.prevent="edit ? updateServizio() : createServizio()" method="post" accept-charset="utf-8">
        
        <div class="form-group row">
          <label class="col-md-1 text-change" for="prodotto_id">Prodotto:</label>
          <div class="col-md-5">
            <select name="prodotto_id" class="form-control" v-model="servizio.prodotto_id">
              <option value="0">Nessuno</option>
              <option v-for="(nome, id) in prodotti" :value="id"> {{nome}} </option>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-1 text-change" for="data">Data Inizio:</label>
          <div class="col-md-3 col-xl-2 col-lg-2">
            <div style="display:flex">
            <date-picker 
            v-model='servizio.data_inizio'
            color="blue"
            locale="it"
            :first-day-of-week="2"
            :attributes='date_inzio_attrs'
            />
            <span class="input-group-text">
                <i class="fa fa-calendar"></i>
            </span>
            </div>
          </div>

          <label class="col-md-1 text-change" for="data">Data Fine:</label>
          <div class="col-md-3 col-xl-2 col-lg-2">
            <div style="display:flex">
            <date-picker 
            v-model='servizio.data_fine'
            color="red"
            locale="it"
            :first-day-of-week="2"
            :attributes='date_fine_attrs'
            />
            <span class="input-group-text">
                <i class="fa fa-calendar"></i>
            </span>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-1 text-change" for="note">note:</label>
          <div class="col-md-5">
            <textarea class="form-control" cols="25" rows="6" name="note" id="note" v-model="servizio.note"></textarea>
          </div>
          <label class="col-md-1 text-change" for="note_commerciale">note commerciale:</label>
          <div class="col-md-5">
            <textarea class="form-control" cols="25" rows="6" name="note_commerciale" id="note_commerciale" v-model="servizio.note_commerciale"></textarea>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-2 text-change" for="archivia" style="text-align:center !important">Archivia alla scadenza </label>
          <div class="col-md-3">
            <input type="checkbox" class="form-check-input text-change" style="margin-top:1em;" id="archivia" v-model="servizio.archiviato">
          </div>
        </div>

        <button v-show="!edit" type="submit" class="btn btn-primary offset-md-3">Crea</button>
        <button v-show="edit" type="submit" class="btn btn-primary offset-md-3">Aggiorna</button>
        <button type="button" class="btn btn-secondary" @click="cancel()">Cancel</button>

    </form>
  </div>
</template>




<script>
import ValidationErrors from "./ValidationErrors";

export default {
  
  components: {
        ValidationErrors
    },

  props: ['cliente_id'],

  data() {
    return {
      validationErrors:'',
      date_inzio_attrs: [
            {
              key: 'today',
              highlight: 'red',
              dates: new Date(),
            },
      ],

      date_fine_attrs: [
            {
              key: 'today',
              highlight: 'blue',
              dates: new Date(),
            },
      ],
      edit:false,
      prodotti:[],
      servizio: {
        cliente_id: this.cliente_id,
        prodotto_id:null,
        data_inizio:null,
        data_fine:null,
        archiviato:false,
        note:'',
      }
    }
  },

  mounted() {
      this.getProdotti();
  },


  methods: {


      formatData(data) {
        if(data !== null)
          return data.toLocaleDateString('it-IT',{day:"2-digit",month:"2-digit", year:"numeric"});
        else
          return data;
      },


      getProdotti() {
          axios.get('/api/clienti-servizi/prodotti')
            .then(response => {
              this.prodotti = response.data;
            });
      },

      updateServizio() {

      },

      createServizio() {
          
          axios.post('/api/clienti-servizi/store', { // <== use axios.post
                        cliente_id: this.servizio.cliente_id,
                        prodotto_id:this.servizio.prodotto_id,
                        data_inizio:this.formatData(this.servizio.data_inizio),
                        data_fine:this.formatData(this.servizio.data_fine),
                        archiviato:this.servizio.archiviato,
                        note:this.servizio.note,
                })
                .then(response => {
                    // reload page??
                    alert('Inserimemto corretto');
                    //location.reload(); 
                })
                .catch(error => {
                  console.log(error.response.data.errors);
                  this.validationErrors = error.response.data.errors;
                })
                .finally(() => {
                      // ricarico la pagina corrente
                      
                });

      } // end createServizio()
  },

}
</script>

<style>

form#servizio-cliente {
    background-color: #fdfdfd;
    padding: 20px 10px;
}

</style>