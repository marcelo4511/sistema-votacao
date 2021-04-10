import Vue from 'vue'
import App from './App.vue'
import router from './config/routes'
import VueMaterial from 'vue-material'
import store from "./store";
import axios from 'axios'
import './config/messages'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'popper.js'
import 'font-awesome/css/font-awesome.css'
import 'vue-material/dist/vue-material.css'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'
import * as Cookie from 'js-cookie'

Vue.config.productionTip = false

Vue.use(VueMaterial)

new Vue({
  render: h => h(App),
  router,
  store,
  created () {
  //  const userInfo = localStorage.getItem('user')
  //  if (userInfo) {
   //   const userData = JSON.parse(userInfo)
     // this.$store.commit('User/setUserData', userData)
  // }
    axios.interceptors.response.use(
      response => response,
      error => {
        if (error.response.status === 401) {
          Cookie.remove('vuex');
        this.$store.commit("Logged",false);
        return this.$router.push('/login') && location.reload()  
        }

        if(error.response.status === 404) {
          this.$store.commit('Logged')
        }
        return Promise.reject(error)
      }
    )
  },
}).$mount('#app')
