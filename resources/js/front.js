require('./bootstrap');

window.Vue = require('vue');
window.Axios = require('axios');

import VueRouter from 'vue-router';
import App from './views/App.vue';
import PageHome from './pages/PageHome.vue';
import PageAbout from './pages/PageAbout.vue';
import PageIndex from './pages/PageIndex.vue';
import PageShow from './pages/PageShow.vue';

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: PageHome,
        },
        {
            path: '/about',
            name: 'about',
            component: PageAbout,
        },
        {
            path: '/articles',
            name: 'articles',
            component: PageIndex,
        },
        {
            path: '/articles/:slug',
            name: 'details',
            component: PageShow,
            props: true,
        },
    ]
 });

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
});

