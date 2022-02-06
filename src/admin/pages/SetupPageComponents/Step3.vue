<!-- Edited by Lena Scheit, Dennis Bölling  -->
<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <div>
      <h1 class="mb-4 mt-4">
        <span @click="$emit('goBack')">
          <font-awesome-icon
            class="mr-3"
            :icon="['fal', 'chevron-left']" /></span
        >3. Topics
      </h1>
      <div class="d-flex align-items-center justify-content-between"></div>
      <validation-observer ref="simpleRules">
        <div>
          <h5>List of Topics:</h5>
          <h6 class="text-muted">
            Examples are <b>sensor-value-1</b> or subtobic
            <b>sensors/pool/value</b>
          </h6>
          <b-row>
            <b-col sm="9">
              <b-form-group>
                <validation-provider
                  rules="required|regex:^\S*[^\/\s]$"
                  #default="{ errors }"
                  name="Topic"
                >
                  <b-form-input
                    v-model="text"
                    placeholder="Add topic"
                    @keyup.enter="addItem"
                    :state="errors.length > 0 ? false : null"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
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
            <ul class="list-group scroll-it">
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
      </validation-observer>
    </div>
    <b-button
      variant="primary"
      block
      @click="checkNextStep"
      :disabled="(data.topics || []).length < 1"
      >Next step</b-button
    >
  </div>
</template>
<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";

export default {
  name: "Step3",
  components: {
    ValidationProvider,
    ValidationObserver,
  },
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
    async addItem() {
      var self = this;

      if (self.text == "") alert("Topic can not be empty!");
      else {
        var res = await this.$refs.simpleRules.validate();
        if (res) {
          self.data.topics.push(self.text);
          self.text = "";
        } else {
          alert("Wrong Topic format, please try again!");
        }
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
