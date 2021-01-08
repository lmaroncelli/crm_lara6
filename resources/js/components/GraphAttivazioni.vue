<template>
  <div class="container">
    <linear-graph-attivazioni
      v-if="loaded_from_api"
      :annoCorrente="anno_corrente_obj"
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
        backgroundColor: '#f87979',
        data: []
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
    this.getAttivati(2020);
  },


  methods: {

    getAttivati(anno) {
            axios.get('/api/attivazioni/'+anno)
              .then(response => {
                  var res = []; 
                  for(var i in response.data) 
                      res.push(response.data[i]); 
                  console.log('res = '+res);
                  this.anno_corrente_obj.data = res;
                  this.loaded_from_api = true;
              });
        },
  
  },

}
</script>


<style>
</style>
