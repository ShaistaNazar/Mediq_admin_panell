<template>
  <div   class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit Service</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/Services"><a>Service</a></router-link></li>
        <li class="breadcrumb-item active">Edit Service</li>
        </ol>
    </div>
    <div class="row">
      <div class="col-sm-6 hide">
        <div class="card">
          <!-- <div class="card-header">
            <h6>Edit the service_name of City </h6>
          </div> -->
          <div class="card-body">
            <form  v-on:submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputFirstservice_name">Service Name</label>
                  <input
                    id="inputCityservice_name"
                    type="text"
                    class="form-control"
                    placeholder="service_name"
                    :class="{ 'is-invalid': $v.form.service_name.$error }"
                    v-model.trim="form.service_name"
                    @input="$v.form.service_name.$touch()"
                  >
                 </div>
                 <div class="form-group col-md-12">
                  <label >Add to In-Demand</label>
                  <toggle-button :value="form.in_demand"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    class="toggleStyle"
                    v-model.trim="form.in_demand"
                    />
                </div>
             </div>
             <h3>Select the cities for service</h3>
              <div class="service_cities">
                <div v-for="(city, index) in cities"
              v-bind:key="city.id"
              v-bind:value="city.code"
              v-bind:title="city.value"
              v-on:remove="cities.splice(index, 1)">
              
              <p-check class="p-default p-round p-thick" 
                            color="info-o" v-model="form.cities" :value="city.id"><span class="service_city_name">
                              {{city.city_name}}
                              </span></p-check>
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
    this.getService();
    this.getCities();
  },
  data() {
    return {
      Read: "",
      Write: "",
      Delete: "",
      
      cities: [],
      form: {
        service_name: "",
        in_demand: false,
        cities: [],
        submitBtn: "Update",
      }
    };
  },
  validations: {
    form: {
      service_name: {
      required,
      minLength: minLength(4)
      },
    } 
  },
  methods: {
    
    async getCities () {

      try {
        const response = await axios.get(`/api/admin/cities/getCitiesToShow`)
        this.cities = response.data;
        console.log(this.cities)

      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
      async submit() {
        this.$v.form.$touch();
        if(this.$v.form.$error) return;
        try {
        this.form.Id = this.$route.params.ServicesId;
        let response = await window.axios.post('/api/admin/Services/update', { data: this.form });
        window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
         this.$router.push('/Services')
        } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
      },
      async getService () {
      try {
        let Id = this.$route.params.ServicesId;
        const response = await axios.get(`/api/admin/Services/edit/${Id}`)
        this.form.service_name =  response.data.service_name;
        this.form.in_demand = response.data.in_demand;
        this.form.cities = response.data.cities;

        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
  async cancel()
      {
           this.$router.push('/Services')
      },
    }
};
</script>
