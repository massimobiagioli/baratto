import router from "../router";
import BarattoApiClient from "../lib/baratto-api-client";

const barattoApiClient = new BarattoApiClient();

const moduleAuth = {
  namespaced: true,
  state: {
    accessToken: '',
    allowAdmin: false
  },
  mutations: {
    login(state, payload) {
      state.accessToken = payload.accessToken;
      state.allowAdmin = payload.allowAdmin;
    },
    logout(state, payload) {
      state.accessToken = '';
      state.allowAdmin = false;
    }
  },
  actions: {
    async login({
      commit
    }, payload) {      
      let loginData = await barattoApiClient.login(payload.email, payload.password);
      if (loginData) {
        commit('login', loginData);
        router.push({path: "/"});
      } else {
        commit('login', {
          accessToken: '',
          allowAdmin: false
        });
      }
    },
    async logout({
      commit
    }, payload) {
      await barattoApiClient.logout();
      commit('logout', {});
      router.push({path: "/login"});
    }
  }
};

export default moduleAuth;