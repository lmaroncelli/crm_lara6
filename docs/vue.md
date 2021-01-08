# componente vue per i grafici vue-chartjs

https://vue-chartjs.org/guide


> npm install vue-chartjs chart.js --save

in questo modo ho scaricato il componente in node_modules e l'ho anche aggiunto nel file package.json



nel file blade home.blade.php includo il componente

<graph-attivazioni></graph-attivazioni>


Prima indico i 2 anni come oggetti statici

<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,

  data() {
    return {

      mesi: ['January', 'February'],

      anno_corrente_obj: {
        label: 'Data One',
        backgroundColor: '#f87979',
        data: [40, 20]
      },

      anno_precedente_obj: {
        label: 'Data two',
        backgroundColor: '#0f9f59',
        data: [50, 30]
      },

    }
  },

  // this.renderChart() is provided by the Bar component 
  // and accepts two parameters: both are objects. 
  // The first one is your chart data, 
  // and the second one is an options object.

  mounted () {
    this.renderChart(
      {
        labels: this.mesi,
        datasets:[
            this.anno_corrente_obj,
            this.anno_precedente_obj
            ]
      },
      {
        responsive: true
      }
    )
  }
}
</script>

poi li creo come risultato dell'interrogazione al DB 

