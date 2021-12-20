<template>
  <div
    class="app-settings container  h-100
        fh"
  >
    <div
      class="
        d-flex
        align-items-center
        justify-content-between
       
        flex-column
      "
      v-if="step == 1"
    >
      <h1 class="text-center fat-heading mb-4 mt-4">Howdy my MQTT friend 👋</h1>

      <h3 class="text-center mt-4">
        We're so glad that you've downloaded our plugin!
      </h3>
      <b-img
        class="text-center mt-3 mb-3"
        :src="image"
        fluid
        alt="Responsive image"
        center
        width="270"
      ></b-img>
      <h4 class="text-center mt-4 mb-4">But enough of talking ...</h4>
      <b-button variant="primary" block @click="step = 2"
        >Let's get started 🚀</b-button
      >
      <h6 class="text-muted text-center mt-4">
        No worries, we will guide you step by step through this!
      </h6>
    </div>
    <div
      class="d-flex align-items-center justify-content-between"
      v-if="step > 1"
    >
      <div @click="step = 2">
        <b-spinner
          v-if="step == 2"
          small
          label="Small Spinner"
          variant="primary"
          class="mr-1"
        ></b-spinner>
        <span
          :class="
            `${step == 2 ? 'text-primary' : ''} ${step > 1 ? '' : 'text-muted'}`
          "
          >1. Info</span
        >
      </div>
      <div class="setup-line"></div>
      <div @click="step = 3">
        <b-spinner
          v-if="step == 3"
          small
          label="Small Spinner"
          variant="primary"
          class="mr-1"
        ></b-spinner
        ><span
          :class="
            `${step == 3 ? 'text-primary' : ''} ${step > 2 ? '' : 'text-muted'}`
          "
          >2. MQTT Broker</span
        >
      </div>
      <div class="setup-line"></div>

      <div @click="step = 4">
        <b-spinner
          v-if="step == 4"
          small
          label="Small Spinner"
          variant="primary"
          class="mr-1"
        ></b-spinner
        ><span
          :class="
            `${step == 4 ? 'text-primary' : ''} ${step > 3 ? '' : 'text-muted'}`
          "
          >3. Topics</span
        >
      </div>
      <div class="setup-line"></div>

      <div @click="step = 5">
        <b-spinner
          v-if="step == 5"
          small
          label="Small Spinner"
          variant="primary"
          class="mr-1"
        ></b-spinner
        ><span
          :class="
            `${step == 5 ? 'text-primary' : ''} ${step > 4 ? '' : 'text-muted'}`
          "
          >4. Misc</span
        >
      </div>
      <div class="setup-line"></div>

      <div>
        <span
          :class="
            `${step == 6 ? 'text-primary' : ''} ${step > 5 ? '' : 'text-muted'}`
          "
          >5. Setup done</span
        >
      </div>
    </div>
    <div
      class="d-flex flex-column justify-content-between h-100"
      v-if="step == 2"
    >
      <h1 class="mb-4 mt-4">1. Info</h1>
      <div class="scroll-y overflow-auto">
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce leo
          ligula, placerat id posuere sed, pharetra at urna. Phasellus at sem
          quis magna tincidunt blandit. Donec porta lectus a nunc mattis
          tristique. Proin commodo condimentum dolor ut commodo. Praesent
          viverra lacinia mollis. Proin facilisis faucibus massa sed varius.
          Curabitur pharetra volutpat venenatis. Vestibulum aliquet vitae lacus
          ac pretium. Vestibulum id auctor lacus, eget ornare felis.
        </p>
        <p>
          Duis nec ultricies lacus, quis elementum ante. Aenean congue, diam non
          commodo suscipit, dui purus vehicula ante, at convallis risus urna
          quis dolor. Nam leo arcu, feugiat nec nulla ac, gravida lacinia
          tortor. Mauris euismod, libero in pharetra condimentum, ipsum eros
          consectetur quam, non laoreet magna quam ac augue. Fusce maximus
          interdum urna sed vestibulum. Duis at varius arcu, sed luctus augue.
          Pellentesque placerat, sapien id sagittis ultricies, purus nunc tempus
          nulla, non rutrum massa augue sed risus. Praesent diam nisi, suscipit
          in dolor nec, congue vehicula tellus. Maecenas nec tellus eget ex
          facilisis porttitor. Ut viverra orci in ultrices aliquam.
        </p>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce leo
          ligula, placerat id posuere sed, pharetra at urna. Phasellus at sem
          quis magna tincidunt blandit. Donec porta lectus a nunc mattis
          tristique. Proin commodo condimentum dolor ut commodo. Praesent
          viverra lacinia mollis. Proin facilisis faucibus massa sed varius.
          Curabitur pharetra volutpat venenatis. Vestibulum aliquet vitae lacus
          ac pretium. Vestibulum id auctor lacus, eget ornare felis.
        </p>
        <p>
          Duis nec ultricies lacus, quis elementum ante. Aenean congue, diam non
          commodo suscipit, dui purus vehicula ante, at convallis risus urna
          quis dolor. Nam leo arcu, feugiat nec nulla ac, gravida lacinia
          tortor. Mauris euismod, libero in pharetra condimentum, ipsum eros
          consectetur quam, non laoreet magna quam ac augue. Fusce maximus
          interdum urna sed vestibulum. Duis at varius arcu, sed luctus augue.
          Pellentesque placerat, sapien id sagittis ultricies, purus nunc tempus
          nulla, non rutrum massa augue sed risus. Praesent diam nisi, suscipit
          in dolor nec, congue vehicula tellus. Maecenas nec tellus eget ex
          facilisis porttitor. Ut viverra orci in ultrices aliquam.
        </p>
      </div>
      <div>
        <b-form-checkbox
          id="checkbox-1"
          v-model="acceptedTerms"
          name="checkbox-1"
        >
          I accept the terms and use
        </b-form-checkbox>
      </div>
      <b-button
        v-if="acceptedTerms"
        variant="primary"
        block
        @click="step = step + 1"
        >Next Step</b-button
      >
      <b-button v-else variant="primary" block disabled
        >You have to accept the terms</b-button
      >
    </div>
    <div
      class="d-flex flex-column justify-content-between h-100"
      v-if="step == 3"
    >
      <h1 class="mb-4 mt-4">2. MQTT Broker</h1>
      <div class="h-100 justify-content-top">
        <validation-observer ref="simpleRules">
          <div class="d-flex align-items-center justify-content-between">
            <h5>Security</h5>
          </div>
          <span class="text-muted"
            >Please select the option that maches your MQTT Broker</span
          >
          <div class="d-flex align-items-center justify-content-between">
            <div
              :class="
                `shadow-sm p-3 bg-white rounded-lg border-card m-2 ${
                  steps[2].isSecured
                    ? 'border-primary'
                    : 'border-secondary border-card-sm'
                } w-100`
              "
              @click="steps[2].isSecured = !steps[2].isSecured"
            >
              <div class="d-flex align-items-center">
                <b-avatar
                  variant="light-primary"
                  icon="lock-fill"
                  class="mr-2"
                ></b-avatar
                >Yes it is password protected
              </div>
            </div>
            <div
              :class="
                `shadow-sm p-3 bg-white rounded-lg border-card m-2 ${
                  steps[2].isSecured
                    ? 'border-secondary border-card-sm'
                    : 'border-primary'
                } w-100`
              "
              @click="steps[2].isSecured = !steps[2].isSecured"
            >
              <div class="d-flex align-items-center">
                <b-avatar
                  variant="light-primary"
                  icon="unlock-fill"
                  class="mr-2"
                ></b-avatar
                >No its open to acces without password
              </div>
            </div>
          </div>
          <div v-if="steps[2].isSecured != null">
            <h5>The Broker</h5>
            <div>
              <b-form-group>
                <label>Must be a valid url</label>
                <validation-provider
                  #default="{ errors }"
                  name="URL"
                  rules="required|url"
                >
                  <b-form-input
                    v-model="steps[2].url"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Enter Valid URL"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </div>
          </div>
        </validation-observer>
      </div>
      <b-button variant="primary" block @click="step = step + 1"
        >Next Step</b-button
      >
    </div>
    <div
      class="d-flex flex-column justify-content-between h-100"
      v-if="step == 4"
    >
      <h1 class="mb-4 mt-4">3. Topics</h1>

      <b-button variant="primary" block @click="step = step + 1"
        >Next Step</b-button
      >
    </div>
    <div
      class="d-flex flex-column justify-content-between h-100"
      v-if="step == 5"
    >
      <h1 class="mb-4 mt-4">4. Misc</h1>

      <b-button variant="primary" block @click="step = step + 1"
        >Next Step</b-button
      >
    </div>
    <div
      class="d-flex flex-column justify-content-between h-100"
      v-if="step == 6"
    >
      <h1 class="mb-4 mt-4">5. Setup done</h1>

      <b-button variant="success" block>Finish</b-button>
    </div>
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
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { url, required, ip } from "../validations/validations";
export default {
  name: "Settings",
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      url,
      ip,
      required,
      value: "",
      settingsData: {},
      step: 1,
      connectionWorks: false,
      image: require("../../assets/img/mqtt-pro-logo.png"),
      acceptedTerms: false,
      steps: {
        1: {
          success: false,
        },
        2: {
          url: "",
          isSecured: null,
        },
      },
    };
  },
  methods: {
    checkConncetion() {},
    saveData() {
      console.log(this.settingsData);
    },
  },
};
</script>

<style lang="css" scoped></style>
