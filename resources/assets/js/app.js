/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window._ = require('lodash');

window.Vue = require('vue');

window.VueEvent = new Vue({});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('google-places-picker', require('./components/GooglePlacesComponent.vue'));
Vue.component('datepicker', require('./components/DatepickerComponent.vue'));
Vue.component('flatPickr', require("flatpickr"));

Vue.component('offers-list', require("./components/OffersListComponent.vue"));
Vue.component('address-map', require("./components/AddressMap.vue"));

window.app = new Vue({
    el: '#app',
    mounted(){

    },
    methods: {
        initGooglePlacesAutocomplete: function () {
            VueEvent.$emit('initGooglePlacesAutocomplete', {some: "value"});
        }
    },
});
