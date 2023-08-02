<template>
  <div  class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit Employees</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/users">
            <a>Employees</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <form v-on:submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputUserName">Pharmacy Names</label>
                  <input
                    id="inputUserName"
                    type="text"
                    class="form-control"
                    placeholder="Pharmacy Names"
                    v-model.trim="form.pharmacies.pharmacy_name"
                  />
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail">Select City</label>
                  <select required id="inputRole" class="form-control" placeholder="Select City" v-model.trim="form.selectedCity">
                     <option
                        v-for="city in form.cities"
                        :key="city"
                        > {{city.city_names}}
                     </option>
                  </select>
                </div>
              </div>

              <button
                type="submit"
                class="btn btn-primary"
                :disabled="form.$invalid"
              >{{form.submitBtn}}</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";

export default {
  data() {
    return {
      Read: "",
      Write: "",
      Delete: "",
      form: {
          pharmacies:"",
          cities:"",
          selectedCity:"",
          submitBtn: "Submit",
      }
    };
  },

  mounted() {
    this.getPharmacies();
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
  },
  methods: {
    async submit() {
      try {
        let response = await window.axios.post(
          "/api/admin/pharmacies/update",
          { data: this.form }
        );
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
       // this.$router.push("/pharmacies");
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
    async cancel() {
      this.$router.push("/employees");
    },
    async getPharmacies() {
      try {
        let pharmaciesId = this.$route.params.pharmaciesId;
        const response = await axios.get(
          `/api/admin/pharmacies/edit/${pharmaciesId}`
        );
        this.form.pharmacies = response.data.pharmacies;
        this.form.cities = response.data.cities;
        // this.form.cityName = response.data.pharmacies.allcities[0].city_names;
        // alert(this.form.cityName);
        console.log(this.form);
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    changeValue(index) {
      this.form.permissions[index].enable = true;
    }
  }
};
</script>
