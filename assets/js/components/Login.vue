<template>
  <div class="row">
    <div class="col s12 m6">
      <div class="card">
        <div class="card-content">
          <span class="card-title">Login</span>
          <div class="row">
            <form class="col s12">
              <div class="row">
                <div class="input-field col s12">
                  <input id="email" type="email" class="validate" v-model="email">
                  <label for="email">Email</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="password" type="password" class="validate" v-model="password">
                  <label for="password">Password</label>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-action">
          <a class="waves-effect waves-light btn" @click="login()">login</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BarattoApiClient from "../lib/baratto-api-client";
export default {
  data: () => ({
    email: "",
    password: ""
  }),
  methods: {
    async login() {
      const barattoApiClient = new BarattoApiClient();
      let loginData = await barattoApiClient.login(this.email, this.password);

      // TODO: memorizzare informazioni nello store

      this.$router.push({ path: "/user" });
    }
  }
};
</script>
