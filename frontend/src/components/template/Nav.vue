<template>
  <aside>
   
     <ul class="title">
      <router-link to="/" tag="span">
        <li>
         <i class="fa fa-home"></i> Home
        </li>
       </router-link>

       <router-link to="/survey" tag="span">
       <li>
        <i class="fa fa-comments"></i> Enquetes
       </li>
       </router-link>
       
     </ul>
  </aside>
</template>

<script>

export default {
  
 
}
</script>
<style>

    aside{
      grid-area: lado;
        background-color:black;
    }
   
    aside ul{
      margin-top: 100px;
    }
    aside ul li {
      display: flex;
      font-family: Arial, Helvetica, sans-serif;
      justify-content: flex-start;
      align-items: center;
      text-align: center;
      font-size: 25px;
      height: 80px;
      padding: 10px;
      color:blanchedalmond;
      text-decoration: none;
      cursor: pointer;
    }

    aside ul li:hover{
      background-color: blue;
      color: blanchedalmond;
      transition: 3ms;
      text-decoration: none;
    }

    
     aside ul li a{
      text-decoration: none;
    }

    @media(max-width:768px) {
      aside {
        display: flex;
        justify-content: flex-start;
        align-items: center;
      }

      aside a {
        display: inline;
        padding: 10px;
        margin:0px;
        color: black;
      }

      aside{
        justify-content: space-around;
      }

            
    }
       @media(max-width:576px) {
        aside ul{
        margin-top: 25px;
        height: 25px;
        padding: 10px;
        }

        aside ul li {
        display: flex;
        font-family: Arial, Helvetica, sans-serif;
        justify-content: flex-start;
        align-items: center;
        text-align: center;
        font-size: 25px;
        height: 25px;
        
        color:blanchedalmond;
        text-decoration: none;
        cursor: pointer;
    }
  }
</style>