<template>
<div>
	
<ul class="pagination">
	  
	  <li class="page-item" :class="{disabled: l_pagination.current_page==1}">
	    <a href="#" class="page-link"  @click.prevent="paginate(l_method,`api/memorex/${l_endpoint}?page=1`)"> << </a>
	  </li>

	  <li class="page-item" :class="{disabled: !l_pagination.prev}">
	    <a href="#" class="page-link" @click.prevent="paginate(l_method, l_pagination.prev)">Previous</a>
	  </li>

	  <li class="page-item">
	    <a class="page-link">Page {{l_pagination.current_page}} of {{l_pagination.last_page}}</a>
	  </li>

	  <li class="page-item" :class="{disabled: !l_pagination.next}">
	    <a href="#" class="page-link"  @click.prevent="paginate(l_method, l_pagination.next)">Next</a>
	  </li>

	  <li class="page-item" :class="{disabled: l_pagination.current_page == l_pagination.last_page}">
	    <a href="#" class="page-link"  @click.prevent="paginate(l_method, `api/memorex/${l_endpoint}?page=${l_pagination.last_page}`)">>></a>
	  </li>
	
</ul>

</div>
</template>



<script>
	

 export default {

 		name: 'PaginationMemorex',

  	props: ['method', 'pagination', 'endpoint'],

    computed: {

      l_method: function() {
        return this.method
      },

      l_pagination: function() {
        return this.pagination
      },

      l_endpoint: function() {
        return this.endpoint
      }


    },

     methods: {

     		paginate(m, u) {
     			console.log('m = '+m);
     			console.log('u = '+u);
     			this.$emit('choice',m,u)
     		}
     
     }


}


</script>





<style>

	  .pagination button {
	    margin:0 10px;
	  }

	 	ul#filtro_scadenze {
		  list-style: none;
		  display: flex;
		  justify-content: space-around;
		}

</style>