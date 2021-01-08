<div>
    <p>Andamento attivazioni</p>
</div>


<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,

  props: ['annoCorrente'],


  data() {
    return {

      mesi: ['Gennaio', 'Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],

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
            this.annoCorrente
            ]
      },
      {
        responsive: true
      }
    )
  }

}
</script>


<style>
</style>
