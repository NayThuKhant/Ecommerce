import VueRouter from 'vue-router'
require('./bootstrap');
import Vue from 'vue';
import Vuex from 'vuex';
import VueProgressBar from 'vue-progressbar'
import Routes from './routes'
import storeOptions from "./store";
import defineRouteGuard from "./router_guard";

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('master', require('./views/master.vue').default);
Vue.use(Vuex)

const store = new Vuex.Store(storeOptions)
const router = new VueRouter({
    mode: 'history',
    routes: Routes
})
Vue.use(VueProgressBar, {
    color: 'rgb(69,219,142)',
    failedColor: 'red',
    height: '3px',
    thickness: '4px',
})
Vue.use(VueRouter)
let app;
defineRouteGuard()
    .then(() => {
        app = new Vue({
            el: '#app',
            store,
            router,

        });
    });

export { router, app }

