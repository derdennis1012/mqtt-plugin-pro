import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import menuFix from "./utils/admin-menu-fix";

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

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
  el: "#vue-admin-app",
  router,
  render: (h) => h(App),
});

// fix the admin menu for the slug "vue-app"
menuFix("vue-app");
