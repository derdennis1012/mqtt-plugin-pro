<template>
  <div class="d-flex flex-column justify-content-between h-100">
    <div class="mt-4" v-if="loaded">
      <h1 class="mb-4">
        <span @click="goBack()" v-if="!finished && !checkRunning">
          <font-awesome-icon
            class="mr-3"
            :icon="['fal', 'chevron-left']" /></span
        >5. Setup done
      </h1>
      <div v-if="!checkRunning && !finished">
        <b-alert
          :show="finished === false"
          dismissible
          variant="danger"
          @dismissed="finished = null"
        >
          <p>Something didn't work. Please try again later when you're ready</p>
        </b-alert>
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
                        {{
                          getIntervalLabel(settingsObj.mqtt_pro_mqtt_interval)
                        }}
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
            class="
              d-flex
              flex-row flex-nowrap
              w-100
              overflow-scroll
              scroll-container-custom
            "
          >
            <div
              class="
                m-2
                p-4
                border
                rounded
                topic-card
                d-flex
                align-items-center
              "
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
            class="
              bg-light-danger
              border
              rounded
              p-2
              d-flex
              justify-content-start
              align-items-center
            "
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
        <b-btn @click="saveSetings()" variant="primary" block class="mt-3"
          >Save & activate</b-btn
        >
      </div>
      <div v-if="checkRunning" class="h-100">
        <div class="h-100 w-100 m-4 p-4">
          <h4>Validating your input</h4>
          <b-list-group>
            <b-list-group-item
              class="
                list-group-item
                d-flex
                justify-content-start
                align-items-center
              "
            >
              <div class="mr-2">
                <b-spinner v-if="checkResults[0] == 'running'"></b-spinner>
                <font-awesome-icon
                  v-if="checkResults[0] === false"
                  :icon="['fad', 'times-circle']"
                  class="text-danger"
                  size="2x"
                ></font-awesome-icon>
                <font-awesome-icon
                  v-if="checkResults[0] === null"
                  :icon="['fad', 'question-circle']"
                  size="2x"
                ></font-awesome-icon>

                <font-awesome-icon
                  v-if="checkResults[0] === true"
                  :icon="['fad', 'check-circle']"
                  class="text-success"
                  size="2x"
                ></font-awesome-icon>
              </div>

              Validating settings
            </b-list-group-item>
            <b-list-group-item
              class="
                list-group-item
                d-flex
                justify-content-start
                align-items-center
              "
            >
              <div class="mr-2">
                <b-spinner v-if="checkResults[1] == 'running'"></b-spinner>
                <font-awesome-icon
                  v-if="checkResults[1] === false"
                  :icon="['fal', 'times-circle']"
                  class="text-danger"
                  size="2x"
                ></font-awesome-icon>
                <font-awesome-icon
                  v-if="checkResults[1] === null"
                  :icon="['fad', 'question-circle']"
                  size="2x"
                ></font-awesome-icon>

                <font-awesome-icon
                  v-if="checkResults[1] === true"
                  :icon="['fad', 'check-circle']"
                  class="text-success"
                  size="2x"
                ></font-awesome-icon>
              </div>

              Checking MQTT connection
            </b-list-group-item>
            <b-list-group-item
              class="
                list-group-item
                d-flex
                justify-content-start
                align-items-center
              "
            >
              <div class="mr-2">
                <b-spinner v-if="checkResults[2] == 'running'"></b-spinner>
                <font-awesome-icon
                  v-if="checkResults[2] === false"
                  :icon="['fad', 'times-circle']"
                  class="text-danger"
                  size="2x"
                ></font-awesome-icon>
                <font-awesome-icon
                  v-if="checkResults[2] === null"
                  :icon="['fad', 'question-circle']"
                  size="2x"
                ></font-awesome-icon>

                <font-awesome-icon
                  v-if="checkResults[2] === true"
                  :icon="['fad', 'check-circle']"
                  class="text-success"
                  size="2x"
                ></font-awesome-icon>
              </div>

              Send your settings to Server
            </b-list-group-item>
            <b-list-group-item
              class="
                list-group-item
                d-flex
                justify-content-start
                align-items-center
              "
            >
              <div class="mr-2">
                <b-spinner v-if="checkResults[3] == 'running'"></b-spinner>
                <font-awesome-icon
                  v-if="checkResults[3] === false"
                  :icon="['fad', 'times-circle']"
                  class="text-danger"
                  size="2x"
                ></font-awesome-icon>
                <font-awesome-icon
                  v-if="checkResults[3] === null"
                  :icon="['fad', 'question-circle']"
                  size="2x"
                ></font-awesome-icon>

                <font-awesome-icon
                  v-if="checkResults[3] === true"
                  :icon="['fad', 'check-circle']"
                  class="text-success"
                  size="2x"
                ></font-awesome-icon>
              </div>

              Activating MQTT service
            </b-list-group-item>
          </b-list-group>
        </div>
      </div>
      <div v-if="!checkRunning && finished">
        <div class="mt-3">
          <h2 class="text-center">Congratulations!</h2>
          <img class="mt-2" :src="congrats" width="100%" style="margin: auto" />
          <h1 class="text-center mt-2">
            The <b>MQTT Plugin Pro</b> is successfully configured. You can now
            start receiving your MQTT Data
          </h1>
        </div>
      </div>
    </div>

    <b-button
      variant="success"
      block
      @click="checkNextStep"
      :disabled="!finished"
      >Finish</b-button
    >
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
    congrats: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      dataObj: {},
      loaded: false,
      settingsObj: null,
      checkRunning: false,
      finished: null,
      cCheckStep: 0,
      checkResults: {
        0: null,
        1: null,
        2: null,
        3: null,
      },
    };
  },
  methods: {
    nextStep() {
      this.$router.push({ path: "/about" });
    },
    checkNextStep() {
      this.nextStep();
    },
    makeAlert(title, body) {
      alert(title, body);
    },
    goBack() {
      this.$emit("goBack");
      this.$confetti.stop();
    },
    async checkConncection() {
      var self = this;
      var settingsOBJ = await self.convertToSettingsObj();

      var res = await self.sendPostReqG(
        "/wp-json/mqtt-plugin-pro/v1/mqtt-functions/test-connection-without",
        settingsOBJ
      );
      await this.timeout(1000);
      console.log(res);

      if (res.connected) return true;
      else return false;
    },

    async sendSettingsToServer() {
      var self = this;
      var settingsobj = await self.convertToSettingsObj();
      console.log(settingsobj);
      const res = await self.sendPostReqG(
        "/wp-json/mqtt-plugin-pro/v1/settings",
        settingsobj
      );
      await this.timeout(2000);
      console.log(res);

      if (res) return true;
      else return false;
    },
    async activateService() {
      var self = this;
      var res = await self.sendGetReqG(
        "/wp-json/mqtt-plugin-pro/v1/settings/activate"
      );
      await this.timeout(2000);
      console.log(res);
      if (res) return true;
      else return false;
    },
    async checkSettings() {
      var self = this;
      this.$set(self.checkResults, 0, "running");

      var settingsobj = await self.convertToSettingsObj();
      if (!settingsobj) {
        this.$set(self.checkResults, 0, false);

        return false;
      }
      await new Promise((resolve) => setTimeout(resolve, 2000));

      this.$set(self.checkResults, 0, true);

      this.$set(self.checkResults, 1, "running");

      var r = await self.checkConncection();
      if (!r) {
        this.$set(self.checkResults, 1, false);

        return false;
      }
      this.$set(self.checkResults, 1, true);
      this.$set(self.checkResults, 2, "running");

      r = await self.sendSettingsToServer();
      if (!r) {
        this.$set(self.checkResults, 2, false);

        return false;
      }
      this.$set(self.checkResults, 2, true);

      this.$set(self.checkResults, 3, "running");

      r = await self.activateService();
      if (!r) {
        this.$set(self.checkResults, 3, false);

        return false;
      }
      this.$set(self.checkResults, 3, true);

      return true;
    },
    async timeout(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    },
    async saveSetings() {
      var self = this;
      self.checkRunning = true;
      try {
        var res = await self.checkSettings();
      } catch (e) {
        console.log(e);
      }
      await self.timeout(800);
      if (res) {
        self.checkRunning = false;
        self.finished = true;
        self.showConfetti();
      } else {
        self.checkRunning = false;
        self.finished = false;
        self.checkResults = {
          0: null,
          1: null,
          2: null,
          3: null,
        };
      }
    },
    async convertToSettingsObj() {
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
    showConfetti() {
      var self = this;
      self.$confetti.start();
    },
  },
  async created() {
    var self = this;
    self.settingsObj = await self.convertToSettingsObj();
    self.loaded = true;
  },
  beforeDestroy() {
    var self = this;
    self.$confetti.stop();
  },
};
</script>
