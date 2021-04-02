import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex)

export default new Vuex.Store({
    state:{
       user:null
    },

    getters:{
        isLoggedIn(state) {
            console.log(!!state.user)
            console.log(state.user)
            return !!state.user

        }
    },

    mutations:{
        LOGIN(state) {
            return state.user == []
        },

        AUTH_USER(state,user) {
            return state.user = user
        },
        Logged(state,user) {
            return state.user = user
        }
    },

    actions:{}
})