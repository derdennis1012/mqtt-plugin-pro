<!-- Edited by Lena Scheit, Dennis Bölling  -->
<template>
  <div class="home">
    <span>{{ msg }}</span>
    <BootstrapVueDatatable></BootstrapVueDatatable>
  </div>
</template>

<script>
import BootstrapVueDatatable from "../components/BootstrapVueDatatable.vue";
export default {
  name: "Home",
  components: {
    BootstrapVueDatatable,
  },
  data() {
    return {
      msg: "Welcome to Your Vue.js Admin App",
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
