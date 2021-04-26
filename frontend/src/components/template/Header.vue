<template>
  <header :class="{ 'back': show, 'navbar': !show }">
  
    <div class="d-flex justify-content-md-end mr-3 mt-0" >
      <router-link v-if="isLoggedIn" class="btn btn btn-write"  to="/survey" tag="span">
        <div class="teste" id="teste" style="color:white;">
            <i class="fa fa-comments"></i> <b >Enquetes</b> 
        </div>
      </router-link>
        <div class="dropdown" v-if="user.email == 'cassio@hotmail.com'">
          <button class="drops btn btn-write dropdown-toggle teste2" style="color:white;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <b style="color:white;">Configurações</b>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <router-link to="/user" tag="span" class="d-flex justify-content-beetween dropdown-item">Usuários</router-link>
          </div>
        </div>
    </div>
    <div>
      <div class="dropdown">
          <button class="drops btn btn-write dropdown-toggle teste2" style="color:white;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <b style="color:white;cursor:pointer;">{{user.nome}}</b>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="cursor:pointer;">
            <span class="d-flex justify-content-beetween dropdown-item" @click="sair()">Sair
            </span>
          </div>
        </div>
      <div>
    </div>
      <button class="btn btn-sm btn-white" id="botao"  v-if="show == false" @click="showFilter"><i class="fa fa-list"></i></button>
      <button class="btn btn-sm btn-white" id="botao"  v-if="show == true" @click="hideFilter"><i class="fa fa-list"></i></button>
  </div>
    
    <div id="back" v-if="show" v-show="user.email == 'cassio@hotmail.com'">
      <div style="height:18px;">
      <router-link v-if="isLoggedIn"  class="btn btn-sm btn-write" style="color:white;"  to="/survey" tag="button">
        <i class="fa fa-comments"></i><b style="color:white;"> Enquetes</b>    
      </router-link>
      </div><br>
      <div class="dropdown" style="height:10px;" >
        <button class="drops btn btn-write dropdown-toggle" style="color:white;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-cog"></i> <b style="color:white;">Configurações</b>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <span class="d-flex justify-content-beetween dropdown-item">Usuários</span>
        </div>
      </div><br>
     <div class="dropdown" style="height:10px;">
        <button class="drops btn btn-write dropdown-toggle" style="color:white;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user"></i> <b style="color:white;"> {{user.nome}}</b>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="cursor:pointer;">
          <span class="d-flex justify-content-beetween dropdown-item" @click="sair()">Sair
          </span>
        </div>
      </div>
    </div>

    <div id="back" v-if="show" v-show="user.email !== 'cassio@hotmail.com'">
      <div style="height:18px;">
      <router-link v-if="isLoggedIn"  class="btn btn-sm btn-write" style="color:white;"  to="/survey" tag="button">
        <i class="fa fa-comments"></i><b style="color:white;"> Enquetes</b>    
      </router-link>
      </div><br>
     <div class="dropdown" style="height:10px;">
        <button class="drops btn btn-write dropdown-toggle" style="color:white;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user"></i> <b style="color:white;"> {{user.nome}}</b>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="cursor:pointer;">
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
   data() {
     return {
       show:false,
     }
   },
  computed: {
    ...mapState({user: state => state.user}),
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
    },
    showFilter(){
      this.show = true;
    },
    hideFilter(){
      this.show = false;
    },
  }
};
</script>

<style>
      header{
        width:100vw;
        grid-area: header;
        background: linear-gradient(to right, #1e469a, #49a7c1);
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
      }

      header div{
        display: flex;
        align-items: center;
        text-align: center;
        justify-content: center;
      }

      header #botao{
        display: none;
      }
    
@media(max-width:576px){
 
  header #botao{
    color: white;
    display: block;
    visibility: visible;
    display:flex;
    justify-content: flex-start;
    align-items: flex-start;
    padding: 0;
  }
    header .teste{
      display:none;
    }

    header .teste2{
      display:none;
    }

    header #back{
      background: linear-gradient(to right, #1e469a, #49a7c1);
      display: inline-block;
      width: 100%;  
      display: flex;
      flex-direction: column;
      height: 100px;
      align-items: flex-start;
      justify-content: flex-start;
    }
    
    header div{
      display: flex;
      align-items: flex-end;
      text-align: flex-end;
      justify-content: flex-end;
      margin-right: 30px;
      margin-top: 5px;
    }
}
</style>