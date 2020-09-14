<template>
<div>
<form action="#" @submit.prevent="edit ? updateScadenza() : createScadenza()" method="post" accept-charset="utf-8">
  <div class="form-group row">
    <label class="col-md-3 text-change" for="cell">Titolo:</label>
    <div class="col-md-5">
      <input type="text" v-model="scadenza.titolo"  ref="taskinput" name="titolo" id="titolo" value=""  class="form-control" placeholder="Titolo">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-3 text-change" for="skype">Descrizione:</label>
    <div class="col-md-5">
      <textarea class="form-control" cols="25" rows="6" name="descrizione" id="descrizione" v-model="scadenza.descrizione" >descrizione</textarea>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-3 text-change" for="cell">Categoria:</label>
    <div class="col-md-5">
      <select name="categoria" id="categoria" class="form-control" v-model="scadenza.categoria">
        <option value="Info Alberghi">Info Alberghi</option>
        <option value="Milanomarittima.it">Milanomarittima.it</option>
      </select>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-3 text-change" for="cell">Riferimento:</label>
    <div class="col-md-5">
      <select name="commerciale_id" id="commerciale_id" class="form-control" v-model="scadenza.commerciale_id">
        <option value="0">Nessuno</option>
        <option v-for="(nome, id) in riferimenti" :id="id"> {{nome}} </option>
      </select>
    </div>
  </div>
  
  <div class="form-group row">
    <label class="col-md-3 text-change" for="data">Data:</label>
    <div class="col-md-3 col-xl-2 col-lg-2">
        <div class="input-group date">
            <input type="text" name="data" class="form-control" readonly v-model="scadenza.data" id="m_datepicker_3" />
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-3 text-change" for="cell">Priorita:</label>
    <div class="col-md-5">
      <select name="priorita" id="priorita" class="form-control" v-model="scadenza.priorita">
        <option value="Normale">Normale</option>
        <option value="Media">Media</option>
        <option value="Alta">Alta</option>
        <option value="Amministrazione">Amministrazione</option>
      </select>
    </div>
  </div>


  


  <button v-show="!edit" type="submit" class="btn btn-primary offset-md-3">Crea</button>
  <button v-show="edit" type="submit" class="btn btn-primary offset-md-3">Aggiorna</button>
</form>


<hr>


<ul id="filtro_scadenze">
  <li @click="listScadute()" class="btn btn-success" :class="{'btn btn-danger': method == 'listScadute'}">Scadute</li>
  <li @click="listNonScadute()" class="btn btn-success" :class="{'btn btn-danger': method == 'listNonScadute'}">Non scadute</li>
  <li @click="getScadenze()" class="btn btn-success" :class="{'btn btn-danger': method == 'getScadenze'}">Tutte</li>
  <li @click="listArchivio()"  class="btn btn-success" :class="{'btn btn-danger': method == 'listArchivio'}">Archivio</li>
</ul>
<hr>


<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco scadenze
      <br> 
      <strong class="h4">{{pagination.total}}</strong>
    </div>
  </div>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Data</th>
      <th scope="col">Titolo</th>
      <th scope="col">Categoria</th>
      <th scope="col">Riferimento</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <tr v-for='scadenza in scadenze.data' v-bind:key='scadenza.id'>
    <td>{{ scadenza.data }}</td>
    <td>{{ scadenza.titolo }}</td>
    <td>{{ scadenza.categoria }}</td>
    <td>{{ scadenza.riferimento }}</td>
    <td><button @click="loadScadenza(scadenza.id)" class="btn btn-primary btn-xs">Edit</button></td>
  </tr>
  </tbody>
</table>

<hr>

<ul class="pagination">
  
  <li class="page-item" :class="{disabled: pagination.current_page==1}">
    <a href="#" class="page-link"  @click.prevent="choiseMethod(method,`api/memorex/${endpoint}?page=1`)"><<</a>
  </li>

  <li class="page-item" :class="{disabled: !pagination.prev}">
    <a href="#" class="page-link" @click.prevent="choiseMethod(method,pagination.prev)">Previous</a>
  </li>

  <li class="page-item">
    <a class="page-link">Page {{pagination.current_page}} of {{pagination.last_page}}</a>
  </li>

  <li class="page-item" :class="{disabled: !pagination.next}">
    <a href="#" class="page-link"  @click.prevent="choiseMethod(method,pagination.next)">Next</a>
  </li>

  <li class="page-item" :class="{disabled: pagination.current_page == pagination.last_page}">
    <a href="#" class="page-link"  @click.prevent="choiseMethod(method,`api/memorex/${endpoint}?page=${pagination.last_page}`)">>></a>
  </li>

