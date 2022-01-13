<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <div class="mt-4">
      <h1 class="mb-4">
        <span @click="$emit('goBack')">
          <font-awesome-icon
            class="mr-3"
            :icon="['fal', 'chevron-left']" /></span
        >5. Setup done
      </h1>
      <div>
        <h4>Summary</h4>
        <div class="mt-3">
          <h5>MQTT Broker</h5>
          <div class="border p-1 w-100 rounded-lg" block>
            <div
              class="p-2 w-100 d-flex align-items-top justify-content-between"
            >
              <div>
                <div class="d-flex align-items-top justify-content-start">
                  <b-avatar
                    variant="light-primary"
                    size="lg"
                    :icon="`${
                      settingsObj.mqtt_pro_requires_auth
                        ? 'lock-fill'
                        : 'unlock-fill'
                    }`"
                    class="mr-2"
                  ></b-avatar>
                  <div class="ml-2">
                    <div>
                      <span class="text-muted">MQTT URL:</span><br />
                      <span style="text-decoration: underline !important"
                        ><b>
                          mqtt://{{ settingsObj.mqtt_pro_mqtt_url }}:{{
                            settingsObj.mqtt_pro_mqtt_port
                          }}
                        </b></span
                      >
                    </div>
                  </div>
                  <div class="ml-4">
                    <div>
                      <span class="text-muted">Interval:</span><br />
                      <span>
                        Every
                        <b>{{ settingsObj.mqtt_pro_mqtt_interval }}</b> seconds
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div>
                <b-avatar
                  variant="light-success"
                  size="lg"
                  icon="check"
                  class="mr-2"
                ></b-avatar>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <h5>Topics</h5>
          <div
            class="d-flex flex-row flex-nowrap w-100 overflow-scroll scroll-container-custom"
          >
            <div
              class="m-2 p-4 border rounded topic-card d-flex align-items-center"
              v-for="(item, key) in settingsObj.mqtt_pro_mqtt_topics_arr"
              :key="key"
            >
              <b>{{ item }}</b>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <h5>TTL</h5>
          <div
            class="bg-light-danger border rounded p-2 d-flex justify-content-start align-items-center"
          >
            <div>
              <b-avatar
                variant="light-success-test"
                size="lg"
                icon="exclamation-octagon-fill"
                class="mr-2"
              ></b-avatar>
            </div>
            <div class="ml-3" v-if="settingsObj.mqtt_pro_has_ttl">
              Your MQTT data will be deleted after
              <b>{{ settingsObj.mqtt_pro_mqtt_ttl }}</b> days. There's no way to
              restore it
            </div>
            <div v-else>
              Your MQTT data will not be deleted!
              <b>This may blow up your database</b>
            </div>
          </div>
        </div>
      </div>
    </div>

    <b-button variant="success" block @click="checkNextStep">Finish</b-button>
  </div>
</template>
<script>
export default {
  name: "Step5",
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      dataObj: {},
      settingsObj: null,
    };
  },
  methods: {
    nextStep() {
      this.$emit("nextStep");
    },
    checkNextStep() {
      this.nextStep();
    },
    makeAlert(title, body) {
      alert(title, body);
    },
    saveSetings() {},
    convertToSettingsObj() {
      var self = this;
      var settingsObj = {
        mqtt_pro_mqtt_url: null,
        mqtt_pro_mqtt_port: null,
        mqtt_pro_mqtt_client_id: null,
        mqtt_pro_requires_auth: null,
        mqtt_pro_mqtt_user: null,
        mqtt_pro_mqtt_password: null,
        mqtt_pro_mqtt_topics: null,
        mqtt_pro_mqtt_interval: null,
        mqtt_pro_has_ttl: null,
        mqtt_pro_mqtt_ttl: null,
        mqtt_pro_active: null,
      };
      if (!self.data[1].acceptedTerms) {
        this.makeAlert("1", "1");
        this.$emit("goTo", 1);
        return;
      }
      if (!self.data[2].testPassed) {
        this.makeAlert("2", "2");
        this.$emit("goTo", 2);
        return;
      }
      settingsObj.mqtt_pro_mqtt_url = self.data[2].url;
      settingsObj.mqtt_pro_mqtt_port = self.data[2].port;
      settingsObj.mqtt_pro_mqtt_client_id = self.data[2].ClientID;
      settingsObj.mqtt_pro_requires_auth = self.data[2].isSecured;
      settingsObj.mqtt_pro_mqtt_user = self.data[2].username;
      settingsObj.mqtt_pro_mqtt_password = self.data[2].password;

      if (!self.data[3].topics.length > 0) {
        this.makeAlert("3", "3");
        this.$emit("goTo", 3);
        return;
      }
      settingsObj.mqtt_pro_mqtt_topics = "" + self.data[3].topics.join();
      settingsObj.mqtt_pro_mqtt_topics_arr = self.data[3].topics;

      if (
        !self.data[4].ttl &&
        (!self.data[4].keepData || !self.data[4].interval)
      ) {
        this.makeAlert("4", "4");
        this.$emit("goTo", 4);
        return;
      }

      settingsObj.mqtt_pro_mqtt_interval = self.data[4].interval;
      settingsObj.mqtt_pro_has_ttl = !self.data[4].keepData;
      settingsObj.mqtt_pro_mqtt_ttl = self.data[4].ttl;
      settingsObj.mqtt_pro_active = false;
      this.settingsObj = settingsObj;
      return settingsObj;
    },
  },
  async created() {
    var self = this;
    console.log(self.convertToSettingsObj());
    var settingsOBJ = self.convertToSettingsObj();
    const res = await self.sendPostReqG(
      "/wp-json/myapp/v1/settings",
      settingsOBJ
    );
    console.log(res);
  },
};
</script>
