<!-- Edited by Lena Scheit, Dennis Bölling  -->
<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <h1 class="mb-4 mt-4">
      <span @click="$emit('goBack')">
        <font-awesome-icon class="mr-3" :icon="['fal', 'chevron-left']" /></span
      >1. Info
    </h1>
    <div class="scroll-y overflow-auto">
      <p>
        By accepting these General Terms during your account registration or
        subscription process, or by accessing or using our Offerings, you
        confirm your acceptance of these General Terms and other applicable
        Terms and your agreement to be a party to this binding contract. If you
        do not agree, you do not have the right to access or use our Offerings.
      </p>
      <p>
        You agree to these Terms on behalf of the company or other legal entity
        for which you are acting (for example, as an employee or contractor) or,
        if there is no company or legal entity, on behalf of yourself as an
        individual (in either case, “You”). You represent and warrant that you
        have the right and authority (as well as the capacity—for example, you
        are of sufficient legal age) to act on behalf of and bind such entity
        (if any) and yourself.
      </p>
    </div>
    <div>
      <b-form-checkbox
        id="checkbox-1"
        v-model="data.acceptedTerms"
        name="checkbox-1"
      >
        I accept the terms and use
      </b-form-checkbox>
    </div>
    <b-button
      v-if="data.acceptedTerms"
      variant="primary"
      block
      @click="checkNextStep()"
      >Next step</b-button
    >
    <b-button v-else variant="primary" block disabled
      >You have to accept the terms</b-button
    >
  </div>
</template>
<script>
export default {
  name: "Step1",
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
      this.testPassed = true;

      this.nextStep();
    },
  },
  created() {
    var self = this;
  },
};
</script>
