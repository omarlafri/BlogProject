import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import firstPage from './components/pages/firstViewPage'
import secondePage from './components/pages/secondViewPage'
import hook from './components/pages/basics/hooks'
import basic from './components/pages/basics/basic'
import home from './admin/pages/home'
import tags from './admin/pages/tags'
import categories from './admin/pages/categories'
import users from './admin/pages/users'
import login from './admin/pages/login'


import comc from './vuex/comC'







const routes=[

    // Project routes
    {
        path:'/home',

        component:home

    },
    // Admin routes
    {
        path:'/tags',

        component:tags

    },
    {
        path:'/categories',

        component:categories

    },
    {
        path:'/users',

        component:users

    },
    {
        path:'/login',

        component:login

    },


    //*************************************** */

    {
        path:'/my-first-page',

        component:firstPage

    },
    {
        path:'/my-seconde-page',

        component:secondePage

    },
    {
        path:'/hook',

        component:hook

    },
    {
        path:'/comc',

        component:comc

    },
    
    {
        path:'/basic',

        component:basic

    }
]

export default new Router({

    mode:'history',
    routes

})