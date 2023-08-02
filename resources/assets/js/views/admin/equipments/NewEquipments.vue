<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Add Equipments</h3>
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
        <li class="breadcrumb-item active">Add</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-8">
        <div class="card">
          <div class="card-body">
            <form autocomplete="off" @submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputUserName">Equipment Name*</label>
                  <input
                    id="inputUserName"
                    v-model.trim="form.equipment_name"
                    :class="{ 'is-invalid': $v.form.equipment_name.$error }"
                    type="text"
                    class="form-control"
                    placeholder="Equipment Name"
                    @input="$v.form.equipment_name.$touch()"
                  >
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

              <div v-if="form.is_rental == true" class="service_cities">

                <h3>Select the cities for Equipments</h3>
                <div v-for="(city, index) in cities"
                     :key="city.id"
                     :value="city.code"
                     :title="city.value"
                     @remove="cities.splice(index, 1)">

                  <p-check v-model="form.cities"
                           :value="city.id" class="p-default p-round p-thick" color="info-o"><span class="service_city_name">
                             {{ city.city_name }}
                  </span></p-check>
                </div>

              </div>

              <div v-if="form.is_rental == false" class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputUserName">Price*</label>
                  <input
                    id="inputUserName"
                    v-model.trim="form.price"
                    :class="{ 'is-invalid': $v.form.price.$error }"
                    type="number"
                    min= "0"
                    step= "0.01"
                    class="form-control"
                    placeholder="Price"
                    @input="$v.form.price.$touch()"
                  >
                  <div v-if="$v.form.price.$error">
                    <span v-if="!$v.form.price.required" class="help-block help-block-error">
                      Field is required
                    </span>
                  </div>
                </div>
                <!-- <div class="form-group col-md-6">
                  <label for="inputEmail">Available Quantity</label>
                  <input
                    id="inputEmail"
                    type="number"
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

              <!-- <div class="form-row">
               <div class="form-group col-md-6">
                  <label for="inputEmail">Select Pharmacy</label>
                  <select required id="inputRole" class="form-control" placeholder="Select Pharmacy" v-model="form.selectedPharmacy">
                     <option
                        v-for="Onepharmacy in form.pharmacy"
                        :key="Onepharmacy"
                        > {{Onepharmacy.pharmacy_name}}
                     </option>
                  </select>
                </div>

                 <div class="form-group col-md-6">
                  <label for="inputEmail">Select Category</label>
                  <select required id="inputRole" class="form-control" placeholder="Select Category" v-model="form.selectedCategory">
                     <option
                        v-for="OneEquipments in form.category"
                        :key="OneEquipments"
                        > {{OneEquipments.category_name}}
                     </option>
                  </select>
                </div>

               </div> -->

              <div v-if="form.is_rental == false" class="form-row">

                <div class="custom-file">
                  <label for="packageImage">Choose Image  (jpg, jpeg, gif, png)</label>
                  <input
                    id="packageImage"
                    ref="file"
                    type="file"
                    class="form-control"
                    accept="image/*"
                    name="packageImage"
                  >

                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail">Brand*</label>
                  <input
                    id="inputEmail"
                    v-model.trim="form.brand"
                    :class="{ 'is-invalid': $v.form.brand.$error }"
                    type="text"
                    class="form-control"
                    placeholder="Brand"
                    @input="$v.form.brand.$touch()"
                  >
                  <div v-if="$v.form.brand.$error">
                    <span v-if="!$v.form.brand.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.brand.minLength" class="help-block help-block-error">
                      Brand Name must have at least {{ $v.form.brand.$params.minLength.min }} letters.
                    </span>
                  </div>
                </div>

              </div>
              <div v-if="form.is_rental == false" class="form-group">
                <label for="inputDescription">Description*</label>
                <b-form-textarea
                  id="inputDescription"
                  v-model.trim="form.Description"
                  type="text"
                  class="form-control"
                  rows="3"
                  max-rows="6"
                  placeholder="Description"
                />
              </div>

              <button v-if="form.is_rental == false"
                      :disabled="$v.form.$invalid"
                      type="submit"
                      class="btn btn-primary"
              >{{ form.submitBtn }}</button>
              <button v-if="form.is_rental == true"
                      :disabled="$v.form.equipment_name.$invalid"
                      type="submit"
                      class="btn btn-primary"
              >{{ form.submitBtn }}</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <!-- <div class="form-group col-md-6">

                    <img  @error="onImageLoadFailure($event)"  height="27" :src="imagelink + form.Equipments_image" />
                  </div> -->
      </div>
    </div>
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from 'vuelidate/lib/validators'
import DatePicker from 'vue2-datepicker'
import Vue from 'vue'
import { imageLink } from '../../../helpers/constants'
import Ls from '../../../services/ls'
import PrettyCheckbox from 'pretty-checkbox-vue'
Vue.use(PrettyCheckbox)

export default {
  components: {
    DatePicker
  },

  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      cities: [],
      id: '',
      form: {
        ID: '',
        imagelink: imageLink,
        image: '',
        equipment_name: '',
        Description: '',
        price: '',
        // quantity:"",
        brand: '',
        is_rental: false,
        cities: [],
        submitBtn: 'Submit'
      }
    }
  },
  validations: {
    form: {
      equipment_name: {
        required,
        minLength: minLength(2)
      },
      price: {
        required
      },
      brand: {
        required,
        minLength: minLength(2)
      },
      // quantity:{
      //   required,
      // },
      Description: {
        required
      }
    }
  },
  mounted () {
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
    this.getCities()
  },

  methods: {
    async updateProfilePic (id) {
      if (this.$refs.file.files[0] != undefined) {
        this.selectedFile = this.$refs.file.files[0]
        let formData = new FormData()
        formData.append('name', this.selectedFile.name)
        formData.append('file', this.selectedFile)
        formData.append('id', this.admin_id)
        try {
          let userId = this.id
          let response = await window.axios.post(`/api/admin/Equipments/updatepimage/${userId}`,
            formData,
            {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            }
          )
          this.icon = response.data.trim()
        } catch (error) {
          if (error) {
            window.toastr['error']('Something went wrong', 'Error')
          }
        }
      }
    },

    async submit () {
      try {
        let response = await window.axios.post(
          '/api/admin/Equipments/add',
          { data: this.form }
        )
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.id = response.data.ResponseHeader.id
        this.updateProfilePic(this.id)
        this.$router.push('/equipments')
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response.data.ResponseHeader.ResponseMessage,
            'Error'
          )
        }
      }
    },
    async cancel () {
      this.$router.push('/equipments')
    },
    async getCities () {
      try {
        const response = await axios.get(`/api/admin/cities/getCitiesToShow`)
        this.cities = response.data
        console.log(this.cities)
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    }

  }
}
</script>
