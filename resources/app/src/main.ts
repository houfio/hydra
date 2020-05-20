import 'normalize.css';
import Vue, { CreateElement } from 'vue';

import App from './App.vue';
import router from './router';
import store from './store';

new Vue({
  router,
  store,
  render: (h: CreateElement) => h(App)
}).$mount('#app');
