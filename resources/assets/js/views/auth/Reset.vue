<template>
  <form @submit.prevent="validateBeforeSubmit">
    
    <div :class="['form-group', {'is-invalid': $v.registerData.password.$error}]">
      <input
        :class="{ 'is-invalid': $v.registerData.password.$error }"
        v-model.trim="registerData.password"
        class="form-control"
        placeholder="Enter Password"
        type="password"
        @change="$v.registerData.password.$touch()"
      >
      <span v-if="!$v.registerData.password.required" class="invalid-feedback">
        Password is required.
      </span>
      <span v-if="!$v.registerData.password.minLength" class="invalid-feedback">
        Password must have at least {{ $v.registerData.password.$params.minLength.min }} letters.
      </span>
    </div>
    <div :class="['form-group', {'is-invalid': $v.registerData.password_confirmation.$error}]">
      <input
        :class="{ 'is-invalid': $v.registerData.password_confirmation.$error }"
        v-model.trim="registerData.password_confirmation"
        class="form-control"
        placeholder="Retype Password"
        type="password"
        @change="$v.registerData.password_confirmation.$touch()"
      >
      <span v-if="!$v.registerData.password_confirmation.sameAsPassword" class="invalid-feedback">
        Passwords must be identical.
      </span>
    </div>
    <button class="btn btn-login btn-full">Save</button>
  </form>
</template>
<script type="text/babel">
import Auth from '../../services/auth'
import {required, minLength, email, sameAs} from 'vuelidate/lib/validators'

export default {
  data () {
    return {
      registerData: {
       
        password: '',
        password_confirmation: ''
      }
    }
  },
  validations: {
    registerData: {
      password: {
        required,
        minLength: minLength(6)
      },
      password_confirmation: {
        sameAsPassword: sameAs('password')
      },
    }
  },
  methods: {
    validateBeforeSubmit() {
      this.$v.$touch();

      if (!this.$v.$error) {
      
        Auth.reset(this.registerData).then(res => {
          if (res) {
            this.$router.push("/login");
          }
        });
      }
    }
  }
}
</script>