</ul>

</div>
</template>

<script>

    jQuery(document).ready(function(){

        $('#m_datepicker_3').datepicker({
            format: 'dd/mm/yyyy',
            clearBtn:true,
            todayBtn:'linked',
        });
    });


    export default {
        
          
        data() {

            return {
                pagination: {},
                scadenze: [],
                riferimenti:[],
                edit: false,
                method:'',
                endpoint:'',
                scadenza: {
                    id:'',
                    data: '',
                    titolo: '',
                    categoria: 'Info Alberghi',
                    priorita: 'Normale',
                    commerciale_id: 0,
                    descrizione: ''
                }
            }
        },

        mounted() {
             this.listScadute();
             this.getRiferimenti();
             this.method = 'listScadute';
        },


        methods: {


            choiseMethod(method,url) {
              this[method](url)
            },


            emptyScadenza() {
              this.scadenza.id = ''
              this.scadenza.titolo = ''
              this.scadenza.descrizione = ''
              this.scadenza.categoria = 'Info Alberghi'
              this.scadenza.priorita = 'Normale'
              this.scadenza.commerciale_id = 0
              this.scadenza.data = ''
            },

            getScadenze(url) {
                this.method = 'getScadenze'; 
                url = url || '/api/memorex';
                this.endpoint = '';

                axios.get(url)
                  .then(response => {
                    this.scadenze = response.data
                    this.makePagination(response.data.links, response.data.meta)
                  });


            },


            listScadute(url) {
                this.method = 'listScadute';
                url = url || '/api/memorex/scadute';
                this.endpoint = 'scadute';
                


                axios.get(url)
                  .then(response => {
                    this.scadenze = response.data
                    this.makePagination(response.data.links, response.data.meta)
                  });
            },

            listNonScadute(url) {
                this.method = 'listNonScadute';
                url = url || '/api/memorex/non-scadute';
                this.endpoint = 'non-scadute';


                axios.get(url)
                  .then(response => {
                    this.scadenze = response.data
                    this.makePagination(response.data.links, response.data.meta)
                  });
            },


            listArchivio(url) {
                this.method = 'listArchivio';
                url = url || '/api/memorex/archivio';
                this.endpoint = 'archivio';
                

                axios.get(url)
                  .then(response => {
                    this.scadenze = response.data
                    this.makePagination(response.data.links, response.data.meta)
                  });
            },


            makePagination(links, meta) {

                console.log('links.next = '+links.next);

                this.pagination.current_page = meta.current_page
                this.pagination.last_page = meta.last_page
                this.pagination.total = meta.total
                this.pagination.first = links.first
                this.pagination.next = links.next
                this.pagination.prev = links.prev
                this.pagination.last = links.last

            },

            getRiferimenti() {
                axios.get('/api/memorex/riferimenti')
                  .then(response => {
                    this.riferimenti = response.data;
                  });
            },

            createScadenza() {
              alert('submit');
            },

            loadScadenza: function(id) {
                  axios.get('api/memorex/' + id).
                  then(response => {
                    //console.log(response);
                    this.scadenza.id = response.data.id
                    this.scadenza.titolo = response.data.titolo
                    this.scadenza.categoria = response.data.categoria
                    this.scadenza.commerciale_id = response.data.riferimento
                    this.scadenza.descrizione = response.data.descrizione
                    this.scadenza.data = response.data.data
                });
                this.$refs.taskinput.focus();
                this.edit = true;
            },

            updateScadenza: function() {
                  axios.post('/api/memorex/' + this.scadenza.id, { // <== use axios.post
                          data: this.scadenza,
                          _method: 'patch'                   // <== add this field
                  })
                  .then(response => {
                        this.emptyScadenza();
                        this.edit = false;
                        this.listScadute();
                  });
            }

        } 

    }
</script>



<style>
  .pagination button {
    margin:0 10px;
  }
</style>
