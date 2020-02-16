<template>
  <router-view></router-view>
</template>

<script>
export default {
  mounted() {
    let root = "/login";
    this.$router.push({ path: root });
  }
};
</script>