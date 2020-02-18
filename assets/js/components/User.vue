<template>
  <div class="row">
    <div class="col s12 m6">
      <div class="card">
        <div class="card-content">
          Area Utente ...
        </div>
        <div class="card-action">
          
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: "User",
  mounted() {
    if (this.accessToken == '' || !this.allowAdmin) {
      this.$router.push({ path: "/login" });
    }
  },
  methods: {
  },
  computed: {
    ...mapState('auth', {
      accessToken: state => state.accessToken,
      allowAdmin: state => state.allowAdmin
    })
  }
};
</script>
