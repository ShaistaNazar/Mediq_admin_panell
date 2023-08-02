<template>
  <form @submit.prevent="validateBeforeSubmit">
   <div>
      <input
        :class="{ 'is-invalid': $v.forgotData.phone.$error }"v-model.trim="forgotData.phone"
        class="form-control"
        placeholder="Enter Phone"
        type="text"
        @input="$v.forgotData.phone.$touch()"
      >
    </div>
    
    <div class="other-actions row">
      <div class="col-sm-12 text-sm-right">
            <router-link to="/login"> <a href="/login" class="forgot-link">Back to Login</a> </router-link>
     
      </div>
    </div>
    <button type="submit" class="btn btn-theme btn-full">Send Verification Code</button>
  </form>
</template>

<script type="text/babel">
import { required, minLength, phone } from "vuelidate/lib/validators";

import Auth from "../../services/auth";

export default {
  data() {
    return {
      forgotData: {
        phone: "",
      
      }
    };
  },
  validations: {
    forgotData: {
      phone: {
        required
      }
    }
  },
  methods: {

    validateBeforeSubmit() {
      this.$v.$touch();
      if (!this.$v.$error) {
        
        Auth.forgot(this.forgotData).then(res => {
          if (res) {
            this.$router.push("/verify");
          }
        });
      }
    },
  }
};
</script>
