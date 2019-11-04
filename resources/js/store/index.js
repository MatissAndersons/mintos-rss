import Vue from 'vue';
import Vuex from 'vuex';

import { alert } from './alert';
import { account } from './account';
import { feeds } from './feeds';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        alert,
        account,
        feeds
    }
});
