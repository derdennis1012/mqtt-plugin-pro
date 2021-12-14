<template>
  <div class="app-settings">
    <h2>MQTT Plugin Pro Settings</h2>
    <hr />

    <!--MQTT URL-->
    <div>
      <b-form-group
        v-b-tooltip.hover.right
        title="e.g. 14.18.124.26">

        <label>MQTT Broker URL:</label>
        
        <b-form-input
          id="url"
          type="url"
          placeholder="Enter MQTT URL without Port"
          v-model="settingsData.mqtt_url"
          required
        ></b-form-input> 
      </b-form-group>
    </div>
    <!--div>URL: {{ settingsData.mqtt_url }}</div--> 
  

    <hr />


    <!--MQTT Port-->
    <div>
      <b-form-group
      v-b-tooltip.hover.right
        title="Default: 1883">

      <label>MQTT Broker Port:</label>

        <b-form-input
          id="port"
          type="number"
          placeholder="Enter MQTT Port"
          v-model="settingsData.mqtt_port"
          required
        ></b-form-input>
      </b-form-group>
    </div>
    <!--div>Port: {{ settingsData.mqtt_port }}</div-->
    


    <hr />


    <!--MQTT client id-->
    <div>
      <b-form-group>

      <label>MQTT Client ID:</label>

        <b-form-input
          id="id"
          type="text"
          placeholder="Enter Client ID"
          v-model="settingsData.mqtt_client_id"
          required
        ></b-form-input>
      </b-form-group>
    </div>
    <!--div>ID: {{ settingsData.mqtt_client_id }}</div-->
    

    <hr />


    <!--MQTT User: optional - Prüfen, ob User existiert-->
    <div>
      <b-form-group
      v-b-tooltip.hover.right
        title="Blank if no User">

      <label>MQTT User:</label>

        <b-form-input
          id="user"
          type="text"
          placeholder="Enter User"
          v-model="settingsData.mqtt_user"
          
        ></b-form-input>
      </b-form-group>
    </div>
    <!--div>ID: {{ settingsData.mqtt_user }}</div-->


    <hr />


    <!--MQTT password: optional - Prüfen, ob pw korrekt-->
    <div>
      <b-form-group
        v-b-tooltip.hover.right
        title="Enter Password for User">

      <label>MQTT Password:</label>

        <b-form-input
          id="pw"
          type="password"
          v-model="settingsData.mqtt_password"
        ></b-form-input>
       
      </b-form-group>
    </div>
     <!--div>ID: {{ settingsData.mqtt_password }}</div-->


    <hr />


    <!--MQTT Topics mit regex prüfen-->
      <div>
        <b-form-group
        v-b-tooltip.hover.right
          title="Format: sensor_1,sensor_2,...">

        <label>MQTT Topics:</label>

          <b-form-input 
            id="topics"
            type="text"
            placeholder="Comma-separated list of topics"
            v-model="settingsData.mqtt_topics"
            required
          ></b-form-input>

        </b-form-group>
      </div>
    <!--div>ID: {{ settingsData.mqtt_topics }}</div-->


    <hr />


    <!--MQTT intervall-->
    <validationprovider rules="positive|required" v-slot="{ errors }">
      <div>
        <b-form-group
        v-b-tooltip.hover.right
          title="Time in seconds">
        <label>MQTT Intervall:</label>
          <b-form-input
            id="intervall"
            type="number"
            placeholder="Interval to wait for the MQTT values (in seconds)"
            v-model="settingsData.mqtt_intervall"
            required
          ></b-form-input>
        </b-form-group>
      </div>
    <!--div>ID: {{ settingsData.mqtt_intervall }}</div-->
    <div>{{ errors[0] }}</div>
    </validationprovider>

    <hr />


    <!--MQTT ttl-->
    <div>
      <validation-observer ref="observer" v-slot="{ handleSubmit }">
        <b-form @submit.stop.prevent="handleSubmit(onSubmit)">

          <validation-provider
            name="MQTT time to live"
            :rules="{ required: true }" 
            v-slot="validationContext"
          >


            <b-form-group id="kekw" label="MQTT time to live" label-for="ttl">

              <b-form-input
                id="ttl"
                name="ttl"
                v-model="settingsData.mqtt_ttl"
                :state="getValidationState(validationContext)"
                aria-describedby="ttl-live-feedback"
              ></b-form-input>

              <b-form-invalid-feedback id="ttl-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>

            </b-form-group>
          </validation-provider>
          
          <b-button type="submit" variant="primary">Submit</b-button>
          <b-button class="ml-2" @click="resetForm()">Reset</b-button>

        </b-form>
      </validation-observer>
    </div>

    <hr />

    <hr />

    <!--Save button erscheint nur, wenn connection erfolgreich war-->
    <h5>
      Don't forget to save the entered details.
      <div>
        <b-button @click="saveData" variant="primary">Save</b-button>
      </div>
    </h5>
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
/*Validation Import, extend = eigene Regeln*/
/*ValidationObserver -> Link*/
import { 
  ValidationObserver,
  ValidationProvider,
  extend,
  localize } from 'vee-validate';
import { required } from 'vee-validate/dist/rules';

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";


/*Zahl muss > 0 sein */
extend('positive', value => {
  if (value > 0) {
    return true;
  }
  return 'Please choose a number bigger than 0';
});

/*Extend default required rule by error message*/
extend('required', {
  ...required,
  message: 'This field is required'
});


export default {
  name: "Settings",

  data() {
    return {
      settingsData: {},

      form: {
        ttl: null
      }
    };
  },
  methods: {
    saveData() {
      console.log(this.settingsData);
    },


    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },


    resetForm() {
      this.form = {
        ttl: null
      };
      this.$nextTick(() => {
        this.$refs.observer.reset();
      });
    },


    onSubmit() {
      alert("Form submitted!");
    }
  }
};
</script>

<style lang="css" scoped>
</style>
