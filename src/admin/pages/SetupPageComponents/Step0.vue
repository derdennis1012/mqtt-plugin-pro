<template>
  <div
    class="
        d-flex
        align-items-center
        justify-content-between
       
        flex-column
      "
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
    <h4 class="text-center mt-4 mb-4">But enough talking ...</h4>
    <b-button variant="primary" block @click="checkNextStep"
      >Let's get started 🚀</b-button
    >
    <h6 class="text-muted text-center mt-4">
      No worries, we will guide you step by step through this!
    </h6>
  </div>
</template>
<script>
export default {
  name: "Step0",
  props: ["image"],
  data() {
    return {
      dataObj: {},
    };
  },
  methods: {
    nextStep() {
      this.$emit("nextStep");
    },
    checkNextStep() {
      this.nextStep();
    },
  },
  created() {
    var self = this;
  },
};
</script>
