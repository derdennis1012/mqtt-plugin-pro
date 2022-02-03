// Edited by Lena Scheit, Dennis Bölling

import Vue from 'vue'
import Router from 'vue-router'
import Home from 'frontend/pages/Home.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
  ]
})
