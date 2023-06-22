import Vue from 'vue'
import App from './App.vue'
import router from './router'

import http from "./plugins/http.js";
import store from './store';

import { library } from "@fortawesome/fontawesome-svg-core";
import { faCartShopping, faTrashCan } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import 'bootstrap/dist/css/bootstrap.css';

library.add(faCartShopping, faTrashCan);

Vue.config.productionTip = false
Vue.use(http)
Vue.use(store);
Vue.component('paginacao', require('laravel-vue-pagination'));
Vue.component("font-awesome-icon", FontAwesomeIcon);

new Vue({
  router,
  store,
  render: function (h) { return h(App) }
}).$mount('#app')
