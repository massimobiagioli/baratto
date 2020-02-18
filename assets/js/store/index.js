import Vue from 'vue';
import Vuex from 'vuex';
import moduleAuth from './moduleAuth';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    auth: moduleAuth
  }
});