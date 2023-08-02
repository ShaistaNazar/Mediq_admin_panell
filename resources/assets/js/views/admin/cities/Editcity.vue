<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit City</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/cities"><a>Cities</a></router-link></li>
        <li class="breadcrumb-item active">Edit City</li>
        </ol>
    </div>
    <div class="row">
      <div class="col-sm-6 hide">
        <div class="card">
          <!-- <div class="card-header">
            <h6>Edit the Name of City </h6>
          </div> -->
          <div class="card-body">
            <form  v-on:submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputFirstName">City Name</label>
                  <input
                    id="inputCityName"
                    type="text"
                    class="form-control"
                    placeholder="City Name"
                    :class="{ 'is-invalid': $v.form.name.$error }"
                    v-model.trim="form.name"
                    @input="$v.form.name.$touch()"
                  >
                 </div>
             </div>
                              
              <!-- <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input
                  id="exampleInputPassword1"
                  type="password"
                  class="form-control"
                  placeholder="Password"
                  :class="{ 'is-invalid': $v.form.password.$error }"
                  v-model.trim="form.password"
                  @input="$v.form.password.$touch()"
                >
                <small id="phoneHelp" class="form-text text-muted">
                  Remain empty if not update 
                </small>
                <div v-if="$v.form.password.$error">
                </div>
              </div>

              <div class="form-group">
                <label for="exampleInputrepeatPassword">Confirm Password</label>
                <input
                  id="exampleInputrepeatPassword"
                  type="password"
                  class="form-control"
                  placeholder="Confirm Password"
                  :class="{ 'is-invalid': $v.form.repeatPassword.$error }"
                  v-model.trim="form.repeatPassword"
                  @input="$v.form.repeatPassword.$touch()"
                >
                <div v-if="$v.form.repeatPassword.$error">
                  <span v-if="!$v.form.repeatPassword.sameAsPassword" class="help-block help-block-error">
                  Passwords must be identical.
                  </span>
                </div>
              </div> -->

              <button type="submit" class="btn btn-primary" :disabled="$v.form.$invalid" >{{form.submitBtn}}</button>
                   <b-button type=button @click.prevent="cancel" >Cancel</b-button>

            </form>
          </div>
        </div>
      </div>
      
    </div>
    
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";
import Ls from "../../../services/ls";

export default {
  mounted: function() {
    this.getCity();
  },
  data() {
    return {
      form: {
        name: "",
        submitBtn: "Update",
      }
    };
  },
  validations: {
    form: {
      name: {
      required,
      minLength: minLength(4)
      },
    } 
  },
  methods: {
      async submit() {
        this.$v.form.$touch();
        if(this.$v.form.$error) return;
        try {
        this.form.Id = this.$route.params.cityId;
        let response = await window.axios.post('/api/admin/cities/update', { data: this.form });
        window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
         this.$router.push('/cities')
        } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
      },
      async getCity () {
      try {
        let cityId = this.$route.params.cityId;
        const response = await axios.get(`/api/admin/cities/edit/${cityId}`)
        this.form.name =  response.data.city_name;
        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
  async cancel()
      {
           this.$router.push('/cities')
      },
    }
};
</script>
