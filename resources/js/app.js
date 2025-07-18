import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './router';


Vue.use(VueRouter);
Vue.prototype.$user = window.auth?.user || {};

/** 
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 * 
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('date-range-picker', DateRangePicker);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// Vue.component('footer-component', require('./components/website/partials/FooterComponent.vue').default);
// Vue.component('contact-component', require('./components/website/partials/ContactComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router, // Add router here
});
