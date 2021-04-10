<template>
  <header>
    <div class="d-flex justify-content-md-end mr-3 mt-2">
      <router-link v-if="isLoggedIn" class="btn btn btn-write" to="/survey" tag="span">
        <i class="fa fa-comments"></i> Enquetes
       </router-link>
     <div class="dropdown" >
        <button class="drops btn btn-write dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span >{{user.nome}}</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <span class="d-flex justify-content-beetween dropdown-item" @click="sair()">Sair
          </span>
        </div>
      </div>
    </div>
  </header>
</template>

<script>

import * as Cookie from 'js-cookie'
import User from "../../config/User";
import { mapGetters, mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      user: state => state.user
    }),
    ...mapGetters(['isLoggedIn'])
  },

  mounted() {
    User.auth().then(response => {
      this.$store.commit("AUTH_USER", response.data);
    });
  },
   methods: {
    sair() {
        User.logout().then(() => {
        Cookie.remove('vuex');
        this.$store.commit("Logged",false);
        return this.$router.push('/login') && location.reload()   
      });
    }
  }
};
  
    

</script>

<style>

    header{
        width:100vw;
         grid-area: header;
        background: linear-gradient(to right, #1e469a, #49a7c1);

        display: flex;
        justify-content: center;
        align-items: center;
        
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }

    
</style>