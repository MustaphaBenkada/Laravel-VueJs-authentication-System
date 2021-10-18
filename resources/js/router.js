import Vue from 'vue';
import VueRouter from 'vue-router';

import Board from './pages/Board.vue';
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Welcome from './pages/Welcome.vue';


Vue.use(VueRouter);

const router = new VueRouter({
    base: "/vueApp/public/",
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [

        {
            path: '/',
            name: '/',
            component: Welcome
        },
        {
            path: '/',
            name: 'welcome',
            component: Welcome
        },
        {
            path: '/board',
            name: 'board',
            component: Board
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        
    ]
});

export default router;