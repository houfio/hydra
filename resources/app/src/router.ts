import Vue from 'vue';
import VueRouter from 'vue-router';

import { authenticated } from './utils/authenticated';
import Admin from './views/Admin.vue';
import Dashboard from './views/admin/Dashboard.vue';
import Login from './views/admin/Login.vue';
import NotFound from './views/NotFound.vue';
import Public from './views/Public.vue';
import Home from './views/public/Home.vue';

Vue.use(VueRouter);

export default new VueRouter({
  mode: 'history',
  base: '/',
  routes: [{
    path: '/kassa',
    component: Admin,
    children: [{
      path: '/',
      component: Dashboard,
      meta: {
        guard: [authenticated, '/kassa/login']
      }
    }, {
      path: 'login',
      component: Login
    }]
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
