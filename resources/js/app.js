import Vue from 'vue';
window.Vue = Vue;
require('./bootstrap');
Vue.prototype.$http = axios

import MhChart from './Components/MhChart'
import OffersOrders from './Components/OffersOrders'

Vue.component(MhChart.name, MhChart)
Vue.component(OffersOrders.name, OffersOrders)

var app = new Vue({
    el: '#app',
})


