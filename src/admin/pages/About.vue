<!-- Edited by Lena Scheit, Dennis Bölling  -->
<template>
  <div class="container">
    <img :src="aboutIMG" width="100%" height="auto" />
    <div class="mt-3">
      <h2 class="text-center">Ready?</h2>
      <router-link> </router-link
      ><b-button
        block
        variant="primary"
        href="admin.php?page=mqtt-plugin-pro#/setup"
        >Go to Setup</b-button
      >
      <b-button
        block
        variant="danger"
        class="mt-3"
        href="admin.php?page=mqtt-plugin-pro#/api-docs"
        >Go to API Docs</b-button
      >
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    aboutIMG: require("../../assets/img/about.png"),
  }),
  props: {},
  methods: {},
};
</script>
