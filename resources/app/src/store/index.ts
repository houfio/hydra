import Vue from 'vue';
import Vuex, { Store } from 'vuex';
import VuexPersistence from 'vuex-persist';

import auth from './auth';

Vue.use(Vuex);

export default new Store({
  modules: {
    auth
  },
  plugins: [new VuexPersistence({
    storage: window.localStorage,
    modules: [
      'auth'
    ]
  }).plugin]
});
