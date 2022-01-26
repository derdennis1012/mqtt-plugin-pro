import Vue from "vue";
import Router from "vue-router";
import Home from "admin/pages/Home.vue";
import Settings from "admin/pages/Settings.vue";
import Setup from "admin/pages/Setup.vue";
import About from "admin/pages/About.vue";
import APIDocs from "admin/pages/APIDocs.vue";

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
    {
      path: "/about",
      name: "About",
      component: About,
    },
    {
      path: "/api-docs",
      name: "API Docs",
      component: APIDocs,
    },
  ],
});
