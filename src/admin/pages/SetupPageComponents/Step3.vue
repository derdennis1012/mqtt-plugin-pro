<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <h1 class="mb-4 mt-4">3. Topics</h1>
    <div class="d-flex align-items-center justify-content-between">
          <h5>Liste der Topics:</h5>
    </div>
    <div>
      <div
        class="shadow rounded bg-white m-1"
        v-for="(item, key) in data.topics"
        :key="'topic-key-' + key"
      >
        {{ item }}
      </div>
    </div>
    <div>
      <b-form-input v-model="text" placeholder="Topic hinzufügen"></b-form-input>
    </div>
    <b-button @click="data.topics.push(text)"> Add </b-button>
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
      text: ''
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
