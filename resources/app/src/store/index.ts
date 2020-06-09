import Vue from 'vue';
import Vuex, { Store } from 'vuex';
import VuexPersistence from 'vuex-persist';

import auth from './auth';
import notification from './notification';

Vue.use(Vuex);

export default new Store<any>({
  modules: {
    auth,
    notification
  },
  plugins: [new VuexPersistence({
    storage: window.localStorage,
    modules: [
      'auth'
    ]
  }).plugin]
});
