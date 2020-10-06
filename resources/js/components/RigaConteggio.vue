<template>
		<div class="wrapper">
			<validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
			<div class="step" v-show="!calcola">
					<div class="row">
						<div class="col">
								<div class="form-group row">
									
									<label class="col-lg-1 text-change" for="cell">Cliente:</label>
									<div class="col-lg-4">
										<select name="cliente" class="form-control" v-model="cliente" @change="loadServiziCliente()">
											<option value="0">Nessuno</option>
											<option v-for="cliente in clienti" :value="cliente"> {{cliente.nome}} </option>
										</select>
									</div>

								</div>
								<div class="form-group row">
								
									<label class="col-lg-1 text-change" for="cell">Servizi:</label>
									<div class="col-lg-4">
										
										<select v-if="!carica_servizi || servizi.length > 0" name="servizi_selected" class="form-control" multiple v-model="servizi_selected">
											<option v-for="servizio in servizi" :value="servizio"> {{servizio.nome}} </option>
										</select>

										<span v-if="carica_servizi && servizi.length == 0">Nessun servizio da conteggiare per questo cliente</span>
									</div>
									
									<div class="col-lg-1">
										<a href="#" @click.prevent="stepCalcola()" class="btn btn-info">Prosegui</a>
									</div>
									<div class="col-lg-1">
										oppure inserisci una riga
									</div>
									<div class="col-lg-1">
										<a href="#" @click.prevent="stepLibera()" class="btn btn-success">Libera</a>
									</div>

								</div>
						</div>
					</div>
			</div> <!-- step -->
			<div class="step" v-show="calcola==1">
					<div class="row">
						<div class="col">
						{{cliente.nome}}
						</div>
					</div>
					<div class="row">
						<div class="col" v-html="nomiServizi">
						</div>
						
						<div class="col">
							<div class="form-group">
								<label for="">Valore</label>
								<input type="text" class="form-control" name="valore" id="valore" v-model="valore" placeholder="">
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label for="">Modalità 
									<span v-if="Object.keys(modalita_selected).length !== 0">
									{{modalita_selected.nome}} ({{modalita_selected.percentuale}})% 
									</span>
								</label>
								<select name="modalita_selected" class="form-control" v-model="modalita_selected">
									<option v-for="modalita in modalita_vendita" :value="modalita"> {{modalita.nome}} </option>
								</select>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label for="">Valore %</label>
								<input type="text" class="form-control" name="valore_percentuale" v-model="valore_percentuale" id="valore_percentuale" readonly>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
									<a href="#" @click.prevent="stepBack()" class="btn btn-info">Indietro</a>
							</div>
						</div>

							<div class="col">
							<div class="form-group">
									<a href="#" @click.prevent="insertRigaConteggio()" class="btn btn-info">Inserisci</a>
							</div>
						</div>

					</div>
			</div> <!-- step -->
			<div class="step" v-show="calcola==2">
					
					<div class="form-group row">
						
						<label class="col-lg-1 text-change" for="descrizione">Descrizione:</label>
						<div class="col-lg-4">
							<input type="text" class="form-control" name="descrizione" id="descrizione" v-model="descrizione" placeholder="">
						</div>

					</div>


					<div class="form-group row">
						
						<label class="col-lg-1 text-change" for="descrizione">Valore:</label>
						<div class="col-lg-4">
							<input type="text" class="form-control" name="valore" id="valore" v-model="perc" placeholder="">
						</div>

						<div class="col">
							<div class="form-group">
									<a href="#" @click.prevent="stepBack()" class="btn btn-info">Indietro</a>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
									<a href="#" @click.prevent="insertRigaLibera()" class="btn btn-info">Inserisci</a>
							</div>
						</div>

					</div>

			</div> <!-- step -->
		</div>	<!-- wrapper -->
</template>

