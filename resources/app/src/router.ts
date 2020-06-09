import Vue from 'vue';
import VueRouter from 'vue-router';

import { authenticated } from './utils/authenticated';
import Admin from './views/Admin.vue';
import CreateOffer from './views/admin/CreateOffer.vue';
import Dashboard from './views/admin/Dashboard.vue';
import Dishes from './views/admin/Dishes.vue';
import Login from './views/admin/Login.vue';
import Logout from './views/admin/Logout.vue';
import Offers from './views/admin/Offers.vue';
import Orders from './views/admin/Orders.vue';
import Sales from './views/admin/Sales.vue';
import NotFound from './views/NotFound.vue';
import Public from './views/Public.vue';
import Home from './views/public/Home.vue';
import Menu from './views/public/Menu.vue';
import Tablet from './views/Tablet.vue';
import Overview from './views/tablet/Overview.vue';
import Register from './views/tablet/Register.vue';

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
      path: 'gerechten',
      component: Dishes,
      meta: {
        guard: [authenticated, '/kassa/login']
      }
    }, {
      path: 'verkopen',
      component: Sales,
      meta: {
        guard: [authenticated, '/kassa/login']
      }
    }, {
      path: 'bestellingen',
      component: Orders,
      meta: {
        guard: [authenticated, '/kassa/login']
      }
    }, {
      path: 'aanbiedingen',
      component: Offers,
      meta: {
        guard: [authenticated, '/kassa/login']
      }
    }, {
      path: 'aanbiedingen/maken/:offer?',
      component: CreateOffer,
      meta: {
        guard: [authenticated, '/kassa/login']
      }
    }, {
      path: 'login',
      component: Login
    }, {
      path: 'logout',
      component: Logout
    }]
  }, {
    path: '/tablet',
    component: Tablet,
    children: [{
      path: '/',
      component: Overview,
      meta: {
        guard: [authenticated, '/tablet/register']
      }
    }, {
      path: 'register',
      component: Register
    }]
  }, {
    path: '/',
    component: Public,
    children: [{
      path: '/',
      component: Home
    }, {
      path: 'menu',
      component: Menu
    }, {
      path: '*',
      component: NotFound
    }]
  }]
});
