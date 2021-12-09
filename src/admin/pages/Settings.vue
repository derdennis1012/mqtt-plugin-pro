<template>
  <div class="app-settings">
    <h2>MQTT Plugin Pro Settings</h2>
    <hr />

    <!--MQTT URL-->
    <div>
      <b-form-group
        v-b-tooltip.hover.right
        title="z.B. 14.18.124.26 Ohne den Port">

        <label>MQTT Broker URL</label>

        <b-form-input
          id="mqtt-url"
          type="url"
          placeholder="Enter MQTT URL without Port"
          v-model="settingsData.mqtt_url"
          required
        ></b-form-input> 
      </b-form-group>

    </div>
    <div>URL: {{ settingsData.mqtt_url }}</div> 
    

    <hr />


    <!--MQTT Port-->
    <div>
      <b-form-group>
      <label>MQTT Broker Port</label>
        <b-form-input
          id="port"
          type="number"
          placeholder="Enter MQTT Port, default: 1883"
          v-model="settingsData.mqtt_port"
          required
        ></b-form-input>
      </b-form-group>
    </div>
    <div>Port: {{ settingsData.mqtt_port }}</div>
    


    <hr />


    <!--MQTT client id-->
    <div>
      <b-form-group>
      <label>MQTT Client ID</label>
        <b-form-input
          id="port"
          type="text"
          placeholder="Enter Client ID"
          v-model="settingsData.mqtt_client_id"
          required
        ></b-form-input>
      </b-form-group>
    </div>
    <div>ID: {{ settingsData.mqtt_client_id }}</div>
    

    <hr />


    <!--MQTT User: optional - Prüfen, ob User existiert-->
    <div>
      <b-form-group>
      <label>MQTT User</label>
        <b-form-input
          id="port"
          type="text"
          placeholder="Enter User"
          v-model="settingsData.mqtt_user"
          
        ></b-form-input>
      </b-form-group>
    </div>
    <div>ID: {{ settingsData.mqtt_user }}</div>


    <hr />


    <!--MQTT password: optional - Prüfen, ob pw korrekt-->
    <div>
      <b-form-group
        v-b-tooltip.hover.right
        title="Enter Password for User">
      <label>MQTT Password</label>
        <b-form-input
          id="port"
          type="password"
          
          v-model="settingsData.mqtt_password"
         
        ></b-form-input>
       
      </b-form-group>
    </div>
     <!--div>ID: {{ settingsData.mqtt_password }}</div-->


    <hr />


    <!--MQTT Topics-->
    <div>
      <b-form-group>
      <label>MQTT Topics</label>
        <b-form-input
          id="port"
          type="text"
          placeholder="Comma-separated list of topics, like: sensor_1,sensor_2,..."
          v-model="settingsData.mqtt_topics"
          required
        ></b-form-input>
      </b-form-group>
    </div>
    <div>ID: {{ settingsData.mqtt_topics }}</div>


    <hr />


    <!--MQTT intervall-->
    <div>
      <b-form-group>
      <label>MQTT Intervall</label>
        <b-form-input
          id="port"
          type="number"
          placeholder="Interval to wait for the MQTT values (in seconds)"
          v-model="settingsData.mqtt_intervall"
          required
        ></b-form-input>
      </b-form-group>
    </div>
    <div>ID: {{ settingsData.mqtt_intervall }}</div>


    <hr />


    <!--MQTT ttl-->
    
    <b-form-group>
    <label for="ttl-live">MQTT Time To Live</label>
      <b-form-input
        id="ttl-live"
          
        v-model="settingsData.mqtt_ttl"
        :state="ttlState"
        aria-describedby="ttl-live-help ttl-live-feedback"
        placeholder="How long the MQTT values are stored (in days)"
        trim
      ></b-form-input>


      <b-form-invalid-feedback id="ttl-live-feedback">
        Zahl muss > 0 sein.
      </b-form-invalid-feedback>

      <b-form-text id="ttl-live-help">
        Anzahl der Tage, die der Wert gespeichert werden soll.
      </b-form-text>

    </b-form-group>
    <!--div>ID: {{ settingsData.mqtt_ttl }}</div-->


    <hr />


    <b-button @click="saveData" variant="primary">Speichern</b-button>


  </div>
</template>
<!--
  @Vue-Bootsrap DOC
  https://bootstrap-vue.org/docs

  @BoostrapDoc
  https://getbootstrap.com/docs/4.1/getting-started/introduction/

  @Validation
  https://vee-validate.logaretm.com/v4/


  Test Commit, sorry dafür
 -->
<script>

export default {
  name: "Settings",
  data() {
    return {
      settingsData: {
        /*
        mqtt_url: URL,
        mqtt_port: Number,  
        mqtt_client_id: Number,
        mqtt_user: Text,
        mqtt_password: Text,
        mqtt_topics: Text,
        mqtt_intervall: Number,
        mqtt_ttl: Number
        */
      },
    };
  },
  methods: {
    saveData() {
      console.log(this.settingsData);
    },
    ttlState() {
      return this.settingsData.mqtt_ttl.lenght > 2 ? true : false
    },
  },
};
</script>

<style lang="css" scoped>
</style>
