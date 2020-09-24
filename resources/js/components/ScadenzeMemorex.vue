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
      <select name="commerciale_id" class="form-control" v-model="scadenza.commerciale_id">
        <option value="0">Nessuno</option>
        <option v-for="(nome, id) in riferimenti" :value="id"> {{nome}} </option>
      </select>
    </div>
  </div>


  <div class="form-group row">
    <label class="col-md-3 text-change" for="data">Data:</label>
    <div class="col-md-3 col-xl-2 col-lg-2">
      <div style="display:flex">
      <date-picker 
      v-model='scadenza.data'
      color="blue"
      locale="it"
      :first-day-of-week="2"
      :attributes='date_attrs'
      />
      <span class="input-group-text">
          <i class="fa fa-calendar"></i>
      </span>
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
  <button type="button" class="btn btn-secondary" @click="cancel()">Cancel</button>

</form>


<hr>


<ul id="filtro_scadenze">
  <li @click="listScadute()" class="btn btn-success" :class="{'btn btn-danger': method == 'listScadute'}">Scadute</li>
  <li @click="listNonScadute()" class="btn btn-success" :class="{'btn btn-danger': method == 'listNonScadute'}">Non scadute</li>
  <li @click="getScadenze()" class="btn btn-success" :class="{'btn btn-danger': method == 'getScadenze'}">Tutte</li>
  <li @click="listArchivio()"  class="btn btn-success" :class="{'btn btn-danger': method == 'listArchivio'}">Archivio</li>
</ul>
<hr>


<pagination-memorex 
  v-show="pagination_ready"
  :method="method" 
  :pagination="pagination" 
  :endpoint="endpoint" 
  v-on:choice="choiceMethod">    
</pagination-memorex>

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco scadenze
      <br> 
      <strong class="h4">{{pagination.total}}</strong>
    </div>
  </div>
  <div class="col-sm-8 filtra">
    <input type="text" class="form-control" v-model="search" name="search" id="search" placeholder="Cerca nel titolo" @keyup.enter="filter()">
  </div>
  <div class="col-sm-2 filtra">
    <a class="btn btn-primary" href="#" role="button" @click.prevent="filter()">Cerca</a>
  </div>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col"><a href="#" @click.prevent="orderColumn('priorita')">Priorita <i v-if="this.order_by == 'priorita'" :class="{'fas fa-sort-amount-up-alt' : this.order == 'desc'}"></i> <i v-if="this.order_by == 'priorita'" :class="{'fas fa-sort-amount-down-alt' : this.order == 'asc'}"></i></a></th>
      <th scope="col"><a href="#" @click.prevent="orderColumn('data')">Data <i v-if="this.order_by == 'data'" :class="{'fas fa-sort-amount-up-alt' : this.order == 'desc'}"></i> <i v-if="this.order_by == 'data'" :class="{'fas fa-sort-amount-down-alt' : this.order == 'asc'}"></i></a></th>
      <th scope="col"><a href="#" @click.prevent="orderColumn('titolo')">Titolo <i v-if="this.order_by == 'titolo'" :class="{'fas fa-sort-amount-up-alt' : this.order == 'desc'}"></i> <i v-if="this.order_by == 'titolo'" :class="{'fas fa-sort-amount-down-alt' : this.order == 'asc'}"></i></a></th>
      <th scope="col"><a href="#" @click.prevent="orderColumn('categoria')">Categoria <i v-if="this.order_by == 'categoria'" :class="{'fas fa-sort-amount-up-alt' : this.order == 'desc'}"></i> <i v-if="this.order_by == 'categoria'" :class="{'fas fa-sort-amount-down-alt' : this.order == 'asc'}"></i></a></th>
      <th scope="col"><a href="#" @click.prevent="orderColumn('riferimento')">Riferimento <i v-if="this.order_by == 'riferimento'" :class="{'fas fa-sort-amount-up-alt' : this.order == 'desc'}"></i> <i v-if="this.order_by == 'riferimento'" :class="{'fas fa-sort-amount-down-alt' : this.order == 'asc'}"></i></a></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <tr v-for='scadenza in scadenze.data' v-bind:key='scadenza.id' :id="scadenza.id">
    <td><i :class="'fa fa-tag '+scadenza.priorita"></i></td>
    <td>{{ scadenza.data }}</td>
    <td>{{ scadenza.titolo }}</td>
    <td>{{ scadenza.categoria }}</td>
    <td>{{ scadenza.riferimento }}</td>
    <td><button @click="loadScadenza(scadenza.id)" :id="'button_edit_row_' + scadenza.id" class="btn btn-primary btn-xs edit-btn">Edit</button></td>
    <td><button @click="delScadenza(scadenza.id)" :id="'button_del_row_' + scadenza.id" class="btn btn-danger btn-xs edit-btn">Delete</button></td>
  </tr>
  </tbody>
