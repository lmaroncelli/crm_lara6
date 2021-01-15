# componente vue per i grafici vue-chartjs

https://vue-chartjs.org/guide


> npm install vue-chartjs chart.js --save

in questo modo ho scaricato il componente in node_modules e l'ho anche aggiunto nel file package.json



nel file blade home.blade.php includo il componente

<graph-attivazioni></graph-attivazioni>

GraphAttivazioni.vue è un __wrapper component__ che chiama il __child component__  LinearGraphAttivazioni passandogli i dati da disegnare 

<linear-graph-attivazioni
      v-if="loaded_from_api"
      :annoCorrente="anno_corrente_obj"
      :annoPrecedente="anno_precedente_obj"
      />

e fa la chiamata solo dopo aver ricevuto i dati dalla API mediante la chiamata axios.get('/api/attivazioni/'+anno);
dentro lo then della prima chimata axios faccio la seconda chiamata con l'anno precedente ed alla fine this.loaded_from_api = true; in modo che linear-graph-attivazioni venga attivato




