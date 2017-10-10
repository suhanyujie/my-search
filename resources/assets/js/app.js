
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// window.Vue.component('example', require('./components/Example.vue'));
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import Example from './components/Example.vue'
import Index from './components/Index/index.vue'
import axios from 'axios'

Vue.use(ElementUI)
Vue.prototype.$http = axios


const app = new window.Vue({
    name: 'rootApp',
    components: {
        Example,Index
    },
    el: '#app'
    // render: h => h(App)
});
