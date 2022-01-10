<template>
  <div>
    <h4>MQTT Pro Plug-In Settings Page</h4>
    <validation-observer ref="simpleRules">
      <b-form>
        <div>
          <b-row>
            <!--MQTT URL-->
            <b-col md="3">
              <b-form-group label="Enter MQTT URL:"
              v-b-tooltip.hover.right
              title="e.g. 14.18.124.26"
              >
                
                <validation-provider
                  #default="{ errors }"
                  rules="required|url"
                  name="URL"
                >
                  <b-form-input
                    @input="checkForm()"
                    v-model="settingsData.mqtt_url"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Enter MQTT URL without Port"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <!--MQTT Port-->
            <b-col md="3">
              <b-form-group label="Enter MQTT Port:"
              v-b-tooltip.hover.right
              title="Default: 1883"
              >
                
                <validation-provider
                  #default="{ errors }"
                  rules="required|integer"
                  name="Port"
                >
                  <b-form-input
                    @input="checkForm()"
                    v-model="settingsData.mqtt_port"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Default: 1883"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>
          </b-row>
        </div>

        <div>
          <b-row>
            <!--MQTT client id-->
            <b-col md="6">
              <b-form-group label="ClientID:"
              v-b-tooltip.hover.right
              title="e.g. my_mqtt_client"
              >
                <!--ToDo: ID & password & port => SetupPageComp/step2.vue
                  -> Password ausblenden, wenn nicht pw geschützt-->
                
                <validation-provider
                  #default="{ errors }"
                  name="ClientID"
                  rules="required"
                >
                  <b-form-input
                    @input="checkForm()"
                    v-model="settingsData.mqtt_client_id"
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
            <!--MQTT User: optional - Prüfen, ob User existiert-->
            <b-col md="3">
              <b-form-group label="MQTT User:"
              v-b-tooltip.hover.right
              title="Blank if no User"
              >
                <validation-provider #default="{ errors }" rules="" name="User">
                  <b-form-input
                    @input="checkForm()"
                    v-model="settingsData.mqtt_user"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Enter User"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <!--MQTT password: optional - Prüfen, ob pw korrekt-->
            <b-col md="3">
              <b-form-group label="MQTT Password:"
              v-b-tooltip.hover.right
              title="Enter Password for User"
              >
                <validation-provider
                  #default="{ errors }"
                  rules="password"
                  name="Password"
                >
                  <b-form-input
                    @input="checkForm()"
                    v-model="settingsData.mqtt_password"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Enter User"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>
          </b-row>
        </div>


        <div>
          <b-row>
            <!--MQTT Topics mit regex prüfen-->
            <b-col md="6">
              <b-form-group label="MQTT Topics:"
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
                    v-model="settingsData.mqtt_topics"
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
            <!--MQTT intervall-->
            <b-col md="3">
              <b-form-group label="MQTT Intervall:"
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
                    v-model="settingsData.mqtt_intervall"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Interval to wait for the MQTT values (in seconds)"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <!--MQTT ttl-->
            <b-col md="3">
              <b-form-group label="MQTT Time To Live:"
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
                    v-model="settingsData.mqtt_ttl"
                    :state="errors.length > 0 ? false : null"
                    placeholder="How long the MQTT values are stored (in days)"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>
          </b-row>
        </div>


        <div>
          <b-row>
            <!-- submit button  :disabled="!inputPassed"-->
            <b-col cols="12">
              <b-button
                variant="primary"
                type="submit"
                @click.prevent="checkForm"

              >
                Save Settings
              </b-button>
            </b-col>
          </b-row>
        </div>

      </b-form>
    </validation-observer>

    <!--Cards-->
    <!--ToDo: check card verwandelt sich zu success oder error-->
    <div>
      <b-card-group deck>
        <b-card v-if="testPassed == null" bg-variant="secondary" text-variant="white" title="Check MQTT connection">
          <b-card-text>
            To check if your entered details work, please check the MQTT connection.
          </b-card-text>
            <b-button 
            variant="primary"
            @click="checkMQTTConnection" 
            :disabled="!inputPassed"
            block
            >Check MQTT connection</b-button>
        </b-card>

        
        <!---->
        <b-card v-if="inputPassed === true" bg-variant="success" text-variant="white" class="text-center">
              <font-awesome-icon :icon="['fad', 'check-circle']" />
            
            <b-card-title>It works!</b-card-title>
            <b-card-text>Your connection works! <br> We are ready to receive data.</b-card-text>
        </b-card>

        <b-card v-if="inputPassed === false" bg-variant="danger" text-variant="white" class="text-center">
            <font-awesome-icon :icon="['fad', 'exclamation-triangle']" />

            <b-card-title>Error!</b-card-title>
            <b-card-text>Your connection doesn't work! <br> Please check you settings.</b-card-text>
        </b-card>
      </b-card-group>
    </div>

  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
  url,
  required,
  integer,
  positive,
  regex,
  ip
} from "../validations/validations";


export default {
  name: "SettingsPage",
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      settingsData: {},
      required,
      url,
      ip,
      integer,
      positive,
      regex,
      renderComponent: false,
      inputPassed: false,
      testRunning: false,
    };
  },

  /*ToDo: 1. setStatus Funktionen PlugIn deaktivieren 2. getStatus aktuellen Status erhalten*/
  methods: {
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
      self.$set(self.settingsData, "mqtt_client_id", username);
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