<script>

		import ValidationErrors from "./ValidationErrors";

    export default {

				components: {
            ValidationErrors
        },

				props: ['commerciale_id','conteggio_id'],
        
				data() {
					return {
						validationErrors:'',
						cliente: {},
						clienti:[],
						servizi:[],
						servizi_selected: [],
						servizi_nomi_selected:[],
						servizi_ids_selected:[],
						calcola:0,
						modalita_vendita:[],
						modalita_selected:{},
						descrizione:'',
						valore:null,
						valore_percentuale:null,
						perc:null,
						carica_servizi:0,
						row : {
							conteggio_id:null,
							cliente_id:null,
							modalita_id:null,
							totale:0.00,
							reale:null,
							percentuale:null,
							descrizione:'',
						}
					}
				},


        mounted() {
            this.getClientiCommerciale(this.commerciale_id);
        },


				watch: {
					// whenever question changes, this function will run
					modalita_selected: function (newModalita, oldModalita) {
						this.calcolaValorePercentuale();
					},

					valore: function (newModalita, oldModalita) {
						this.calcolaValorePercentuale();
					}

				},


				methods: {

					getClientiCommerciale(commerciale_id) {
						 axios.get('/api/conteggi/clientiCommerciale/'+commerciale_id)
                  .then(response => {
										//console.log(response);
                    this.clienti = response.data;
                  });
					},

					loadServiziCliente() {

						this.carica_servizi = 0;
						axios.get('/api/conteggi/serviziCliente/'+this.cliente.id)
                  .then(response => {
                    this.servizi = response.data;
                  });

						this.carica_servizi = 1;

					},


					stepCalcola() {

						axios.get('/api/conteggi/modalitaVendita/'+this.commerciale_id)
								.then(response => {
									this.modalita_vendita = response.data;
								});

						this.servizi_ids_selected = [];
						if(this.servizi_selected.length) {
							this.servizi_selected.forEach(
								(servizio) => {
									this.servizi_ids_selected.push(servizio.id)
								}
							)
						}

						this.calcola = 1;
					},


					stepLibera() {
							this.calcola = 2;
					},


					stepBack() {

						this.servizi_selected= [];
						this.servizi_nomi_selected=[];
						this.servizi_ids_selected = [];
						this.modalita_selected={};
						this.valore=null;
						this.perc=null,
						this.valore_percentuale=null;
						this.calcola = 0;
					},


					calcolaValorePercentuale() {
						if(this.valore !== null && Object.keys(this.modalita_selected).length !== 0) {
							this.perc = this.valore*this.modalita_selected.percentuale/100;
							this.valore_percentuale = +this.perc + +this.valore;
						}
					},


					insertRigaConteggio() {
						this.row.conteggio_id = this.conteggio_id;
						this.row.cliente_id = this.cliente.id;
						this.row.modalita_id = this.modalita_selected.id;
						this.row.reale = this.valore;
						this.row.percentuale = this.perc;
						this.row.descrizione = this.descrizione;
					
						axios.post('/api/conteggi/insertRiga', { // <== use axios.post
                          data: this.row,
													servizi_ids_selected: this.servizi_ids_selected
                  })
                  .then(response => {
                    	// reload page??
											alert('Inserimemto corretto');
											location.reload(); 
                  })
									.finally(() => {
                        // ricarico la pagina corrente
                       
                  });
					},


					insertRigaLibera() {
						this.row.conteggio_id = this.conteggio_id;
						this.row.cliente_id = 0;
						this.row.modalita_id = 0;
						this.row.reale = 0.00;
						this.row.percentuale = this.perc;
						this.row.descrizione = this.descrizione;

						axios.post('/api/conteggi/insertRiga', { // <== use axios.post
                          data: this.row
                  })
                  .then(response => {
                    	// reload page??
											alert('Inserimemto corretto');
											location.reload(); 
                  })
									.catch(error => {
										console.log(error.response.data.errors);
										this.validationErrors = error.response.data.errors;
									})
									.finally(() => {
                        // ricarico la pagina corrente
                       
                  });
					},



				},

				computed: {
          
          nomiServizi: {

            // getter
            get: function () {
							this.servizi_nomi_selected = [];
              if(this.servizi_selected.length) {
								this.servizi_selected.forEach(
									(servizio) => {
										this.servizi_nomi_selected.push(servizio.nome)
									}
								)
								return this.servizi_nomi_selected.join('<br/>');
							}
              else {
                return 'nessun servizio selezionato';
							}
            }

            
          }
        
        },
    }
</script>
