<template>
        <b-table class="b-table" :items="tableItems" :fields="fields" fixed>
            <template v-for="(field, index) in fields" #[`cell(${field.key})`]="data">
                <b-form-datepicker v-if="field.type === 'date' && tableItems[data.index].isEdit" :key="index" :type="field.type" :value="tableItems[data.index][field.key]" @input="(value) => inputHandler(value, data.index, field.key)"></b-form-datepicker>
                <b-form-select v-else-if="field.type === 'select' && tableItems[data.index].isEdit" :key="index" :value="tableItems[data.index][field.key]" @input="(value) => inputHandler(value, data.index, field.key)" :options="field.options"></b-form-select>
                <b-button :key="index" v-else-if="field.type === 'edit'" @click="editRowHandler(data)">
                <span v-if="!tableItems[data.index].isEdit">Edit</span>
                <span v-else>Done</span>
                </b-button>
                <b-form-input v-else-if="field.type && tableItems[data.index].isEdit" :key="index" :type="field.type" :value="tableItems[data.index][field.key]" @input="(value) => inputHandler(value, data.index, field.key)"></b-form-input>
                <span :key="index" v-else>{{data.value}}</span>
            </template>
        </b-table></template>


<script>
export default {
  name: "BootstrapVueDatatable",
  components: {},
  props: {
    value: Array,
    fields: Array,
  },
  data() {
    return {
            tableItems: this.value.map(item => ({...item, isEdit: false, isSelected: false})),
    }
  },
  methods: {
    removeRowHandler(index) {
        this.tableItems = this.tableItems.filter((item, i) => i !== index);
        this.$emit('input', this.tableItems);
    }
  }
};
</script>