<template>
  <div  class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit Equipment</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/equipments">
            <a>Equipments</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </div>
    <div  class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <form v-on:submit.prevent="submit" ref="equip">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputUserName">Equipment Name</label>
                  <input
                    id="inputUserName"
                    type="text"
                    class="form-control"
                    placeholder="User Name"
                    v-model.trim="form.equipment_name"
                    :class="{ 'is-invalid': $v.form.equipment_name.$error }"
                     @input="$v.form.equipment_name.$touch()"
                  />
                  <div v-if="$v.form.equipment_name.$error">
                    <span v-if="!$v.form.equipment_name.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.equipment_name.minLength" class="help-block help-block-error">
                      Equipment Name must have at least {{ $v.form.equipment_name.$params.minLength.min }} letters.
                    </span>
                </div>
                </div>
                <div class="form-group col-6 hide toggleMed">
                  <label style="width:100%">Is Rental</label>
                  <toggle-button :value="form.is_rental"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    class="toggleStyle"
                    style="float:left"
                    v-model.trim="form.is_rental"
                    />
                </div>

                
              </div>
              <div class="service_cities"  v-if="form.is_rental == true">
                
              <h3>Select the cities for Equipments</h3>
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

               <div class="form-row"  v-if="form.is_rental == false">
                <div class="form-group col-md-6">
                  <label for="inputUserName">Price</label>
                  <input
                    id="inputUserName"
                    type="text"
                    class="form-control"
                    placeholder="Price"
                    v-model.trim="form.price"
                    :class="{ 'is-invalid': $v.form.price.$error }"
                     @input="$v.form.price.$touch()"
                  />
                  <div v-if="$v.form.price.$error">
                    <span v-if="!$v.form.price.required" class="help-block help-block-error">
                      Field is required
                    </span>
                </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail">Brand</label>
                  <input
                    id="inputEmail"
                    type="text"
                    class="form-control"
                    placeholder="Brand"
                    v-model.trim="form.brand"
                    :class="{ 'is-invalid': $v.form.brand.$error }"
                     @input="$v.form.brand.$touch()"
                  />
                  <div v-if="$v.form.brand.$error">
                    <span v-if="!$v.form.brand.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.brand.minLength" class="help-block help-block-error">
                      Brand Name must have at least {{ $v.form.brand.$params.minLength.min }} letters.
                    </span>
                </div>
                </div>
                <!-- <div class="form-group col-md-6">
                  <label for="inputEmail">Available Quantity</label>
                  <input
                    id="inputEmail"
                    type="text"
                    class="form-control"
                    placeholder="Quantity"
                    v-model.trim="form.quantity"
                    :class="{ 'is-invalid': $v.form.quantity.$error }"
                     @input="$v.form.quantity.$touch()"
                  />
                  <div v-if="$v.form.quantity.$error">
                    <span v-if="!$v.form.quantity.required" class="help-block help-block-error">
                      Field is required
                    </span>
                </div>
                </div> -->
              </div> 
              <div class="form-group"  v-if="form.is_rental == false">
                <label for="inputDescription">Description</label>
                <b-form-textarea
                  id="inputDescription"
                  type="text"
                  class="form-control"
                  rows="3"
                  max-rows="6"
                  placeholder="Description"
                  v-model.trim="form.Description"
                ></b-form-textarea>
              </div>                  

              <button  v-if="form.is_rental == false"
                type="submit"
                class="btn btn-primary"
                :disabled="$v.form.$invalid"
              >{{form.submitBtn}}</button>
              <button  v-if="form.is_rental == true"
                type="submit"
                class="btn btn-primary"
                :disabled="$v.form.equipment_name.$invalid"
              >{{form.submitBtn}}</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
      </div>
           <div class="col-sm-6"   v-if="form.is_rental == false">
        <div class="card">
          <div class="card-body">
            <form v-on:submit.prevent="submit">
              <div class="form-row">
                 <div class="custom-file">
                    <label for="packageImage">Change Image  (jpg, jpeg, gif, png)</label>
                    <input
                      type="file"
                      accept="image/*"
                      class="form-control"
                      id="packageImage"
                      ref="file"
                      name="packageImage"                      
                    >
                    
                  </div>
               <div id class="container col-sm-12" align="center">
                  <div>
                    <img
                      @error="onImageLoadFailure($event)"
                      height="300"
                      :src=" imageLink + form.image"
                    >
                  </div>
                </div>
              </div>           

            </form>
          </div>
        </div>
      </div>
      </div>
    </div>
</template>

<script type="text/babel">
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";
import DatePicker from 'vue2-datepicker'
import {  imageLink } from '../../../helpers/constants' 
import Ls from "../../../services/ls"
import Vue from 'vue'
import PrettyCheckbox from "pretty-checkbox-vue";
Vue.use(PrettyCheckbox);

export default {
     components: { 
        DatePicker,
       },

  data() {
    return {
      Read: "",
      Write: "",
      Delete: "",
      cities: [],
       imageLink:  imageLink,
      form: {
        id:"",
        equipment_name:"",
        Description: "",
        brand:"",
        is_rental: false,
        price:"",
        // quantity:"",
          cities: [],
        image:"",
        submitBtn: "Submit",
      }
    };
  },
 
 validations: {
    form: {
      equipment_name: {
        required,
        minLength: minLength(2)
      },
      price: {
        required,
        minLength: minLength(2)
      },
      brand: {
        required,
      },
      // quantity:{
      //   required,
      // },
     
    } 
  },

  mounted() {
    // this.PharmcyDropdown();
    // this.EquipmentCategory();
    this.getEquipment();
    this.getCities();
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
  },
  methods: {
    async updateProfilePic(id) {
      if(this.$refs.file.files[0] != undefined){
        this.selectedFile = this.$refs.file.files[0];
      let formData = new FormData();
      formData.append("name", this.selectedFile.name);
      formData.append("file", this.selectedFile);
      formData.append("id", this.admin_id);
      try {
        let userId = this.form.id;
          let response = await window.axios.post(`/api/admin/Equipments/updatepimage/${userId}`,
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          }
        );
        this.form.image = response.data.trim();       
      } catch (error) {
        if (error) {
          window.toastr["error"]("Something went wrong", "Error");
        }
      }

      }
      
    },

    async submit() {
      try {
        
        let response = await window.axios.post(
          "/api/admin/Equipments/update",
          { data: this.form }
        );
        this.updateProfilePic(this.form.id);
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        this.$router.push("/equipments");
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
      this.$router.push("/equipments");
    },
        async getEquipment() {
      try {
        let userId = this.$route.params.EquipmentsId;
        const response = await axios.get(
          `/api/admin/Equipments/edit/${userId}`
        );
        this.form.equipment_name = response.data.equipment_name;
        this.form.brand = response.data.brand;
        this.form.price = response.data.price;
        this.form.image = response.data.image;
        this.form.is_rental = response.data.is_rental;

        this.form.id = response.data.id;
        // this.form.quantity = response.data.quantity;
        this.form.Description = response.data.description;
        this.form.cities = response.data.cities;

      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
     onImageLoadFailure(event) {
      event.target.src = this. imageLink +  "equipmentImg/equipmets-icon.jpg";
    },
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
  }
};
</script>
