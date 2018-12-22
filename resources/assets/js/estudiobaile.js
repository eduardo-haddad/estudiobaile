//Vue
import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);
window.Vue = Vue;

//Axios
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//jQuery
try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

//Select2
import select2 from 'select2';
window.select2 = select2;

//Lightbox
import lightbox from 'lightbox2';
window.lightbox = lightbox;

//Quill - Vue
Vue.component('editor', require('./components/Quill'));
import quill from 'quill';
window.quill = quill;

// import bootstrap from 'bootstrap';
// window.bootstrap = bootstrap;

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/* Vue */

//vue-router
import router from './routes';
//components
import modal from './components/modal_novo_registro';
//event bus
export const eventBus = new Vue();

//main instance
new Vue({
    el: '#app',
    router: router,
    components: {
        modal,
    },
    data: {
        showModal: false
    }
});