
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.fullcalendar = require('fullcalendar');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('home', require('./components/HomeComponent'));
Vue.component('tour', require('./components/TourComponent'));
Vue.component('user-availabilities', require('./components/UserAvailabilitiesComponent'));
Vue.component('search-substitute', require('./components/SearchSubstituteComponent'));
Vue.component('availability-edit', require('./components/AvailabilityEditComponent'));
Vue.component('booking-show', require('./components/BookingShowComponent'));
Vue.component('booking-edit', require('./components/BookingEditComponent'));
Vue.component('booking-create', require('./components/BookingCreateComponent'));
Vue.component('booking-request-show', require('./components/BookingRequestShowComponent'));
Vue.component('user-show', require('./components/UserShowComponent'));
Vue.component('user-edit', require('./components/UserEditComponent'));
Vue.component('nursery-show', require('./components/NurseryShowComponent'));
Vue.component('nursery-create', require('./components/NurseryCreateComponent'));
Vue.component('nursery-edit', require('./components/NurseryEditComponent'));
Vue.component('nursery-planning', require('./components/NurseryPlanningComponent'));
Vue.component('network-show', require('./components/NetworkShowComponent'));
Vue.component('network-create', require('./components/NetworkCreateComponent'));
Vue.component('network-edit', require('./components/NetworkEditComponent'));
Vue.component('notifications', require('./components/NotificationsComponent'));
Vue.component('ad-create', require('./components/AdCreateComponent'));

Vue.component('vue-table', require('./components/VueTable'));

const app = new Vue({
    el: '#app'
});

/**
 * Mobile navigation
 */
var fadeSpeed = 200;
$('.hamburger').click(function (e) {
    $(this).toggleClass('is-active');
    $('.nav-mobile').toggleClass('open').toggleClass('closed', !$('.nav-mobile').hasClass('open'));
    $('body').toggleClass('nav-mobile-open');
});
$('.nav-mobile').click(function (e) {
    $('.hamburger').toggleClass('is-active');
    $(this).toggleClass('open').toggleClass('closed', !$('.nav-mobile').hasClass('open'));
    $('body').removeClass('nav-mobile-open');
});