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
          <a class="waves-effect waves-light btn" @click="login({email, password})">login</a>          
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
export default {
  name: "Login",
  data: () => ({
    email: "",
    password: ""
  }),
  methods: {
    ...mapActions('auth', [
      'login'
    ])
  },
  computed: {
    ...mapState('auth', {
      accessToken: state => state.accessToken
    })
  }
};
</script>
