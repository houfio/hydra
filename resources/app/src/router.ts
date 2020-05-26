import Vue from 'vue';
import VueRouter from 'vue-router';

import Admin from './views/Admin.vue';
import Home from './views/Home.vue';
import NotFound from './views/NotFound.vue';
import Public from './views/Public.vue';

Vue.use(VueRouter);

export default new VueRouter({
  mode: 'history',
  base: '/',
  routes: [{
    path: '/kassa',
    component: Admin
  }, {
    path: '/',
    component: Public,
    children: [{
      path: '/',
      component: Home
    }, {
      path: '*',
      component: NotFound
    }]
  }]
});
