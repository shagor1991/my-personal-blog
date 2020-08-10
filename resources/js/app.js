require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import {routes} from './routes'
Vue.use(VueRouter)
const router = new VueRouter({
    routes // short for `routes: routes`
})

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('admin-home', require('./components/AdminHome.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);

const app = new Vue({
    router,
    el: '#app',
});
