<template>
<div>

<ul class="pagination">
	  
	  <li class="page-item" :class="{disabled: pagination.current_page==1}">
	    <a href="#" class="page-link"  @click.prevent="$emit('choise',method,`api/memorex/${endpoint}?page=1`)"> << </a>
	  </li>

	  <li class="page-item" :class="{disabled: !pagination.prev}">
	    <a href="#" class="page-link" @click.prevent="$emit('choise', method, pagination.prev)">Previous</a>
	  </li>

	  <li class="page-item">
	    <a class="page-link">Page {{pagination.current_page}} of {{pagination.last_page}}</a>
	  </li>

	  <li class="page-item" :class="{disabled: !pagination.next}">
	    <a href="#" class="page-link"  @click.prevent="$emit('choise', method, pagination.next)">Next</a>
	  </li>

	  <li class="page-item" :class="{disabled: pagination.current_page == pagination.last_page}">
	    <a href="#" class="page-link"  @click.prevent="$emit('choise', method, `api/memorex/${endpoint}?page=${pagination.last_page}`)">>></a>
	  </li>
	
</ul>

</div>
</template>



<script>
	

  export default {

  	props: ['method', 'pagination', 'endpoint'],

  	data() {

  	    return {
  	        
  	          	      
  	    }
  	},

   mounted() {
             this.show();
        },

   methods: {

            show(method,url) {
             console.log(this.pagination)
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