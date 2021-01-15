<template>
  <div class="container">
    <linear-graph-attivazioni
      v-if="loaded_from_api"
      :annoCorrente="anno_corrente_obj"
      :annoPrecedente="anno_precedente_obj"
      />
  </div>
</template>

<script>
import LinearGraphAttivazioni from "./LinearGraphAttivazioni";


export default {

  name: 'GraphAttivazioni',
  
  components: {
      LinearGraphAttivazioni
  },

  data() {
    return {

      loaded_from_api : false,

      anno_corrente_obj: {
        label: 'Data One',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [],
        fill: false,
      },

      anno_precedente_obj: {
        label: 'Data two',
        backgroundColor: 'rgb(54, 162, 235)',
        borderColor: 'rgb(54, 162, 235)',
        data: [],
        fill: false,
      },

    }
  },

  // this.renderChart() is provided by the Bar component 
  // and accepts two parameters: both are objects. 
  // The first one is your chart data, 
  // and the second one is an options object.

  mounted () {
    this.getAttivati(new Date().getFullYear());
  },


  methods: {

     getAttivati(anno) {
            axios.get('/api/attivazioni/'+anno)
              .then(response => {
                  var res = []; 
                  for(var i in response.data) {
                      res.push(response.data[i]); 
                  }
                  console.log('res = '+res);
                  this.anno_corrente_obj.data = res;
                  this.anno_corrente_obj.label = 'Anno '+anno;
                  let anno_prec = anno -1;
                  axios.get('/api/attivazioni/'+anno_prec)
                  .then(response => {
                    var res = []; 
                    for(var i in response.data) {
                        res.push(response.data[i]); 
                    }
                    console.log('res = '+res);
                    this.anno_precedente_obj.data = res;
                    this.anno_precedente_obj.label = 'Anno '+anno_prec;

                    this.loaded_from_api = true;
                  });                  
              });
      }
  },

}
</script>


<style>
</style>
