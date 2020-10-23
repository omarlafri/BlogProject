import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import firstPage from './components/pages/firstViewPage'
import secondePage from './components/pages/secondViewPage'
import hook from './components/pages/basics/hooks'
import basic from './components/pages/basics/basic'
import home from './components/pages/basics/home'
import tags from './admin/pages/tags'
import categories from './admin/pages/categories'






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
        path:'/basic',

        component:basic

    }
]

export default new Router({

    mode:'history',
    routes

})