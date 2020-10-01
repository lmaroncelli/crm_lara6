<template>
		<div class="wrapper">
			<div class="step" v-show="!calcola">
					<div class="row">
						<div class="col">
								<div class="form-group row">
									
									<label class="col-md-1 text-change" for="cell">Cliente:</label>
									<div class="col-md-4">
										<select name="cliente" class="form-control" v-model="cliente" @change="loadServiziCliente()">
											<option value="0">Nessuno</option>
											<option v-for="cliente in clienti" :value="cliente"> {{cliente.nome}} </option>
										</select>
									</div>
								
									<label class="col-md-1 text-change" for="cell">Servizi:</label>
									<div class="col-md-4">
										<select name="servizi_selected" class="form-control" multiple v-model="servizi_selected">
											<option v-for="servizio in servizi" :value="servizio"> {{servizio.nome}} </option>
										</select>
									</div>
									<div class="col-md-2">
										<a href="#" @click.prevent="stepCalcola()" class="btn btn-info">Prosegui</a>
									</div>

								</div>
						</div>
					</div>
			</div> <!-- step -->
			<div class="step" v-show="calcola">
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
								<input type="text" class="form-control" name="valore" id="valore" aria-describedby="helpId" placeholder="">
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label for="">Modalità</label>
								<select name="cliente" class="form-control" v-model="modalita" @change="">
									<option value="0">Seleziona</option>
									<option v-for="modalita in modalita_vendita" :value="modalita"> {{modalita.nome}} </option>
								</select>
							</div>
						</div>
					</div>
			</div> <!-- step -->
		</div>	<!-- wrapper -->
</template>

<script>
    export default {

				props: ['commerciale_id'],
        
				data() {
					return {
						cliente: {},
						clienti:[],
						servizi:[],
						servizi_selected: [],
						servizi_nomi_selected:[],
						calcola:0,
						modalita_vendita:[],
						modalita:{}
					}
				},


        mounted() {
            this.getClientiCommerciale(this.commerciale_id);
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

						axios.get('/api/conteggi/serviziCliente/'+this.cliente.id)
                  .then(response => {
                    this.servizi = response.data;
                  });

					},


					stepCalcola() {

						axios.get('/api/conteggi/modalitaVendita/'+this.commerciale_id)
								.then(response => {
									this.modalita_vendita = response.data;
								});

						this.calcola = 1;
					}

				},

				computed: {
          
          nomiServizi: {

            // getter
            get: function () {
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
