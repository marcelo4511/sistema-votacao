import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../components/template/Home'
import Login from '../components/Auth/Login'
import Register from '../components/Auth/Register'
import Survey from '../components/Survey/index'
import SurveyVote from '../components/Survey/vote'

Vue.use(VueRouter)

const routes = [{
    
        path: '/',
       name: 'index',
       redirect: to => {
            const logado = localStorage.getItem("token");
            if(to.matched.some(record => record.meta.auth) && logado) {
                return '/home'
           } 
    
             if(!logado) {
                return '/login'
           } 
        },
        meta: {
            auth: true
        }
    },
    {
    name: 'home',
    path: '/home',
    component:Home,
    meta: { auth: true }
},{
    name:'survey',
    path:'/survey',                                                                                                                                                                                                                       
    component:Survey,
    meta: { auth: true }
},{
    name:'surveyVote',
    path:'/survey/:form/vote',                                                                                                                                                                                                                       
    component:SurveyVote,
    params:true  ,
    meta: { auth: true }
}, {
    path: "/login",
    name: "login",
    component: Login,
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
  }
]

const router =  new VueRouter({
    mode:'history',
    base: process.env.BASE_URL,
    routes
})

function isLoggedIn() {
    return localStorage.getItem("token");
}

router.beforeEach((to,from,next) => {
    if(to.matched.some(record => record.meta.authOnly)) {
        if(!isLoggedIn()) {
            next({
                path:"/login",
                query:{redirect:to.fullPath}
            });
        }else {
            next();
        }
    }else if (to.matched.some(record => record.meta.guestOnly)) {
        if(isLoggedIn()) {
            next({
                path:"/dashboard",
                query:{redirect:to.fullPath}
            });
        }else {
            next();
        }
    }else {
        next();
    }
});

export default router;

