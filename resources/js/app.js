require('./bootstrap');

window.Vue = require('vue');


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('admin-home', require('./components/AdminHome.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);

const app = new Vue({
    el: '#app',
});
