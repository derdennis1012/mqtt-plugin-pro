<template>
  <div>
    <validation-observer ref="simpleRules">
      <b-form>
        <b-row>
          <!--MQTT URL-->
          <b-col md="6">
            <b-form-group
            v-b-tooltip.hover.right
            title="e.g. 14.18.124.26"
            >
              <label>Enter MQTT URL:</label>
              <validation-provider
                #default="{ errors }"
                rules="required|url"
                name="URL"
              >
                <b-form-input
                  v-model="settingsData.mqtt_url"
                  :state="errors.length > 0 ? false : null"
                  placeholder="Enter MQTT URL without Port"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
          </b-col>

          <!--MQTT Port-->
          <b-col md="6">
            <b-form-group
            v-b-tooltip.hover.right
            title="Default: 1883"
            >
              <label>Enter MQTT Port:</label>
              <validation-provider
                #default="{ errors }"
                rules="required|integer"
                name="Port"
              >
                <b-form-input
                  v-model="settingsData.mqtt_port"
                  :state="errors.length > 0 ? false : null"
                  placeholder="Default: 1883"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
          </b-col>

          <!--MQTT client id-->
          <b-col md="6">
            <b-form-group
            v-b-tooltip.hover.right
            title="e.g. my_mqtt_client"
            >
              <!--ToDo: ID & password & port => SetupPageComp/step2.vue-->
              <label>MQTT Client ID:</label>
              <validation-provider
                #default="{ errors }"
                rules="required"
                name="Client ID"
              >
                <b-form-input
                  v-model="settingsData.mqtt_client_id"
                  :state="errors.length > 0 ? false : null"
                  placeholder="Enter Client ID"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
          </b-col>

          <!--MQTT User: optional - Prüfen, ob User existiert-->
          <b-col md="6">
            <b-form-group
            v-b-tooltip.hover.right
            title="Blank if no User"
            >
              <label>MQTT User:</label>
              <validation-provider #default="{ errors }" rules="" name="User">
                <b-form-input
                  v-model="settingsData.mqtt_user"
                  :state="errors.length > 0 ? false : null"
                  placeholder="Enter User"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
          </b-col>

          <!--MQTT password: optional - Prüfen, ob pw korrekt-->
          <b-col md="6">
            <b-form-group
            v-b-tooltip.hover.right
            title="Enter Password for User"
            >
              <label>MQTT Password:</label>
              <validation-provider
                #default="{ errors }"
                rules="password"
                name="Password"
              >
                <b-form-input
                  v-model="settingsData.mqtt_password"
                  :state="errors.length > 0 ? false : null"
                  placeholder="Enter User"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
          </b-col>

          <!--MQTT Topics mit regex prüfen-->
          <b-col md="6">
            <b-form-group
            v-b-tooltip.hover.right
            title="Format: sensor_1,sensor_2,..."
            >
              <!--ToDo: Succes & Error rechts von check connection-->
              <label>MQTT Topics:</label>
              <validation-provider
                #default="{ errors }"
                rules="required|regex:^(.*[^\/\s])$"
                name="Topics"
              >
                <b-form-input
                  v-model="settingsData.mqtt_topics"
                  :state="errors.length > 0 ? false : null"
                  placeholder="Comma separated list of Topics"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
          </b-col>

          <!--MQTT intervall-->
          <b-col md="6">
            <b-form-group
            v-b-tooltip.hover.right
            title="Must be a natural number > 0"
            >
              <label>MQTT Intervall:</label>
              <validation-provider
                #default="{ errors }"
                rules="required|integer|positive"
                name="Intervall"
              >
                <b-form-input
                  v-model="settingsData.mqtt_intervall"
                  :state="errors.length > 0 ? false : null"
                  placeholder="Interval to wait for the MQTT values (in seconds)"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
          </b-col>

          <!--MQTT ttl-->
          <b-col md="6">
            <b-form-group
            v-b-tooltip.hover.right
            title="Must be a natural number > 0"
            >
              <label>MQTT Time To Live:</label>
              <validation-provider
                #default="{ errors }"
                rules="required|integer|positive"
                name="TTL"
              >
                <b-form-input
                  v-model="settingsData.mqtt_ttl"
                  :state="errors.length > 0 ? false : null"
                  placeholder="How long the MQTT values are stored (in days)"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
          </b-col>
          <!-- submit button -->
        
          <b-col cols="12">
            <b-button
              variant="primary"
              type="submit"
              @click.prevent="validationForm"
              :disabled="!testPassed"
            >
              Save 
            </b-button>
          </b-col>
        </b-row>
      </b-form>
    </validation-observer>

    <!--Cards-->
    <div>
      <div>
        <b-card bg-variant="secondary" text-variant="white" title="Check MQTT connection">
          <b-card-text>
            To check if your entered details work, please check the MQTT connection
          </b-card-text>
            <b-button @click="checkConnection" variant="primary">Check connection</b-button>
        </b-card>
    </div>
      

      <div class="mt-4">
        <b-card-group v-if="testPassed === false">
          <!--b-card img-src="src\assets\img\404.png" img-alt="Card image" img-left class="mb-3">
          </b-card-->
          <b-card bg-variant="danger" text-variant="white" header="Error!" class="text-center">
              <b-card-text>Unfortunately, your connection doesn't work! Please check your settings</b-card-text>
          </b-card>
        </b-card-group>
      </div>




      <div>
        <b-card-group v-if="testPassed === true">
          <b-card bg-variant="success" text-variant="white" header="It works!" class="text-center">
              <b-card-text>Everything works fine, don't forget to save your information with the button above!</b-card-text>
          </b-card>
        </b-card-group>
      </div>
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
      integer,
      positive,
      regex,
      testPassed:null
    };
  },

  methods: {
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          // eslint-disable-next-line
          alert('form submitted!')
        }
      })
    },
    checkConnection(succes=true) {
      if(succes){
        this.testPassed=true
      } else
        this.testPassed=false
    },
  },
  computed:{
    isDisabled(){
      //enable button when "Connection Success" card is visible 
      return true
    }
  }
};
</script>
