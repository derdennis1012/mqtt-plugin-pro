<template>
  <div class="container pt-3 pb-5">
    <h2>Datatable for MQTT Broker Values</h2>
    <b-row>
      <b-col md="3">
        <b-form-input v-model="filter" type="search" placeholder="Search.."></b-form-input>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table striped hover :items="elements" :filter="filter" :per-page="perPage"
                 current-page="currentPage" :fields="fields">
          <template v-slot:cell(actions)="data">
            <b-button variant="danger" @click="deleteItem(elements.id)">Delete</b-button>
          </template>
        </b-table>
        <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage"></b-pagination>
      </b-col>
    </b-row>
  </div>
</template>


<script>
var elmnts = document.querySelectorAll("[data-pk-atts]");

export default {
  name: "BootstrapVueDatatable",
  components: {},

  data() {
    return {
      elements: ["elmnts"],
      found: null,
      arrayValues: null,
      filter: "",
      perPage: 5,
      currentPage: 1,
      fields: ["ID", "Topic", "DataSet", "RecordCreated", "actions"]
    };

  },
  computed: {
    rows() {
      return this.elements.length;
    }
  },


  methods: {

    deleteItem(id) {
      const index = this.elements.indexOf((x) => x.id === id);
      this.elements.splice(index, 1);
    },

    removeRowHandler(index) {
      var self = this;
      const requestOptions = {
        method: "POST",
        headers: {"Content-Type": "application/json"},
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
        method: "GET",
        headers: {"Content-Type": "application/json"},
      };
      fetch(
          self.found.site_url + "/wp-json/mqtt-plugin-pro/v1/mqtt-functions/get/all",
          requestOptions
      )
          .then((response) => response.json())
          .then((data) => {
            console.log(data);
            self.arrayValues = data;
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
