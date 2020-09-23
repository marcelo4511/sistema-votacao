import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../components/template/Home'
import Survey from '../components/Survey/index'
import SurveyVote from '../components/Survey/vote'

Vue.use(VueRouter)

const routes = [{
    name: 'home',
    path: '/',
    component:Home
},{
    name:'survey',
    path:'/survey',                                                                                                                                                                                                                       
    component:Survey
},{
    name:'surveyVote',
    path:'/survey/:form/vote',                                                                                                                                                                                                                       
    component:SurveyVote,
    params:true  
}]

export default new VueRouter({
    mode:'history',
    routes
})