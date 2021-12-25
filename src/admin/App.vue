<template>
  <div>
    <bootstrap-vue-datatable :posts="posts"></bootstrap-vue-datatable>
  </div>
</template>

<script>
import BootstrapVueDatatable from "./components/BootstrapVueDatatable.vue";
export default {
  name: "App",
  components: {
    BootstrapVueDatatable,
  },

  data: () => ({
    posts: [
      {
        name: "hello",
        id: 1,
        date: "25-12-2021",
      },
      {
        name: "bernd",
        id: 2,
        date: "24-12-2021",
      },
      {
        name: "dickerson",
        id: 3,
        date: "26-12-2021",
      },
    ],
  }),
};
</script>