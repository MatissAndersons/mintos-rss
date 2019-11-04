import Vue from 'vue';
import VeeValidate from 'vee-validate';

import { store } from './store';
import { router } from './router/router';
import App from './app/App';

Vue.use(VeeValidate);

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
