 
<template>
  <validation-observer ref="simpleRules">
    <b-form>
      <b-row>

        <!--MQTT URL-->
        <b-col md="6">
          <b-form-group>
            <label>Enter MQTT URL:</label>
            <validation-provider
              #default="{ errors }"
              rules="required|regex:^([0-9]{2}\.[0-9]{2}\.[0-9]{3}\.[0-9]{2})$"
              name="Enter MQTT URL without Port"
            >
              <b-form-input
                v-model="mqtt_url"
                :state="errors.length > 0 ? false:null"
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
              name="Default: 1883"
            >
              <b-form-input
                v-model="mqtt_port"
                :state="errors.length > 0 ? false:null"
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
              name="Enter Client ID"
            >
              <b-form-input
                v-model="mqtt_client_id"
                :state="errors.length > 0 ? false:null"
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
            <validation-provider
              #default="{ errors }"
              rules=""
              name="Enter User"
            >
              <b-form-input
                v-model="mqtt_user"
                :state="errors.length > 0 ? false:null"
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
              rules=""
              name="Enter User"
            >
              <b-form-input
                v-model="mqtt_password"
                :state="errors.length > 0 ? false:null"
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
              rules="required|regex:^$"
              name="Comma-separated list of topics. Format: sensor_1,sensor_2,..."
            >
              <b-form-input
                v-model="mqtt_topics"
                :state="errors.length > 0 ? false:null"
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
              rules="required"
              name="Interval to wait for the MQTT values (in seconds)"
            >
              <b-form-input
                v-model="mqtt_intervall"
                :state="errors.length > 0 ? false:null"
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
              rules="required|regex:^(([a-z]+_[1-9]+,)+)$"
              name="How long the MQTT values are stored (in days)"
            >
              <b-form-input
                v-model="mqtt_ttl"
                :state="errors.length > 0 ? false:null"
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
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
/*import { required } from 'vee-validate/dist/rules'*/
import {
  BFormInput, BFormGroup, BForm, BRow, BCol, BButton,
} from 'bootstrap-vue'

/*Zahl muss > 0 sein 
extend('positive', value => {
  if (value > 0) {
    return true;
  }
  return 'Please choose a number bigger than 0';
});
*/
/*Extend default required rule by error message
extend('required', {
  ...required,
  message: 'This field is required'
});
*/
const required = () => {

};
const confirmed = () => {
  
};

const url = () => {

};

const integer = () => {

};



export default {
  name: "Settings",

  components: {
    ValidationProvider,
    ValidationObserver,
    BFormInput,
    BFormGroup,
    BForm,
    BRow,
    BCol,
    BButton,
  },

  data() {
    return {
      settingsData: {
        mqtt_url: '',
        mqtt_port: '',
        mqtt_client_id: '',
        mqtt_user: '',
        mqtt_password: '',
        mqtt_topics: '',
        mqtt_intervall: '',
        mqtt_ttl: '',
      },
      required,
      confirmed,
      password,
      email,
      min,
      integer,
      url,
      alpha,
      between,
      digits,
      length,
    }
  },
  methods: {
    validate() {

    },
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          // eslint-disable-next-line
          alert('form submitted!')
        }
      })
    },
  },
}
</script>
 