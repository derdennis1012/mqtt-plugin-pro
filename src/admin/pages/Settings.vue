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
    <ValidationProvider rules="positive|required" v-slot="{ errors }">
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
    </ValidationProvider>

    <hr />


    <!--MQTT ttl-->
    <ValidationProvider rules="positive|required" v-slot="{ errors }">
      <b-form-group
        v-b-tooltip.hover.right
        title="Time in days">

      <label for="ttl-live">MQTT Time To Live:</label>

        <b-form-input
          id="ttl"
          type="number"
          v-model="settingsData.mqtt_ttl"
          placeholder="How long the MQTT values are stored (in days)"
          required
        ></b-form-input>
      </b-form-group>
    <!--div>ID: {{ settingsData.mqtt_ttl }}</div-->
    <div>{{ errors[0] }}</div>
    </ValidationProvider>


    <hr />


    <div>
      <b-card bg-variant="secondary" text-variant="white" title="Check MQTT connection">
        <b-card-text>
          To check if your entered details work, please check the MQTT connection with the button below.
        </b-card-text>
         <b-button @click="checkConnection" variant="primary">Check connection!</b-button>
      </b-card>
    </div>

    <div>
      <b-card-group>
        <b-card bg-variant="danger" text-variant="white" header="Danger" class="text-center">
            <b-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</b-card-text>
        </b-card>
        
        <b-card bg-variant="success" text-variant="white" header="Success" class="text-center">
            <b-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</b-card-text>
        </b-card>
      </b-card-group>
    </div>

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
import { extend, ValidationProvider, Field, Form } from 'vee-validate';
import { required } from 'vee-validate/dist/rules';
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
  components: {
    ValidationProvider,
  },
  name: "Settings",
  data() {
    return {
      settingsData: {},
    };
  },
  methods: {
    saveData() {
      console.log(this.settingsData);
    },
    checkConnection() {
    },
  },
};
</script>

<style lang="css" scoped>
</style>
