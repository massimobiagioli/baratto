<template>
  <div>
    Admin
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
export default {
  name: "Admin",
  data: () => ({
    email: "",
    password: ""
  }),
  mounted() {
    if (this.accessToken == '' || !this.allowAdmin) {
      this,$routes.push({ path: "/login" });
    }
  },
  methods: {
    
  },
  computed: {
    ...mapState('counter', {
      accessToken: state => state.accessToken,
      allowAdmin: state => state.allowAdmin
    })
  }
};
</script>
