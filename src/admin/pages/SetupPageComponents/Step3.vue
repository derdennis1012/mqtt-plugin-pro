<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <div>
      <h1 class="mb-4 mt-4">3. Topics</h1>
      <div class="d-flex align-items-center justify-content-between"></div>
      <div>
        <h5>Liste der Topics:</h5>

        <b-row>
          <b-col sm="9">
            <b-form-group>
              <b-form-input
                v-model="text"
                placeholder="Add topic"
                @keyup.enter="addItem"
              />
            </b-form-group>
          </b-col>
          <b-col sm="3">
            <div class="">
              <b-button variant="success" block @click="addItem">
                Add
              </b-button>
            </div>
          </b-col>
        </b-row>
        <div>
          <ul class="list-group">
            <li
              class="list-group-item my-2 border rounded"
              v-for="(item, key) in data.topics"
              :key="'topic-key-' + key"
            >
              <div class="d-flex align-items-center justify-content-between">
                <b> {{ item }}</b>
                <font-awesome-icon
                  @click="deleteItem(key)"
                  :icon="['fad', 'times']"
                  class="text-danger"
                />
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <b-button variant="primary" block @click="checkNextStep"
      >Next Step</b-button
    >
  </div>
</template>
<script>
export default {
  name: "Step3",
  components: {},
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      dataObj: {},
      text: "",
    };
  },
  methods: {
    addItem() {
      var self = this;
      if (self.text == "") alert("Bisch du behindert?");
      else {
        self.data.topics.push(self.text);
        self.text = "";
      }
    },
    deleteItem(idx) {
      var self = this;
      console.log("sss");

      self.data.topics.splice(idx, 1);
      console.log(self.data.topics);
    },
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
