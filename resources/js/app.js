/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import DatePicker from 'vue-md-date-picker'
import VueRouter from 'vue-router'
import VueThinModal from 'vue-thin-modal'
import 'vue-thin-modal/dist/vue-thin-modal.css'
import excel from 'vue-excel-export'
require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
export const bus = new Vue();

Vue.component('report-component', require('./components/ReportComponent.vue').default);
Vue.component('main-report-component', require('./components/MainReportComponent.vue').default);
Vue.component('demo', require('./components/mainReport.vue').default);
Vue.component('modal-new', require('./components/NewModalComponent').default);
Vue.component('datepicker', DatePicker);
Vue.use(VueRouter);
Vue.use(VueThinModal);
Vue.use(excel);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
