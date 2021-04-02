<template>
<div v-show="isLoggedIn">
   <md-card>
      <md-card-header>
         <div class="md-title">
            Seja bem vindooo!!!
         </div>
         <div class="card">
      <div class="card-body" v-if="user">
        <h3>Hello, {{ user.name }}</h3>
        <span>{{ user.email }}</span>
      </div>
    </div>
      </md-card-header>
      <md-card-content>
        <div class="md-title subtitle">
            Sistema de gerenciamento de enquetes
         </div>
      </md-card-content>
   </md-card>

</div>

</template>

<script>
import User from "../../config/User";
import { mapState,mapGetters } from "vuex";

export default {
  computed: {
    ...mapState({
      user: state => state.user
    }), 
  ...mapGetters(["isLoggedIn"]), 
  
  },

  mounted() {
    User.auth().then(response => {
      this.$store.commit("AUTH_USER", response.data);
    });
  }
};
</script>

<style>
  .subtitle{
     color:#fff;
     font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
     background-color: #000;
     display: flex;
     text-align: center;
     justify-content: center;
     align-items: center;
  }
</style>