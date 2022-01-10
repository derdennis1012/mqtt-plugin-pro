<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <h1 class="mb-4 mt-4">
      <span @click="$emit('goBack')">
        <font-awesome-icon class="mr-3" :icon="['fal', 'chevron-left']" /></span
      >1. Info
    </h1>
    <div class="scroll-y overflow-auto">
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce leo
        ligula, placerat id posuere sed, pharetra at urna. Phasellus at sem quis
        magna tincidunt blandit. Donec porta lectus a nunc mattis tristique.
        Proin commodo condimentum dolor ut commodo. Praesent viverra lacinia
        mollis. Proin facilisis faucibus massa sed varius. Curabitur pharetra
        volutpat venenatis. Vestibulum aliquet vitae lacus ac pretium.
        Vestibulum id auctor lacus, eget ornare felis.
      </p>
      <p>
        Duis nec ultricies lacus, quis elementum ante. Aenean congue, diam non
        commodo suscipit, dui purus vehicula ante, at convallis risus urna quis
        dolor. Nam leo arcu, feugiat nec nulla ac, gravida lacinia tortor.
        Mauris euismod, libero in pharetra condimentum, ipsum eros consectetur
        quam, non laoreet magna quam ac augue. Fusce maximus interdum urna sed
        vestibulum. Duis at varius arcu, sed luctus augue. Pellentesque
        placerat, sapien id sagittis ultricies, purus nunc tempus nulla, non
        rutrum massa augue sed risus. Praesent diam nisi, suscipit in dolor nec,
        congue vehicula tellus. Maecenas nec tellus eget ex facilisis porttitor.
        Ut viverra orci in ultrices aliquam.
      </p>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce leo
        ligula, placerat id posuere sed, pharetra at urna. Phasellus at sem quis
        magna tincidunt blandit. Donec porta lectus a nunc mattis tristique.
        Proin commodo condimentum dolor ut commodo. Praesent viverra lacinia
        mollis. Proin facilisis faucibus massa sed varius. Curabitur pharetra
        volutpat venenatis. Vestibulum aliquet vitae lacus ac pretium.
        Vestibulum id auctor lacus, eget ornare felis.
      </p>
      <p>
        Duis nec ultricies lacus, quis elementum ante. Aenean congue, diam non
        commodo suscipit, dui purus vehicula ante, at convallis risus urna quis
        dolor. Nam leo arcu, feugiat nec nulla ac, gravida lacinia tortor.
        Mauris euismod, libero in pharetra condimentum, ipsum eros consectetur
        quam, non laoreet magna quam ac augue. Fusce maximus interdum urna sed
        vestibulum. Duis at varius arcu, sed luctus augue. Pellentesque
        placerat, sapien id sagittis ultricies, purus nunc tempus nulla, non
        rutrum massa augue sed risus. Praesent diam nisi, suscipit in dolor nec,
        congue vehicula tellus. Maecenas nec tellus eget ex facilisis porttitor.
        Ut viverra orci in ultrices aliquam.
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
      >Next Step</b-button
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
