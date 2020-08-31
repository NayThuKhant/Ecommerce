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

Vue.component('tabs', {
    template: `
        <div>
            <div class="tabs">
              <ul class="flex justify-center">
                <li v-for="tab in tabs" :class="{ 'is-active': tab.isActive }" class="block mx-5">
                    <a :href="tab.href" @click="selectTab(tab)">{{ tab.name }}</a>
                </li>
              </ul>
            </div>

            <hr class="h-2">

            <div class="tabs-details px-40">
                <slot></slot>
            </div>
        </div>
    `,

    data() {
        return {tabs: [] };
    },

    created() {

        this.tabs = this.$children;

    },
    methods: {
        selectTab(selectedTab) {
            this.tabs.forEach(tab => {
                tab.isActive = (tab.name == selectedTab.name);
            });
        }
    }
});

Vue.component('tab', {

    template: `

        <div v-show="isActive"><slot></slot></div>

    `,

    props: {
        name: { required: true },
        selected: { default: false}
    },

    data() {

        return {
            isActive: false
        };

    },

    computed: {

        href() {
            return '#' + this.name.toLowerCase().replace(/ /g, '-');
        }
    },

    mounted() {

        this.isActive = this.selected;

    }
});

const app = new Vue({
    el: '#app',
    store,
    router

});

