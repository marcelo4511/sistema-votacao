import Vue from 'vue'
import App from './App.vue'
import router from './config/routes'
import VueMaterial from 'vue-material'
import store from "./store";
import './config/filterData'
import './config/messages'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'popper.js'
import 'font-awesome/css/font-awesome.css'
import 'vue-material/dist/vue-material.css'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'


Vue.config.productionTip = false

Vue.use(VueMaterial)

new Vue({
  render: h => h(App),
  router,
  store,
}).$mount('#app')
