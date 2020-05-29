import 'normalize.css';
import Vue, { CreateElement } from 'vue';

import App from './App.vue';
import router from './router';
import store from './store';

router.beforeEach((to, from, next) => {
  const guard = to.meta.guard;

  if (!guard || guard[0]()) {
    return next();
  }

  next({
    path: guard[1],
    query: {
      redirect: to.fullPath
    }
  });
});

new Vue({
  router,
  store,
  render: (h: CreateElement) => h(App)
}).$mount('#app');
