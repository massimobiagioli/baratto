import Vue from 'vue';
import App from './components/App';
import vuetify from 'vuetify';
import router from './router';
import store from './store';

new Vue({
  vuetify,
  router,
  store,
  render: h => h(App)
}).$mount('#app');