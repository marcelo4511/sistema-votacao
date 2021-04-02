<template>
  <div id="app">
       
     <Header v-if="isLoggedIn"/>
     <Main/>
  </div>
</template>

<script>
 import Main from './components/template/Main'
 import Header from './components/template/Header'
 import { mapGetters } from "vuex";
export default {
  
  components: { Main,Header},
  computed: {
    ...mapGetters(["isLoggedIn"]), 
  },
}
</script>

<style>

* {
		font-family: "Lato", sans-serif;
    margin:0;
    padding: 0;
	}


  #app {
    display:grid;
    grid-template-rows: 60px;
		grid-template-columns:1fr;
    height: 100vh;
    width: 100vw;
    grid-template-areas: 
    "header"
    "main"
    ;
    
  }
 #app.hide-menu {
		grid-template-areas:
			"header"
			"main"
			;
	}
aside .lado{
  grid-area: lado;
}
header header{
  grid-area: header;
}
main .main {
  grid-area: main;
}
footer .footer {
  grid-area: footer;
}

@media(max-width: 768px){
  #app {
    grid-template-rows:
    50px
    1fr;

    grid-template-columns:  1fr;


    grid-template-areas: 
     "header"
     "main "
    ;
  }
}

@media(max-width:576px){
  #app {
    grid-auto-rows: 100;
    grid-template-rows:
   
    50px
    1fr;

    grid-template-columns:  1fr;

    grid-template-areas: 
    "header"
     "main"
  }
}

</style> 