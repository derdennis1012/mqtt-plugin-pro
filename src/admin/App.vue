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

  data() {
    return {
      fields: [
        { key: "id", label: "ID", type: "number"},
        { key: "topic", label: "Topic", type: "text" },
        { key: "recordCreated", label: "RecordCreated", type: "date" },
      ],
       items: [
          { id: 40, topic: "hallo", recordCreated: "22-10-2020"},
          { id: 40, topic: "tschüss", recordCreated: "23-10-2020"},
          { id: 40, topic: "byebye", recordCreated: "24-10-2020"},
        ]
    };
  }






};
</script>