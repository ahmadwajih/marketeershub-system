import Vue from 'vue';
window.Vue = Vue;
require('./bootstrap');
Vue.prototype.$http = axios

import MhChart from './Components/MhChart'
import OffersAnalytics from './Components/OffersAnalytics'
import TeamAnalytics from './Components/TeamAnalytics'

Vue.component(MhChart.name, MhChart)
Vue.component(OffersAnalytics.name, OffersAnalytics)
Vue.component(TeamAnalytics.name, TeamAnalytics)

var app = new Vue({
    el: '#app',
})