</table>

<hr>


<pagination-memorex 
  v-show="pagination_ready"
  :method="method" 
  :pagination="pagination" 
  :endpoint="endpoint" 
  v-on:choice="choiceMethod">    
</pagination-memorex>

</div>
</template>

<script>
    

    import PaginationMemorex from "./PaginationMemorex";

    export default {
        
        components: {
            PaginationMemorex
        },
          
        data() {

            return {
                date_attrs: [
                  {
                    key: 'today',
                    highlight: 'red',
                    dates: new Date(),
                  },
                ],
                search:'',
                pagination: {
                  current_page: '',
                  last_page: '',
                  total: '',
                  first: '',
                  next: '',
                  prev: '',
                  last: ''
                },
                scadenze: [],
                riferimenti:[],
                edit: false,
                pagination_ready:false,
                editing_row:false,
                url:'',
                uri:'',
                from_pagination: 0,
                method:'',
                endpoint:'',
                order_by:'id',
                order:'desc',
                column:'',
                scadenza: {
                    id:'',
                    data: null,
                    titolo: '',
                    categoria: 'Info Alberghi',
                    priorita: 'Normale',
                    commerciale_id: 0,
                    descrizione: ''
                }
            }
        },


        computed: {
          
          formattedData: {

            // getter
            get: function () {
              if(this.scadenza.data !== null)
                return this.scadenza.data.toLocaleDateString('it-IT',{day:"2-digit",month:"2-digit", year:"numeric"});
              else
                return this.scadenza.data;
            }

            
          }
        
        },
        


        mounted() {
            this.listScadute();
            this.getRiferimenti();
        },


        methods: {

    
            choiceMethod(...args) {
              let [method,url, from_pagination] = args;
              
              if(from_pagination !== undefined)
                {
                this.from_pagination = 1;
                }
              

              this[method](url)

            },

            choiceMethodOrder(...args) {

              let [method,url,order_by, order] = args;

              if(order_by === undefined)
                {
                order_by = this.order_by;
                }

              if(order === undefined)
                {
                order = this.order;
                }
              
              console.log(method,url,order_by, order);

              this[method](url, order_by, order)

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

            getScadenze(url, order_by, order) {
                console.log(url,order_by, order);
                this.method = 'getScadenze'; 

                if(order_by !== undefined)
                  {
                  this.order_by = order_by;
                  }
                
                if(order !== undefined)
                  {
                  this.order = order;
                  }

                this.endpoint = '';

                this.uri ='/api/memorex/';

                this.url = url || this.uri;
                
                let url_to_call = this.url;

                if(!this.from_pagination) {
                  url_to_call = url_to_call + this.order_by + '/' + this.order;
                }

                axios.get(url_to_call)
                  .then(response => {
                    this.scadenze = response.data
                    this.makePagination(response.data.links, response.data.meta)
                    this.pagination_ready = true
                  });

                this.search = '';


            },


            listScadute(url,order_by, order) {
                console.log(url,order_by, order);
                this.method = 'listScadute';
                
                if(order_by !== undefined)
                  {
                  this.order_by = order_by;
                  }
                
                if(order !== undefined)
                  {
                  this.order = order;
                  }
                
                this.endpoint = 'scadute';

                this.uri = '/api/memorex/scadute/';

                this.url = url || this.uri;
                
                let url_to_call = this.url;

                if(!this.from_pagination) {
                  url_to_call = url_to_call + this.order_by + '/' + this.order;
                }
                
                axios.get(url_to_call)
                  .then(response => {
                    this.scadenze = response.data
                    this.makePagination(response.data.links, response.data.meta)
                    this.pagination_ready = true

                  });

                this.search = '';

            },

            listNonScadute(url,order_by, order) {
                console.log(url,order_by, order);
                this.method = 'listNonScadute';
                
                if(order_by !== undefined)
                  {
                  this.order_by = order_by;
                  }
                
                if(order !== undefined)
                  {
                  this.order = order;
                  }

                this.endpoint = 'non-scadute';
                
                this.uri = '/api/memorex/non-scadute/';

                this.url = url || this.uri;

                let url_to_call = this.url;

                if(!this.from_pagination) {
                    url_to_call = url_to_call + this.order_by + '/' + this.order;
                }


                axios.get(url_to_call)
                  .then(response => {
                    this.scadenze = response.data
                    this.makePagination(response.data.links, response.data.meta)
                    this.pagination_ready = true

                  });

                this.search = '';

            },


            filter(url) {

                

                this.method = 'filter';

                this.endpoint = 'search';
                
                this.uri = '/api/memorex/search/'+ this.search;
                  
                this.url = url || this.uri;

                let url_to_call = this.url;

                if(!this.from_pagination) {
                  url_to_call = url_to_call + '/' + this.order_by + '/' + this.order;
                }
                 
                axios.get(url_to_call)
                  .then(response => {
                    console.log(response.data)
                    this.scadenze = response.data
                    this.makePagination(response.data.links, response.data.meta)
                    this.pagination_ready = true  
                  });
            },


            listArchivio(url,order_by, order) {
                console.log(url,order_by, order);
                this.method = 'listArchivio';

                if(order_by !== undefined)
                  {
                  this.order_by = order_by;
                  }
                
                if(order !== undefined)
                  {
                  this.order = order;
                  }
                
                this.endpoint = 'archivio';
                
                this.uri = '/api/memorex/archivio/';
                
                this.url = url || this.uri;

                let url_to_call = this.url;

                if(!this.from_pagination) {
                  url_to_call = url_to_call + this.order_by + '/' + this.order;
                }

                axios.get(url_to_call)
                  .then(response => {
                    this.scadenze = response.data
                    this.makePagination(response.data.links, response.data.meta)
                    this.pagination_ready = true

                  });

                this.search = '';
                
            },


            makePagination(links, meta) {

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
              this.scadenza.data = this.formattedData;

              axios.post('/api/memorex/store', { // <== use axios.post
                          data: this.scadenza,
                  })
                  .then(response => {
                        this.emptyScadenza();                   
                  }).finally(() => {
                        // ricarico la pagina corrente
                        this.choiceMethod(this.method, this.url);
                  });

            },

            loadScadenza: function(id) {
                  axios.get('api/memorex/' + id).
                  then(response => {
                    console.log(response);
                    this.scadenza.id = response.data.id
                    this.scadenza.titolo = response.data.titolo
                    this.scadenza.categoria = response.data.categoria
                    this.scadenza.commerciale_id = response.data.commerciale_id
                    this.scadenza.riferimento = response.data.riferimento
                    this.scadenza.descrizione = response.data.descrizione
                    this.scadenza.data = new Date(response.data.data_forjs)
                    this.scadenza.priorita = response.data.priorita
                });
                this.$refs.taskinput.focus();
                this.edit = true;
                $('tr#'+id).addClass('editing-row',{duration:500});
                $('#button_edit_row_'+id).hide('slow');
                $('#button_del_row_'+id).hide('slow');
            },

            updateScadenza: function() {
                  this.scadenza.data = this.formattedData;

                  axios.post('/api/memorex/' + this.scadenza.id, { // <== use axios.post
                          data: this.scadenza,
                          _method: 'patch'                   // <== add this field
                  })
                  .then(response => {
                        this.emptyScadenza();
                        this.edit = false;
                        this.editing_row = false;                   
                  }).finally(() => {
                        // ricarico la pagina corrente
                        this.choiceMethod(this.method, this.url);
                  });

                  $('tr#'+this.scadenza.id).removeClass('editing-row',  {duration:2500});                    
                  $('#button_edit_row_'+this.scadenza.id).show('slow');
                  $('#button_del_row_'+this.scadenza.id).show('slow');
                  

            },


            delScadenza: function(id) {
               axios.post('api/memorex/' + id, {
                 _method: 'delete'                   // <== add this field
               }).finally(() => {
                   // ricarico la pagina corrente
                  this.choiceMethod(this.method, this.url);
                });
            },

            cancel: function() {
              this.emptyScadenza();
              this.edit = false;
              this.editing_row = false;
              $('tr').removeClass('editing-row',{duration:500});
              $('.edit-btn').show('slow');
            },

            orderColumn: function(column) {
              
              // esco dalla paginazione
              this.from_pagination = 0;

              if(this.column == column) {
                this.order == 'asc' ? this.order = 'desc' : this.order = 'asc';
              } else {
                this.order = 'asc';
                this.column = column;
              }
              
              this.choiceMethodOrder(this.method, this.uri, this.column, this.order);

            }


        } 

    }
</script>



<style>
  .pagination button {
    margin:0 10px;
  }

  tr.editing-row {
    position: fixed;
    bottom: 0;
    z-index: 1000;
    width: 100%;
    background-color: white!important;
    border: 1px solid #bbb;
  }

  .filtra {
    padding: 0 1rem;
    margin: 1rem 0;
  }



  .Normale {
    color:#1aaa1a;
    font-size: 20px;
  }

  .Media {
    color:#ffd700;
    font-size: 20px;
  }

  .Alta {
    color: #f9ac20;
    font-size: 20px;
  }

  .Amministrazione {
    color: #de0000;
    font-size: 20px;
  }
  
</style>
