<template>
  <form @submit.prevent="validateBeforeSubmit">
    <div :class="['form-group', {'is-invalid': $v.loginData.phone.$error}]">
      <input
        :class="{ 'is-invalid': $v.loginData.phone.$error }"
        v-model.trim="loginData.phone"
        class="form-control"
        placeholder="Enter Phone"
        type="text"
        @input="$v.loginData.phone.$touch()"
      >
      <span v-if="!$v.loginData.phone.required" class="invalid-feedback">phone is required</span>
    </div>
    <div :class="['form-group custom-login', {'is-invalid': $v.loginData.password.$error}]">
      <input
        :class="{ 'is-invalid': $v.loginData.password.$error }"
        v-model.trim="loginData.password"
        class="form-control "
        placeholder="Enter Password"
        :type="loginData.passwordFieldType"
        @input="$v.loginData.password.$touch()"
      >
      <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      >
      <div v-if="loginData.passwordFieldType === 'password'">
        <span>
          <a>
            <i
              class="fa fa-eye custom-eye-icon"
              style="font-size:16px; color:black;"
              @click="switchVisibility"
            ></i>
          </a>
        </span>
      </div>
      <div v-else-if="loginData.passwordFieldType !== 'user'">
        <span>
          <a>
            <i
              class="fa fa-eye-slash"
              style="font-size:16px;position: relative;right: -93%;bottom: 30px;color:black;"
              @click="switchVisibility"
            ></i>
          </a>
        </span>
      </div>

      <span v-if="!$v.loginData.password.required" class="invalid-feedback">Password is required</span>
      
      <span
        v-if="!$v.loginData.password.minLength"
        class="invalid-feedback"
      >Password must have at least {{ $v.loginData.password.$params.minLength.min }} letters.</span>
    </div>
    <div class="other-actions row">
      <div class="col-sm-12 text-sm-right">
        <router-link to="/forgot"> <a href="/forgot" class="forgot-link">Forgot Password?</a> </router-link>
      </div>
    </div>
    <button type="submit" class="btn btn-theme btn-full" :disabled="loginData.disable">Login</button>
  </form>
</template>

<script type="text/babel">
import { required, minLength, phone } from "vuelidate/lib/validators";
import Auth from "../../services/auth";

export default {
  data() {
    return {
      loginData: {
        phone: "",
        password: "",
        passwordFieldType: "password",
        disable: false
      }
    };
  },
  validations: {
    loginData: {
      password: {
        required,
        minLength: minLength(6)
      },
      phone: {
        required
      }
    }
  },
  methods: {
    validateBeforeSubmit() {
      this.$v.$touch();

      if (!this.$v.$error) {
        this.loginData.disable = true;
        Auth.login(this.loginData).then(res => {
          if (res) {
            this.$router.push("/dashboard");
          } else {
            this.loginData.disable = false;
          }
        });
      }
    },
    switchVisibility() {
      this.loginData.passwordFieldType =
        this.loginData.passwordFieldType === "password" ? "text" : "password";
    }
  }
};
</script>
