<template>
  <div class="app-settings container">
    <div class="d-flex align-items-center justify-content-center flex-column">
      <h1 class="text-center fat-heading mb-4 mt-4">Howdy my MQTT friend 👋</h1>

      <h3 class="text-center mt-4">
        We're so glad that you've downloaded our plugin!
      </h3>
      <b-img
        class="text-center mt-3 mb-3"
        :src="image"
        fluid
        alt="Responsive image"
        center
        width="270"
      ></b-img>
      <h4 class="text-center mt-4 mb-4">But enough of talking ...</h4>
      <b-button variant="primary" block>Let's get started 🚀</b-button>
      <h6 class="text-muted text-center mt-4">
        No worries, we will guide you step by step through this!
      </h6>
    </div>
  </div>
</template>
<!--
  @Vue-Bootsrap DOC
  https://bootstrap-vue.org/docs

  @BoostrapDoc
  https://getbootstrap.com/docs/4.1/getting-started/introduction/

  @Validation
  https://vee-validate.logaretm.com/v4/
 -->
<script>
export default {
  name: "Settings",

  data() {
    return {
      settingsData: {},
      image: require("./mqtt-pro-logo.png"),
    };
  },
  methods: {
    saveData() {
      console.log(this.settingsData);
    },
  },
};
</script>

<style lang="css" scoped>
</style>
