<template>
<div>

<ul class="pagination">
	  
	  <li class="page-item" :class="{disabled: pagination.current_page==1}">
	    <a href="#" class="page-link"  @click.prevent="paginate(method,pagination.first)"> << </a>
	  </li>

	  <li class="page-item" :class="{disabled: !pagination.prev}">
	    <a href="#" class="page-link" @click.prevent="paginate(method, pagination.prev)">Previous</a>
	  </li>

	  <li class="page-item">
	    <a class="page-link">Page {{pagination.current_page}} of {{pagination.last_page}}</a>
	  </li>

	  <li class="page-item" :class="{disabled: !pagination.next}">
	    <a href="#" class="page-link"  @click.prevent="paginate(method, pagination.next)">Next</a>
	  </li>

	  <li class="page-item" :class="{disabled: pagination.current_page == pagination.last_page}">
	    <a href="#" class="page-link"  @click.prevent="paginate(method, pagination.last)">>></a>
	  </li>
	
</ul>

</div>
</template>



<script>
	

 export default {

 		name: 'PaginationMemorex',

  	props: ['method', 'pagination', 'endpoint'],

    /*computed: {

      l_method: function() {
        return this.method
      },

      l_pagination: function() {
        return this.pagination
      },

      l_endpoint: function() {
        return this.endpoint
      }


    },*/

     methods: {

     		paginate(m, u) {
     			console.log('m = '+m);
     			console.log('u = '+u);
					let from_pagination = 1;
     			this.$emit('choice',m,u,from_pagination)
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