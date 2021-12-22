<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <div>
      <h1 class="mb-4 mt-4">2. MQTT Broker</h1>
    </div>
    <div
      class="h-100 justify-content-top"
      v-if="data.testPassed == false && data.testRunning == false"
    >
      <validation-observer ref="simpleRules">
        <div class="d-flex align-items-center justify-content-between">
          <h5>Security</h5>
        </div>
        <span class="text-muted"
          >Please select the option that maches your MQTT Broker</span
        >
        <div class="d-flex align-items-center justify-content-between">
          <div
            :class="`shadow-sm p-3 bg-white  border-secondary  rounded-lg border-card m-2 ${
              data.isSecured ? 'border-primary border-card-lg' : ''
            } w-100`"
            @click="data.isSecured = true"
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
            :class="`shadow-sm p-3 bg-white rounded-lg border-card m-2  border-secondary ${
              data.isSecured == false ? 'border-primary border-card-lg' : ''
            } w-100`"
            @click="data.isSecured = false"
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
        <div v-if="data.isSecured != null">
          <div class="d-flex align-items-center justify-content-between mt-1">
            <h5>The Broker</h5>
            <b-form-checkbox
              checked="true"
              name="check-button"
              switch
              inline
              v-model="data.isCustomPort"
            >
              Custom port (Default 1883)
            </b-form-checkbox>
          </div>
          <div class="shadow rounded-lg bg-white px-3 pt-3 pb-1">
            <div>
              <b-form>
                <b-row>
                  <b-col :md="`${data.isCustomPort ? 9 : 12}`">
                    <b-form-group label="MQTT Broker URL">
                      <validation-provider
                        #default="{ errors }"
                        name="URL/IP"
                        rules="required|url"
                      >
                        <b-form-input
                          @input="checkForm()"
                          v-model="data.url"
                          label="Test"
                          :state="errors.length > 0 ? false : null"
                          placeholder="URL / IP of the broker"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="3" v-if="data.isCustomPort">
                    <b-form-group label="Port">
                      <validation-provider
                        #default="{ errors }"
                        name="URL/IP"
                        rules="required"
                      >
                        <b-form-input
                          @input="checkForm()"
                          v-model="data.port"
                          type="number"
                          :state="errors.length > 0 ? false : null"
                          placeholder="Port"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                </b-row>
              </b-form>
            </div>
            <div v-if="data.isSecured == true">
              <b-form>
                <b-row>
                  <b-col md="6">
                    <b-form-group label="Username:">
                      <validation-provider
                        #default="{ errors }"
                        name="Username"
                        rules="required"
                      >
                        <b-form-input
                          @input="checkForm()"
                          v-model="data.username"
                          :state="errors.length > 0 ? false : null"
                          placeholder="Username"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="6">
                    <b-form-group label="Password:">
                      <validation-provider
                        #default="{ errors }"
                        name="Password"
                        rules="required"
                      >
                        <b-form-input
                          @input="checkForm()"
                          v-model="data.password"
                          :state="errors.length > 0 ? false : null"
                          type="password"
                          placeholder="Password"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                </b-row>
              </b-form>
            </div>
            <div>
              <b-row>
                <b-col md="9">
                  <b-form-group label="ClientID:">
                    <validation-provider
                      #default="{ errors }"
                      name="ClientID"
                      rules="required"
                    >
                      <b-form-input
                        @input="checkForm()"
                        v-model="data.ClientID"
                        :state="errors.length > 0 ? false : null"
                        type="text"
                        placeholder="ClientID"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="3">
                  <div class="mt-4">
                    <b-button block variant="primary" @click="generateID()"
                      >Generate ID</b-button
                    >
                  </div>
                </b-col>
              </b-row>
            </div>
            <b-button
              variant="success"
              @click="checkMQTTConnection"
              :disabled="!inputPassed"
              block
              class="mt-1 mb-1"
              >Check MQTT connection</b-button
            >
          </div>
        </div>
        <div v-if="testRunning" class="">
          <div class="shadow-lg bg-white px-3 pt-3 pb-1">
            <h4 class="text-center">Checking connection</h4>
            <img :src="loaderImage" width="100%" style="margin: auto" />
            <div
              class="text-center"
              style="width: 30%; margin: auto; transform: translateY(-100px)"
            >
              <b-progress :value="20" class="color-progress"></b-progress>
              <span class="text-muted text-center">Connecting to server</span>
            </div>
          </div>
        </div>
      </validation-observer>
    </div>
    <b-button variant="primary" block @click="checkNextStep"
      >Next Step</b-button
    >
  </div>
</template>
<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { url, required, ip } from "../../validations/validations";
export default {
  name: "Step2",
  props: {
    data: {
      type: Object,
      required: true,
    },
    loaderImage: {
      type: String,
      required: true,
    },
  },
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      url,
      required,
      ip,
      renderComponent: false,
      inputPassed: false,
      testRunning: false,
    };
  },
  methods: {
    nextStep() {
      this.$emit("nextStep");
    },
    checkNextStep() {
      this.nextStep();
    },
    async generateID() {
      var self = this;
      var first = [
        "sir",
        "lord",
        "master",
        "king",
        "miss",
        "don",
        "prof",
        "pretty",
      ];
      var second = ["watermelon", "lanzelord", "piggy", "oatmeal", "pb&j"];
      var username = `${first[self.getRandomInt(first.length)]}_${
        second[self.getRandomInt(second.length)]
      }${self.getRandomInt(9999)}`;
      self.$set(self.data, "ClientID", username);
      await self.checkForm();
      await self.checkForm();
    },
    getRandomInt(max) {
      return Math.floor(Math.random() * max);
    },
    async checkMQTTConnection() {
      var self = this;
      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title: "Vue POST Request Example" }),
      };
      fetch("https://jsonplaceholder.typicode.com/posts", requestOptions)
        .then((response) => response.json())
        .then((data) => console.log(data));
    },
    async checkForm() {
      var self = this;
      var res = false;
      console.log("test");
      try {
        res = await self.$refs.simpleRules.validate();
      } catch (e) {
        console.log(e);
        res = false;
      }
      self.$set(this, "inputPassed", res);
      return res;
    },
    forceRerender() {
      // Remove my-component from the DOM
      this.renderComponent = false;

      this.$nextTick(() => {
        // Add the component back in
        this.renderComponent = true;
      });
    },
  },
  created() {
    var self = this;
    self.dataObj = self.data;
  },
};
</script>
