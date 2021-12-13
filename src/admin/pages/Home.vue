<template>
  <div class="home">
    <span>{{ msg }}</span>
    <DataTable></DataTable>
  </div>
</template>

<script>
import DataTable from '../components/DataTable.vue'
export default {

  name: 'Home',
  components:{
    DataTable
    },
  data () {
    return {
      msg: 'Welcome to Your Vue.js Admin App'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
