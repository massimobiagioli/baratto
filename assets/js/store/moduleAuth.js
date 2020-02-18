import router from "../router";
import BarattoApiClient from "../lib/baratto-api-client";

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
    }
  },
  actions: {
    async login({ commit }, payload) {      
      const barattoApiClient = new BarattoApiClient();
      let loginData = await barattoApiClient.login(payload.email, payload.password);
      if (loginData) {
        commit('login', loginData);
        router.push({ path: "/user" });
      }
    }
  }
};

export default moduleAuth;