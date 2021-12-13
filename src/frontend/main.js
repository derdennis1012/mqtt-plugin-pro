import Vue from "vue";
import App from "./App.vue";
import router from "./router";

import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

import moment from "moment";


var  elements  =  document.querySelectorAll('[data-pk-atts]');
var instances = [];
var vueInstances = [];
for(var i =0; i<elements.length; i++){
  var element = elements[i];
  var clss = element.getAttribute("class").split("mqtt-pro-whopper-")[1];
  instances.push(clss)
}

for(var i = 0; i<instances.length;i++){
  // Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

Vue.config.productionTip = false;



Vue.prototype.moment = moment;

  console.log("#vue-frontend-app-"+instances[i])
/* eslint-disable no-new */
var data = {instance: instances[i]}
Object.freeze(data)

vueInstances[i] = new Vue({
  el: "#vue-frontend-app-"+instances[i],
  router,
  data:data,
  render: (h) => h(App),
});
}

