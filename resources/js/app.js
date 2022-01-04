import Vue from 'vue';
window.Vue = Vue;
require('./bootstrap');
Vue.prototype.$http = axios

import MhChart from './Components/MhChart'
import OffersMarketShare from './Components/OffersMarketShare'

Vue.component(MhChart.name, MhChart)
Vue.component(OffersMarketShare.name, OffersMarketShare)

var app = new Vue({
    el: '#app',
})


