import Vue from 'vue';
import Vuex, { Store } from 'vuex';

import auth from './auth';

Vue.use(Vuex);

export default new Store({
  modules: {
    auth
  }
});
