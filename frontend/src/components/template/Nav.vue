<template>
  <aside>
     <div class="container">
      <div class="navbar-header">
      </div>
      <ul class="nav navbar-nav">
        <router-link v-if="!isLoggedIn" class="nav-item nav-link" :to="{ name: 'Login' }">Login</router-link>
       
        <router-link
          v-if="!isLoggedIn"
          class="nav-item nav-link"
          :to="{ name: 'Register' }"
        >Register</router-link>

        <router-link
          v-if="!isLoggedIn"
          class="nav-item nav-link"
         to="/login"
        >Dashboard</router-link>

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
        <a class="nav-item nav-link" v-if="isLoggedIn" @click.prevent="logout" href="#">Logout</a>
      </ul>
    </div>
  </aside>
</template>

<script>
import User from "../../config/User";
import { mapGetters } from "vuex";
export default {
   computed: {
    ...mapGetters(["isLoggedIn"])
  },
   methods: {
    logout() {
      User.logout().then(() => {
        localStorage.removeItem("token");
        this.$store.commit("isLoggedIn",false);
        return  location.reload() && this.$router.push('/login');
      });
    }
  }
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