import Vue from 'vue';
import VueRouter from 'vue-router';

import { authenticated } from './utils/authenticated';
import Admin from './views/Admin.vue';
import Dashboard from './views/admin/Dashboard.vue';
import Dish from './views/admin/Dish.vue';
import Dishes from './views/admin/Dishes.vue';
import Login from './views/admin/Login.vue';
import Logout from './views/admin/Logout.vue';
import Offer from './views/admin/Offer.vue';
import Offers from './views/admin/Offers.vue';
import Orders from './views/admin/Orders.vue';
import Sales from './views/admin/Sales.vue';
import Type from './views/admin/Type.vue';
import Types from './views/admin/Types.vue';
import NotFound from './views/NotFound.vue';
import Public from './views/Public.vue';
import Contact from './views/public/Contact.vue';
import Home from './views/public/Home.vue';
import Menu from './views/public/Menu.vue';
import News from './views/public/News.vue';
import Tablet from './views/Tablet.vue';
import History from './views/tablet/History.vue';
import Order from './views/tablet/Order.vue';
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
      path: 'gerechten/:id',
      component: Dish,
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
      path: 'aanbiedingen/:id',
      component: Offer,
      meta: {
        guard: [authenticated, '/kassa/login']
      }
    }, {
      path: 'types',
      component: Types,
      meta: {
        guard: [authenticated, '/kassa/login']
      }
    }, {
      path: 'types/:id',
      component: Type,
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
      path: 'bestellen',
      component: Order,
      meta: {
        guard: [authenticated, '/tablet/register']
      }
    }, {
      path: 'geschiedenis',
      component: History,
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
      path: 'nieuws',
      component: News
    }, {
      path: 'contact',
      component: Contact
    }, {
      path: '*',
      component: NotFound
    }]
  }]
});
