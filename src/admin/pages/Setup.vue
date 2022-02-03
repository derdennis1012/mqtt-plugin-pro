<!-- Edited by Lena Scheit, Dennis Bölling  -->
<template>
  <div class="app-settings container h-100 fh">
    <div
      class="d-flex align-items-center justify-content-between"
      v-if="step > 1"
    >
      <div>
        <b-spinner
          v-if="step == 1"
          small
          label="Small Spinner"
          variant="primary"
          class="mr-1"
        ></b-spinner>
        <span
          :class="`${step == 1 ? 'text-primary' : ''} ${
            step > 1 ? '' : 'text-muted'
          }`"
          >1. Info</span
        >
      </div>
      <div class="setup-line"></div>
      <div>
        <b-spinner
          v-if="step == 2"
          small
          label="Small Spinner"
          variant="primary"
          class="mr-1"
        ></b-spinner
        ><span
          :class="`${step == 2 ? 'text-primary' : ''} ${
            step > 2 ? '' : 'text-muted'
          }`"
          >2. MQTT Broker</span
        >
      </div>
      <div class="setup-line"></div>

      <div>
        <b-spinner
          v-if="step == 3"
          small
          label="Small Spinner"
          variant="primary"
          class="mr-1"
        ></b-spinner
        ><span
          :class="`${step == 3 ? 'text-primary' : ''} ${
            step > 3 ? '' : 'text-muted'
          }`"
          >3. Topics</span
        >
      </div>
      <div class="setup-line"></div>

      <div>
        <b-spinner
          v-if="step == 4"
          small
          label="Small Spinner"
          variant="primary"
          class="mr-1"
        ></b-spinner
        ><span
          :class="`${step == 4 ? 'text-primary' : ''} ${
            step > 4 ? '' : 'text-muted'
          }`"
          >4. Additional</span
        >
      </div>
      <div class="setup-line"></div>

      <div>
        <span
          :class="`${step == 5 ? 'text-primary' : ''} ${
            step > 5 ? '' : 'text-muted'
          }`"
          >5. Setup done</span
        >
      </div>
    </div>
    <Step0 v-if="step == 0" :image="image" :data="{}" @nextStep="step++" />
    <Step1
      v-if="step == 1"
      :data="steps[1]"
      @nextStep="step++"
      @goBack="step--"
    />
    <Step2
      v-if="step == 2"
      :loaderImage="loaderImage"
      :data="steps[2]"
      @nextStep="step++"
      :errorImage="errorImage"
      :successImage="successImage"
      @goBack="step--"
    />
    <Step3
      v-if="step == 3"
      :data="steps[3]"
      @nextStep="step++"
      @goBack="step--"
    />
    <Step4
      v-if="step == 4"
      :data="steps[4]"
      @nextStep="step++"
      @goBack="step--"
    />
    <Step5
      v-if="step == 5"
      :data="steps"
      @nextStep="() => {}"
      @goBack="step--"
      :congrats="congrats"
    />
  </div>
</template>
<!--
  @Vue-Bootsrap DOC
  https://bootstrap-vue.org/docs

  @BoostrapDoc
  https://getbootstrap.com/docs/4.1/getting-started/introduction/

  @Validation
  https://vee-validate.logaretm.com/v4/
 -->
<script>
import Step0 from "./SetupPageComponents/Step0.vue";
import Step1 from "./SetupPageComponents/Step1.vue";
import Step2 from "./SetupPageComponents/Step2.vue";
import Step3 from "./SetupPageComponents/Step3.vue";
import Step4 from "./SetupPageComponents/Step4.vue";
import Step5 from "./SetupPageComponents/Step5.vue";

export default {
  name: "Setup",
  components: {
    Step0,
    Step1,
    Step2,
    Step3,
    Step4,
    Step5,
  },
  data() {
    return {
      value: "",
      settingsData: {},
      step: 0,
      connectionWorks: false,
      image: require("../../assets/img/mqtt-pro-logo.png"),
      loaderImage: require("../../assets/img/loader.png"),
      errorImage: require("../../assets/img/500.png"),
      successImage: require("../../assets/img/200.png"),
      congrats: require("../../assets/img/happy.png"),

      acceptedTerms: false,
      steps: {
        1: { acceptedTerms: false, testPassed: false },
        2: {
          url: "",
          isSecured: null,
          ClientID: "",
          username: "",
          password: "",
          port: "",
          testPassed: false,
          testRunning: false,
          formPassed: false,
          isCustomPort: true,
        },
        3: { topics: [], testPassed: false },
        4: { ttl: null, keepData: true, interval: null, testPassed: false },
      },
    };
  },
  methods: {
    checkConncetion() {},
    saveData() {
      console.log(this.settingsData);
    },
  },
  created() {
    console.log(this.getSiteURLG());
  },
};
</script>

<style lang="css" scoped></style>
