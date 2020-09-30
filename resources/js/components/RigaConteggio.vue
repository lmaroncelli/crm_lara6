<template>
    <div class="container">
        <div class="row">
          <div class="col">
              <div class="form-group row">
								<label class="col-md-3 text-change" for="cell">Seleziona un cliente:</label>
								<div class="col-md-5">
									<select name="cliente_id" class="form-control" v-model="cliente_id" @change="loadServiziCliente()">
										<option value="0">Nessuno</option>
										<option v-for="(nome, id) in clienti" :value="id"> {{nome}} </option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 text-change" for="cell">Servizi venduti:</label>
								<div class="col-md-5">
									<select name="servizi[]" class="form-control" multiple v-model="servizi">
										<option v-for="(nome, id) in servizi" :value="id"> {{nome}} </option>
									</select>
								</div>
							</div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {

				props: ['commerciale_id'],
        
				data() {
					return {
						cliente_id: 0,
						clienti:[],
						servizi: []
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

						axios.get('/api/conteggi/serviziCliente/'+this.cliente_id)
                  .then(response => {
										const objectArray = Object.entries(response.data);
										let servizi = [];
										objectArray.forEach(([key, value]) => {
											servizi[key] = value;
										});
										console.log('servizi = ' + servizi);
                    this.servizi = servizi;
                  });

					}

				},
    }
</script>
