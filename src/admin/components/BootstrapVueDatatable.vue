<template>
  <div class="container pt-3 pb-5">
    <h2>BootstrapVue Tabelle</h2>

    <b-row>
      <b-col md="3">
        <b-form-input
          v-model="filter"
          type="search"
          placeholder="Search"
        ></b-form-input>
      </b-col>
    </b-row>

    <b-row>
      <b-col>
        <b-table striped hover :items="posts" :filter="filter"></b-table>
        </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  props: ["posts"],
  data: () => ({
    filter: "",
  }),
};
</script>