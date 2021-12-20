<template>
  <div
    class="d-flex flex-column justify-content-between h-100"
    v-if="step == 3"
  >
    <h1 class="mb-4 mt-4">3. Topics</h1>

    <b-button variant="primary" block @click="checkNextStep"
      >Next Step</b-button
    >
  </div>
</template>
<script>
export default {
  name: "Step3",
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
