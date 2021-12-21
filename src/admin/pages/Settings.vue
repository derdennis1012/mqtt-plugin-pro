<template>
  <div>
    <validation-observer ref="simpleRules">
      <b-form>
        <b-row>
          <!--MQTT URL-->
          <b-col md="6">
            <b-form-group>
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
            <b-form-group>
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
            <b-form-group>
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
            <b-form-group>
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
            <b-form-group>
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
            <b-form-group>
              <label>MQTT Topics:</label>
              <validation-provider
                #default="{ errors }"
                rules="required|regex:^(.*[^\/])$"
                name="Topics"
              >
                <b-form-input
                  v-model="settingsData.mqtt_topics"
                  :state="errors.length > 0 ? false : null"
                  placeholder="Comma-separated list of topics. Format: sensor_1,sensor_2,..."
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
          </b-col>

          <!--MQTT intervall-->
          <b-col md="6">
            <b-form-group>
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
            <b-form-group>
              <label>MQTT time to live:</label>
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
            >
              Submit
            </b-button>
          </b-col>
        </b-row>
      </b-form>
    </validation-observer>
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
    };
  },
};
</script>
