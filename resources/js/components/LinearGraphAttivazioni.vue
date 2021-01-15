<div>
    <p>Andamento attivazioni</p>
</div>


<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,

  props: ['annoCorrente','annoPrecedente'],


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
            this.annoCorrente,
            this.annoPrecedente,
            ]
      },
      {
        responsive: true,
        title: {
					display: true,
					text: 'Andamento attivazioni clienti Info Alberghi'
				},
        tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}]
				}
      }
    )
  }

}
</script>


<style>
</style>
