require('./bootstrap');
window.Vue=require('vue')
Vue.component('mainapp',require('./components/mainapp.vue').default)
import router from './router'
import store from './store'

import common from './common'

import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';

Vue.use(ViewUI);
Vue.mixin(common);


const app=new Vue({
    el:'#app',
    router,store
})