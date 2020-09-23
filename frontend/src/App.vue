<template>
  <div id="app">
       
     <Nav/>
     <Header />
     <Main/>
     <Footer/>
  </div>
</template>

<script>
 import Nav from './components/template/Nav'
 import Main from './components/template/Main'
 import Header from './components/template/Header'
 import Footer from './components/template/Footer'
 
export default {
  components: { Main,Nav,Header,Footer},
  
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
    grid-template-rows: 60px 1fr 30px;
		grid-template-columns: 200px 1fr;
    height: 100vh;
    width: 100vw;
    grid-template-areas: 
    "header header"
    "lado main"
    "lado footer"
    ;
    
  }
 #app.hide-menu {
		grid-template-areas:
			"header header"
			"main main"
      "main footer"
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
    300px
    1fr;

    grid-template-columns:  1fr;


    grid-template-areas: 
     "header"
     "lado "
     "main "
    ;
  }
}

@media(max-width:576px){
  #app {
    grid-auto-rows: 100;
    grid-template-rows:
   
    50px
    100px
    1fr;

    grid-template-columns:  1fr;

    grid-template-areas: 
    "header"
    "lado "
     "main"
  }
}

</style> 