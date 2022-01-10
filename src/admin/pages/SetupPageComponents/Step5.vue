<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <h1 class="mb-4 mt-4">
      <span @click="$emit('goBack')">
        <font-awesome-icon class="mr-3" :icon="['fal', 'chevron-left']" /></span
      >5. Setup done
    </h1>

    <b-button variant="success" block @click="checkNextStep">Finish</b-button>
  </div>
</template>
<script>
export default {
  name: "Step5",
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
