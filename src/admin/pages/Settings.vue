<template>
  <div class="app-settings">
    <h2>MQTT Plugin Pro Settings</h2>
    <hr />


    <div>
      <b-form-group
        v-b-tooltip.hover.right
        title="z.B. 14.18.124.26 Ohne den Port"
      >
        <label>MQTT Broker URL</label>
        <b-form-input
          id="url"
          type="text"
          placeholder="Enter MQTT URL without Port"
          v-model="settingsData.mqtt_url"
          required
        ></b-form-input>

      </b-form-group>
    </div>

    <div>URL: {{ settingsData.mqtt_url }}</div>
    <b-button @click="saveData" variant="primary">Speichern</b-button>
    


    <hr />


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
      settingsData: {},
    };
  },
  methods: {
    saveData() {
      console.log(this.settingsData);
    },
  },
};
</script>

<style lang="css" scoped>
</style>
