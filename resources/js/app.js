import VueRouter from 'vue-router'
require('./bootstrap');
import Vue from 'vue';
import Vuex from 'vuex';
import Routes from './routes'

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('master', require('./views/master.vue').default);


const router = new VueRouter({
    mode: 'history',
    routes: Routes
})

Vue.use(Vuex)
const store = new Vuex.Store({
    state: {
        loaded: false,
        user: {}
    },
    mutations: {
        setAsLoaded(state) {
            state.loaded = true
        },
        setAsNotLoaded(state) {
            state.loaded = false
        },
        setCurrentUser(state, user) {
            state.user = user
        }
    }
})
Vue.use(VueRouter)

const app = new Vue({
    el: '#app',
    store,
    router

});
