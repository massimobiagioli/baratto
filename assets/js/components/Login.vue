<template>
  <div>
    <h3>Login</h3>
    <div>
      <span>Email:</span>
      <input type="text" v-model="email" />
    </div>
    <div>
      <span>Password:</span>
      <input type="password" v-model="password" />
    </div>
    <div>
      <button @click="login()">Login</button>
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
