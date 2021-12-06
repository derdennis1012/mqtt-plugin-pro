<template>
  <div class="app-settings container">
    <div
      class="
        d-flex
        align-items-center
        justify-content-between
        h-100
        flex-column
      "
      v-if="step == 1"
    >
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
      <b-button variant="primary" block @click="step = 2"
        >Let's get started 🚀</b-button
      >
      <h6 class="text-muted text-center mt-4">
        No worries, we will guide you step by step through this!
      </h6>
    </div>
    <div
      class="d-flex align-items-center justify-content-between"
      v-if="step > 1"
    >
      <div @click="step = 2">
        <span
          :class="`${step == 2 ? 'text-primary' : ''} ${
            step > 1 ? '' : 'text-muted'
          }`"
          >1. Info</span
        >
      </div>
      <div class="setup-line"></div>
      <div @click="step = 3">
        <span
          :class="`${step == 3 ? 'text-primary' : ''} ${
            step > 2 ? '' : 'text-muted'
          }`"
          >2. MQTT Broker</span
        >
      </div>
      <div class="setup-line"></div>

      <div @click="step = 4">
        <span
          :class="`${step == 4 ? 'text-primary' : ''} ${
            step > 3 ? '' : 'text-muted'
          }`"
          >3. Topics</span
        >
      </div>
      <div class="setup-line"></div>

      <div @click="step = 5">
        <span
          :class="`${step == 5 ? 'text-primary' : ''} ${
            step > 4 ? '' : 'text-muted'
          }`"
          >4. Misc</span
        >
      </div>
      <div class="setup-line"></div>

      <div>
        <span
          :class="`${step == 6 ? 'text-primary' : ''} ${
            step > 5 ? '' : 'text-muted'
          }`"
          >5. Setup done</span
        >
      </div>
    </div>
    <div
      class="d-flex flex-column justify-content-between h-100"
      v-if="step == 2"
    >
      <h1 class="mb-4 mt-4">1. Info</h1>

      <b-button variant="primary" block @click="step = step + 1"
        >Next Step</b-button
      >
    </div>
    <div
      class="d-flex flex-column justify-content-between h-100"
      v-if="step == 3"
    >
      <h1 class="mb-4 mt-4">2. MQTT Broker</h1>

      <b-button variant="primary" block @click="step = step + 1"
        >Next Step</b-button
      >
    </div>
    <div
      class="d-flex flex-column justify-content-between h-100"
      v-if="step == 4"
    >
      <h1 class="mb-4 mt-4">3. Topics</h1>

      <b-button variant="primary" block @click="step = step + 1"
        >Next Step</b-button
      >
    </div>
    <div
      class="d-flex flex-column justify-content-between h-100"
      v-if="step == 5"
    >
      <h1 class="mb-4 mt-4">4. Misc</h1>

      <b-button variant="primary" block @click="step = step + 1"
        >Next Step</b-button
      >
    </div>
    <div
      class="d-flex flex-column justify-content-between h-100"
      v-if="step == 6"
    >
      <h1 class="mb-4 mt-4">5. Setup done</h1>

      <b-button variant="success" block>Finish</b-button>
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
      step: 1,
      connectionWorks: false,
      image: require("../../assets/img/mqtt-pro-logo.png"),
    };
  },
  methods: {
    checkConncetion() {},
    saveData() {
      console.log(this.settingsData);
    },
  },
};
</script>

<style lang="css" scoped>
</style>
