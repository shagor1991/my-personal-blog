require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import {routes} from './routes'
import { Form, HasError, AlertError } from 'vform'
import VueProgressBar from 'vue-progressbar'

import Snotify, { SnotifyPosition } from 'vue-snotify'

const snotifyOptions = {
  toast: {
    position: SnotifyPosition.rightTop
  }
}

Vue.use(Snotify, snotifyOptions)

window.Form= Form
Vue.use(VueRouter)
const router = new VueRouter({
    routes // short for `routes: routes`
})

const VueProgressBarOptions = {
    color: 'green',
    failedColor: 'red',
    thickness: '5px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}
  
Vue.use(VueProgressBar, VueProgressBarOptions)



Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('admin-home', require('./components/AdminHome.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('pagination', require('./components/PaginationComponent.vue').default);



Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
const app = new Vue({
    router,
    el: '#app',
});
