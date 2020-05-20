import Vue from 'vue';
import VueRouter from 'vue-router';

import Admin from '../views/Admin.vue';
import Home from '../views/Public.vue';

Vue.use(VueRouter);

export default new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [{
    path: '/kassa',
    name: 'Admin',
    component: Admin
  }, {
    path: '/',
    name: 'Home',
    component: Home
  }]
});
