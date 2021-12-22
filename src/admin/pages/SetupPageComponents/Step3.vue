<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <h1 class="mb-4 mt-4">3. Topics</h1>
    <div>
      <div
        class="shadow rounded bg-white m-1"
        v-for="(item, key) in data.topics"
        :key="'topic-key-' + key"
      >
        {{ item }}
      </div>
    </div>
    <b-button @click="data.topics.push('hello122')"> Add </b-button>
    <div></div>
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
