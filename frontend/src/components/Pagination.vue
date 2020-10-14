<template>
   <nav aria-label="Page navigation example">
    <ul class="pagination">
        <li>
        <a class="page-link" href="#" @click="navigate($event,source.current_page-1)" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
        </a>
        </li>
        
        <li v-for="(page,i) in pages" :key="i" :class="{active:source.current_page == page}">
          <a class="page-link" href="#" @click="navigate(page)">{{page}}</a></li>
        <li class="page-item">
        <a class="page-link" href="#" @click="navigate($event,source.current_page+1)" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
        </a>
        </li>
    </ul>
</nav>
</template>
<script>
import {range} from 'lodash'
  export default{
    props: ["source","page","itensPerPage"],
    data(){
      return {
        pages:[]
      }
    },
    watch:{
      source(){
        this.pages = range(1,this.source.last_page+1)
      }
    },
    methods: {
      navigate(page){
        this.$emit('navigate',page)
      }
    }
  }
</script>