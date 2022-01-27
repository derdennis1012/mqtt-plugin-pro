import Vue from "vue";
import App from "./App.vue";
import router from "./router";

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

import moment from "moment";
import { globalMixin } from "./globalMixin";

var elements = document.querySelectorAll("[data-pk-atts]");
var instances = [];
var vueInstances = [];
for (var i = 0; i < elements.length; i++) {
  var element = elements[i];
  var clss = element.getAttribute("class").split("mqtt-pro-whopper-")[1];
  instances.push(clss);
}


for (var i = 0; i < instances.length; i++) {
  // Make BootstrapVue available throughout your project
  Vue.use(BootstrapVue);
  // Optionally install the BootstrapVue icon components plugin
  Vue.use(IconsPlugin);

  Vue.config.productionTip = false;

  Vue.prototype.moment = moment;


  console.log("#vue-frontend-app-" + instances[i]);
  /* eslint-disable no-new */
  var data = { instance: instances[i] };
  Object.freeze(data);

  vueInstances[i] = new Vue({
    el: "#vue-frontend-app-" + instances[i],
    router,
    data: data,
    render: (h) => h(App),
  });
}
