<template>
  <div id="vue-backend-app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: "App",
  created() {
    console.log(this.$parent);
  },
};
</script>

<style></style>
