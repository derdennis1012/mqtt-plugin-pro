import Vue from "vue";
import Router from "vue-router";
import Home from "admin/pages/Home.vue";
import Settings from "admin/pages/Settings.vue";
import Setup from "admin/pages/Setup.vue";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      name: "Home",
      component: Home,
    },
    {
      path: "/settings",
      name: "Settings",
      component: Settings,
    },
    {
      path: "/setup",
      name: "Setup",
      component: Setup,
    },
  ],
});
