import Vue from 'vue';
window.Vue = Vue;
require('./bootstrap');
Vue.prototype.$http = axios

import MhChart from './Components/MhChart'

Vue.component(MhChart.name, MhChart)

var app = new Vue({
    el: '#app',
})


