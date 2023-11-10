import Vue from 'vue'
import _ from 'lodash';
import App from '@/App.vue';
import router from '@/router'
import '@/assets/css/tailwind.css'
import VueNotify from 'vue-notifyjs';

import localStorageService from '@/services/localStorage';
import notificationService from '@/services/notification';
import authService from '@/services/auth';

import env from './env';

Vue.config.productionTip = false;

require('@/bootstrap');

Vue.use(VueNotify);

Vue.prototype.$lodash = _;

Vue.prototype.$env = env;

Vue.prototype.$auth = authService;
Vue.prototype.$notification = notificationService;
Vue.prototype.$localStorage = localStorageService;

window.$ = window.jQuery = require('jquery');

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
});
window.app = app;
