<template>
  <div
    class="d-flex flex-column justify-content-between h-100"
    v-if="step == 4"
  >
    <h1 class="mb-4 mt-4">4. Misc</h1>

    <b-button variant="primary" block @click="checkNextStep"
      >Next Step</b-button
    >
  </div>
</template>
<script>
export default {
  name: "Step4",
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
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
