// Edited by Lena Scheit, Dennis Bölling
import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import menuFix from "./utils/admin-menu-fix";

//Fontawesome
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fad } from "@fortawesome/pro-duotone-svg-icons";
import { fal } from "@fortawesome/pro-light-svg-icons";
import { fas } from "@fortawesome/pro-solid-svg-icons";
import { far } from "@fortawesome/pro-regular-svg-icons";

library.add(fad);
library.add(fal);
library.add(fas);
library.add(far);
Vue.component("font-awesome-icon", FontAwesomeIcon);

import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);

// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

import "./style.css";
import "./customStyle.css";

import moment from "moment";

Vue.prototype.moment = moment;

import VueConfetti from "vue-confetti";

Vue.use(VueConfetti);

import { globalMixin } from "./globalMixin";
Vue.mixin(globalMixin);

Vue.config.productionTip = false;


import vSelect from 'vue-select';
Vue.component('v-select', vSelect);
import 'vue-select/dist/vue-select.css';

new Vue({
  el: "#vue-admin-app",
  router,
  render: (h) => h(App),
});

menuFix("mqtt-plugin-pro");
