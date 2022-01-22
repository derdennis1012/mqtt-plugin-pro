<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <div>
      <h4>MQTT Pro Plug-In Settings Page</h4>
    </div>
    <div class="h-100 justify-content-top">
      <validation-observer ref="simpleRules">
        <div v-if="testResult == null">
          <div class="d-flex align-items-center justify-content-between">
            <h5>Security</h5>
          </div>
          <span class="text-muted"
            >Please select the option that matches your MQTT Broker</span
          >
          <div class="d-flex align-items-center justify-content-between">
            <div
              :class="`shadow-sm p-3 bg-white  border-secondary  rounded-lg border-card m-2 ${
                settingsData.isSecured ? 'border-primary border-card-lg' : ''
              } w-100`"
              @click="settingsData.isSecured = true"
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
                settingsData.isSecured == false ? 'border-primary border-card-lg' : ''
              } w-100`"
              @click="settingsData.isSecured = false"
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
        </div>

        <div
          v-if="settingsData.isSecured != null && !testRunning && testResult == null"
        >
          <div class="d-flex align-items-center justify-content-between mt-1">
            <h5>The Broker</h5>
            <b-form-checkbox
              checked="true"
              name="check-button"
              switch
              inline
              v-model="settingsData.isCustomPort"
              @change="checkPort(settingsData.isCustomPort)"
            >
              Custom port (Default 1883)
            </b-form-checkbox>
          </div>
          <div class="shadow rounded-lg bg-white px-3 pt-3 pb-1">
            <div>
              <b-form>
                <b-row>
                  <b-col :md="`${settingsData.isCustomPort ? 9 : 12}`">
                    <b-form-group label="MQTT Broker URL">
                      <validation-provider
                        #default="{ errors }"
                        name="URL/IP"
                        rules="required|url"
                      >
                        <b-form-input
                          @input="checkForm()"
                          v-model="settingsData.mqtt_pro_mqtt_url"
                          label="Test"
                          :state="errors.length > 0 ? false : null"
                          placeholder="URL / IP of the broker"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="3" v-if="settingsData.isCustomPort">
                    <b-form-group label="Port">
                      <validation-provider
                        #default="{ errors }"
                        name="URL/IP"
                        rules="required"
                      >
                        <b-form-input
                          @input="checkForm()"
                          v-model="settingsData.mqtt_pro_mqtt_url"
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
            <div v-if="settingsData.isSecured == true">
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
                          v-model="settingsData.mqtt_pro_mqtt_user"
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
                          v-model="settingsData.mqtt_pro_mqtt_password"
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
                        v-model="settingsData.mqtt_pro_mqtt_client_id"
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





            <div>
              <b-row>
                <b-col>
                  <b-form-group
                    label="MQTT Topics:"
                    v-b-tooltip.hover.right
                    title="Format: sensor_1,sensor_2,..."
                  >
                    <validation-provider
                      #default="{ errors }"
                      rules="required|regex:^(.*[^\/\s])$"
                      name="Topics"
                    >
                      <b-form-input
                        @input="checkForm()"
                        v-model="settingsData.mqtt_pro_mqtt_topics"
                        :state="errors.length > 0 ? false : null"
                        placeholder="Comma separated list of Topics"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
              </b-row>
            </div>

            <div>
              <b-row> 
                <b-col>
                  <b-form-group
                    label="MQTT Intervall:"
                    v-b-tooltip.hover.right
                    title="Must be a natural number > 0"
                  >
                    <validation-provider
                      #default="{ errors }"
                      rules="required|integer|positive"
                      name="Intervall"
                    >
                      <b-form-input
                        @input="checkForm()"
                        v-model="settingsData.mqtt_pro_mqtt_interval"
                        :state="errors.length > 0 ? false : null"
                        placeholder="Interval to wait for the MQTT values (in seconds)"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
              </b-row>
             </div>
             
            <div>
              <b-row>
                <b-col>
                  <b-form-group
                    label="MQTT Time To Live:"
                    v-b-tooltip.hover.right
                    title="Must be a natural number > 0"
                  >
                    <validation-provider
                      #default="{ errors }"
                      rules="required|integer|positive"
                      name="TTL"
                    >
                      <b-form-input
                        @input="checkForm()"
                        v-model="settingsData.mqtt_pro_mqtt_ttl"
                        :state="errors.length > 0 ? false : null"
                        placeholder="How long the MQTT values are stored (in days)"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
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
          
            
        

      

            <!--Innerhalb des Kasten-->
          
        </div>
        <div v-if="testRunning" class="">
          <div class="shadow-lg bg-white px-3 pt-3 pb-1">
            <h4 class="text-center">Checking connection</h4>
            <img :src="loaderImage" width="100%" style="margin: auto" />

            <div
              class="text-center"
              style="width: 30%; margin: auto; transform: translateY(-100px)"
            >
              <div class="text-center mb-1">
                <b-spinner label="Spinning"></b-spinner>
              </div>
              <span class="text-muted text-center">Connecting to server</span>
            </div>
          </div>
        </div>
        <div v-if="testResult !== null">
          <div
            :class="`shadow-lg rounded ${
              testResult ? 'bg-success' : 'bg-danger'
            } px-3 pt-3 pb-1 text-white`"
          >
            <h4 :class="`text-center`">
              Connection {{ testResult ? "successful" : "failed" }}
            </h4>
            <h6 v-if="!testResult" class="text-center">
              Maybe you've unplugged your device?
            </h6>
            <img
              :src="testResult ? successImage : errorImage"
              width="100%"
              style="margin: auto"
            />
          </div>
        </div>
        
        <b-button
          variant="outline-primary"
          class="mt-2"
          block
          v-if="testResult !== null"
          @click="retryConnection"
        >
          {{ !testResult ? "Plugged back in? - " : "" }} Retry
        </b-button>
      
  

          

          

         
          
        </validation-observer>
      </div>  
      
      
      
      <div>
        <b-card-group deck>
          <b-card
            v-if="inputPassed == true && !connected"
            bg-variant="secondary"
            text-variant="white"
            class="text-center"
          >
            <b-card-title>Check MQTT connection</b-card-title>

            <b-card-text>
              To check if your entered details work, check the MQTT connection.
            </b-card-text>
            <b-button variant="primary" @click="checkMQTTConnection" block
              >Check MQTT connection</b-button
            >
          </b-card>

      
        <b-card
          v-if="connected === true"
          bg-variant="success"
          text-variant="white"
          class="text-center"
        >
          <font-awesome-icon :icon="['fad', 'check-circle']" />

          <b-card-title>It works!</b-card-title>
          <b-card-text
            >Your connection works! <br />
            We are ready to receive data.</b-card-text
          >
        </b-card>

        <b-card
          v-if="connected === false"
          bg-variant="danger"
          text-variant="white"
          class="text-center"
        >
          <font-awesome-icon :icon="['fad', 'exclamation-triangle']" />

          <b-card-title>Error!</b-card-title>
          <b-card-text
            >Your connection doesn't work! <br />
            Please check you settings.</b-card-text
          >
          </b-card>
        </b-card-group>

      </div>

      <b-button
            variant="primary"
            type="submit"
            block
            @click.prevent="checkForm"
            :disabled="!inputPassed && (connected==null || !connected)"
          >
            Save Settings
          </b-button>
    </div>
</template>

<script>
var elmnts = document.querySelectorAll("[data-pk-atts]");
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
  url,
  required,
  integer,
  positive,
  regex,
  ip,
} from "../validations/validations";

export default {
  name: "SettingsPage",

  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      elements: elmnts,
      settingsData: {
        testPassed: false,
        customPort: false,
        inputPassed: false,
        isSecured: false,
        found: null,
      },
      required,
      url,
      ip,
      integer,
      positive,
      regex,
      connected: null,

      testRunning: false,
      testResult: null,
      renderComponent: false,
    };
  },

  methods: {
    retryConnection() {
      var self = this;
      self.settingsData.testPassed = false;
      self.testResult = null;
    },
    checkPort(status) {
      if (!status) this.data.port = 1883;
    },
    /*ToDo: PlugIn deaktivieren */
    setStaus() {},

    /*ToDo: aktuellen Status erhalten */
    getStatus() {},

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
      self.$set(self.settingsData, "mqtt_pro_mqtt_client_id", username);
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

      /*enable Save Settings Button*/

      this.connected = true;
    },
    
    forceRerender() {
      // Remove my-component from the DOM
      this.renderComponent = false;

      this.$nextTick(() => {
        // Add the component back in
        this.renderComponent = true;
      });
    },
    async checkMQTTConnection() {
      var self = this;
      self.testRunning = true;
      var settingsData = {
        mqtt_pro_mqtt_url: self.settingsData.mqtt_pro_mqtt_url,
        mqtt_pro_mqtt_port: `${!isNaN(self.settingsData.mqtt_pro_mqtt_url) ? self.settingsData.mqtt_pro_mqtt_port : 1883}`,
        mqtt_pro_mqtt_client_id: self.settingsData.mqtt_pro_mqtt_client_id,
        mqtt_pro_mqtt_user: self.settingsData.mqtt_pro_mqtt_user,
        mqtt_pro_mqtt_password: self.settingsData.mqtt_pro_mqtt_password,
        mqtt_pro_requires_auth: "" + self.settingsData.isSecured,
      };
      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(settingsData),
      };

      const { timeout = 8000 } = requestOptions;
      const controller = new AbortController();
      var response;

      try {
        const id = setTimeout(() => controller.abort(), timeout);
        response = await fetch(
          self.found.site_url +
            "/wp-json/mqtt-plugin-pro/v1/mqtt-functions/test-connection-without",
          {
            ...requestOptions,
            signal: controller.signal,
          }
        );
        clearTimeout(id);
      } catch (e) {
        self.testResult = false;
      }
      if (response) {
        var data = await response.json();
        console.log(data);
        self.testResult = settingsData.connected;
        if (self.testResult) self.settingsData.testPassed == true;
      }
      self.testRunning = false;
    },
    /*
    async checkForm() {

      //Wenn mqtt_port != 1883 dann customPort = true
      if(this.mqtt_pro_mqtt_port != 1883){
        this.customPort = true;
      }
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
  */
    async checkForm() {
      var self = this;
      var res = false;
      try {
        res = await self.$refs.simpleRules.validate();
      } catch (e) {
        console.log(e);
        res = false;
      }
      if (!this.settingsData.mqtt_pro_mqtt_url) res = false; // Fix nach PLP
      self.settingsData.testPassed = res;
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
    self.dataObj = self.settingsData;
    var fElment;
    var self = this;

    for (var i = 0; i < self.elements.length; i++) {
      var element = self.elements[i];
      var elmt = JSON.parse(element.getAttribute("data-pk-atts"));

      fElment = elmt;
    }
    self.found = fElment;
    setTimeout(() => {
      self.checkForm();
    }, 500);
  },
};
</script>
