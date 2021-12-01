<template>
  <div class="app-settings">
    <h2>MQTT Plugin Pro Settings</h2>
    <hr />
    <div>
      <b-form-group>
        <label v-b-tooltip.hover.right title="z.B. 14.18.124.26 Ohne den Port"
          >MQTT Broker URL</label
        >
        <b-form-input
          id="input-1"
          type="text"
          placeholder="Enter MQTT URL"
          v-model="settingsData.mqtt_url"
          required
        ></b-form-input>
      </b-form-group>
    </div>
    {{ settingsData }}
    <b-button variant="primary">Save</b-button>
  </div>
</template>
<!--
  @Vue-Bootsrap DOC
  https://bootstrap-vue.org/docs

  @BoostrapDoc
  https://getbootstrap.com/docs/4.1/getting-started/introduction/

 -->
<script>
export default {
  name: "Settings",

  data() {
    return {
      settingsData: {},
    };
  },
};
</script>

<style lang="css" scoped>
</style>
