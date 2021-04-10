import Vue from "vue"
import Vuex from "vuex"
import createPersistedState from "vuex-persistedstate";
import * as Cookies from "js-cookie";

Vue.use(Vuex)

export default new Vuex.Store({
    state:{
       user:null
    },
    plugins: [
        createPersistedState({
          storage: {
            getItem: (key) => Cookies.get(key),
           setItem: (key, value) =>
              Cookies.set(key, value, { expires: 5, secure: true }),
            removeItem: (key) => Cookies.remove(key),
          },
        }),
      ],
    getters:{
        isLoggedIn(state) {
            return !!state.user 

        }
    },

    mutations:{
        LOGIN(state) {
            localStorage.setItem('user', JSON.stringify(state.user))
            return state.user == []
        },

        AUTH_USER(state,user) {
            localStorage.setItem('user', JSON.stringify(state.user))
            return state.user = user
        },
        Logged(state,user) {
            localStorage.setItem('user', JSON.stringify(state.user))
            return state.user = user
        }
    },

    actions:{}
})