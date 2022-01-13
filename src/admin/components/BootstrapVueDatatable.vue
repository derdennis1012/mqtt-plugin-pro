<template>
  <b-table class="b-table" :fields="fields" :items="items" fixed> </b-table>
</template>


<script>
var elmnts = document.querySelectorAll("[data-pk-atts]");

export default {
  name: "BootstrapVueDatatable",
  components: {},

  data() {
    return {
      elements: elmnts,
      found: null,

      fields: [
        { key: "id", label: "ID", type: "number" },
        { key: "topic", label: "Topic", type: "text" },
        { key: "recordCreated", label: "RecordCreated", type: "date" },
      ],
      items: [
        { id: 40, topic: "hallo", recordCreated: "22-10-2020" },
        { id: 40, topic: "tschüss", recordCreated: "23-10-2020" },
        { id: 40, topic: "byebye", recordCreated: "24-10-2020" },
      ],
    };
  },

  methods: {
    removeRowHandler(index) {
      var self = this;

      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({}),
      };
      fetch(
        self.found.site_url +
          "/wp-json/mqtt-plugin-pro/v1/mqtt-functions/delete/" +
          index,
        requestOptions
      )
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          self.getQueries();
        });
    },
    async getQueries() {
      var self = this;

      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({}),
      };
      fetch(
        self.found.site_url + "/wp-json/mqtt-plugin-pro/v1/mqtt-functions/get",
        requestOptions
      )
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
        });
    },
  },
  created() {
    var self = this;
    var fElment;

    for (var i = 0; i < self.elements.length; i++) {
      var element = self.elements[i];
      var elmt = JSON.parse(element.getAttribute("data-pk-atts"));

      fElment = elmt;
    }
    self.found = fElment;
    self.getQueries();
  },
};
</script>
