<template>
  <form @submit.prevent="validateBeforeSubmit">
    <div :class="['form-group', {'is-invalid': $v.varficationData.password.$error}]">
      <input
        :class="{ 'is-invalid': $v.varficationData.password.$error }"
        v-model.trim="varficationData.password"
        class="form-control"
        placeholder="Enter Code"
        type="text"
        @input="$v.varficationData.password.$touch()"
      >
      <span v-if="!$v.varficationData.password.required" class="invalid-feedback">Code is required</span>
    </div>
   
    <div class="other-actions row">
      
    </div>
    <button type="submit" class="btn btn-theme btn-full">Verify</button>
  </form>
</template>

<script type="text/babel">
import { required, minLength, phone } from "vuelidate/lib/validators";
import Auth from "../../services/auth";

export default {
  data() {
    return {
      varficationData: {
        password: "",
      }
    };
  },
  validations: {
    varficationData: {
      password: {
        required
      }
    }
  },
  methods: {
    validateBeforeSubmit() {
      this.$v.$touch();

      if (!this.$v.$error) {
        Auth.verify(this.varficationData).then(res => {
          if (res) {
            this.$router.push("/reset");
          }
        });
      }
    }
  }
};
</script>
