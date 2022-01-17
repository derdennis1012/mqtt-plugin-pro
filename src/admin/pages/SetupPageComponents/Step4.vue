<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <div>
      <h1 class="mb-4 mt-4">
        <span @click="$emit('goBack')">
          <font-awesome-icon
            class="mr-3"
            :icon="['fal', 'chevron-left']" /></span
        >4. Misc
      </h1>
      <validation-observer ref="simpleRules">
        <div>
          <h5>Interval</h5>
          <span class="text-muted"
            >This is the interval in which the <b>MQTT Plugin Pro</b> tries to
            receive data from the MQTT Broker.</span
          >

          <b-form-group label="Interval" class="mt-2">
            <validation-provider
              #default="{ errors }"
              name="Interval"
              rules="required"
            >
              <v-select
                :options="timeIntervals"
                v-model="data.interval"
                :reduce="(item) => item.key"
                @option:selected="checkForm()"
                @input="checkForm()"
                :state="errors.length > 0 ? false : null"
                placeholder="Interval"
                :clearable="false"
              ></v-select>
              <small class="text-danger">{{ errors[0] }}</small>
            </validation-provider>
          </b-form-group>
        </div>
        <div class="mt-4">
          <h5>TTL - time to live</h5>
          <span class="text-muted"
            >This is the time how long the <b>MQTT Plugin Pro</b> stores the
            MQTT Data. After this time it will be automatically deleted.</span
          >
          <div class="d-flex align-items-center justify-content-between">
            <div
              :class="`shadow-sm p-3 bg-white  border-secondary  rounded-lg border-card m-2 ${
                data.keepData ? 'border-primary border-card-lg' : ''
              } w-100`"
              @click="changeTTL(true)"
            >
              <div class="d-flex align-items-center">
                <b-avatar variant="light-primary" class="mr-2">
                  <font-awesome-icon :icon="['fad', 'database']" /></b-avatar
                >Keep my Data forever
              </div>
            </div>
            <div
              :class="`shadow-sm p-3 bg-white rounded-lg border-card m-2  border-secondary ${
                data.keepData === false ? 'border-primary border-card-lg' : ''
              } w-100`"
              @click="changeTTL(false)"
            >
              <div class="d-flex align-items-center">
                <b-avatar variant="light-primary" class="mr-2">
                  <font-awesome-icon :icon="['fad', 'trash']" /></b-avatar
                >Automatically delete my Data
              </div>
            </div>
          </div>
          <b-form-group
            label="TTL (days)"
            class="mt-2"
            v-if="data.keepData === false"
          >
            <validation-provider
              #default="{ errors }"
              name="Interval"
              rules="required"
            >
              <b-form-input
                @input="checkForm()"
                v-model="data.ttl"
                label="Test"
                :state="errors.length > 0 ? false : null"
                placeholder="TTL (days)"
              />
              <small class="text-danger">{{ errors[0] }}</small>
            </validation-provider>
          </b-form-group>
        </div>
      </validation-observer>
    </div>

    <b-button
      variant="primary"
      block
      @click="checkNextStep"
      :disabled="!data.testPassed"
      >Next step</b-button
    >
  </div>
</template>
<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { required } from "../../validations/validations";
import "vue-select/dist/vue-select.css";

export default {
  name: "Step4",
  components: { ValidationProvider, ValidationObserver },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      dataObj: {},
      required,
    };
  },
  methods: {
    nextStep() {
      this.$emit("nextStep");
    },
    async checkForm() {
      var self = this;
      var res = false;
      try {
        res = await self.$refs.simpleRules.validate();
      } catch (e) {
        console.log(e);
        res = false;
      }
      res = true;
      if (!self.data.interval) res = false;
      if (!self.data.ttl && !self.data.keepData) res = false;
      self.$set(self.data, "testPassed", res);
      return res;
    },
    checkNextStep() {
      this.nextStep();
    },
    changeTTL(val) {
      this.data.keepData = val;
      this.checkForm();
      this.checkForm();
    },
  },
  created() {
    var self = this;
    setTimeout(() => {
      self.checkForm();
    }, 500);
  },
};
</script>
