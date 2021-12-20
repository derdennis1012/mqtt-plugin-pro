<template>
  <div>
    hello
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
  url,
  required,
  integer,
  positive,
  regex,
} from "../validations/validations";
import {
  BFormInput,
  BFormGroup,
  BForm,
  BRow,
  BCol,
  BButton,
} from "bootstrap-vue";

export default {
  name: "Settings",

  components: {
    ValidationProvider,
    ValidationObserver,
    BFormInput,
    BFormGroup,
    BForm,
    BRow,
    BCol,
    BButton,
  },
  data() {
    return {
      settingsData: {
        test: 123,
      },
      required,
      url,
      password,
      integer,
      positive,
      regex,
    };
  },
  created() {
    console.log(this);
  },
  methods: {
    checkConncetion() {},
    validationForm() {
      this.$refs.simpleRules.validate().then((success) => {
        if (success) {
          // eslint-disable-next-line
          alert("form submitted!");
        }
      });
    },
  },
};
</script>
