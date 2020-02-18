import Vue from 'vue';
import Router from 'vue-router';
import Login from './components/Login.vue';
import Admin from './components/Admin.vue';
import User from './components/User.vue';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: Login
    }, {
      path: '/admin',
      name: 'Admin',
      component: Admin
    }, {
      path: '/',
      name: 'User',
      component: User
    }
  ]
});