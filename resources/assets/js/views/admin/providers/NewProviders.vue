<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Add Provider Detail</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/providers">
            <a>Providers</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Register New</li>
      </ol>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <form autocomplete="off" @submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail">Email*</label>
                  <input
                    id="inputEmail"
                    :class="{ 'is-invalid': $v.form.email.$error }"
                    v-model.trim="form.email"
                    type="email"
                    class="form-control"
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                    placeholder="Email"
                    @input="$v.form.email.$touch()"
                  >
                  <div v-if="$v.form.email.$error">
                    <span v-if="!$v.form.email.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <!-- <span v-if="!$v.form.email.minLength" class="help-block help-block-error">
                      Email Name must have at least {{ $v.form.email.$params.minLength.min }} letters.
                    </span> -->
                  </div>

                </div>
                <div class="form-group col-md-6">
                  <label for="inputUserName">User Full Name*</label>
                  <input
                    id="inputUserName"
                    :class="{ 'is-invalid': $v.form.full_name.$error }"
                    v-model.trim="form.full_name"
                    type="text"
                    class="form-control"
                    placeholder="User Name"
                    @input="$v.form.full_name.$touch()"
                  >
                  <div
                    v-if="$v.form.full_name.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.full_name.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.full_name.minLength"
                      class="help-block help-block-error"
                    >User Name must have at least {{ $v.form.full_name.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.full_name.maxLength"
                      class="help-block help-block-error"
                    >User Name should not exceed {{ $v.form.full_name.$params.maxLength.max }} letters.</span>
                  </div>
                  <!-- <div v-if="$v.form.full_name.$error">
                    <span v-if="!$v.form.full_name.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.full_name.minLength" class="help-block help-block-error">
                      Name Name must have at least {{ $v.form.full_name.$params.minLength.min }} letters.
                    </span>
                  </div> -->
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleInputphone">Phone Number* <small>Format: 923001234567</small></label>
                  <input
                    id="exampleInputphone"
                    :class="{ 'is-invalid': $v.form.phone.$error }"
                    v-model.trim="form.phone"
                    type="tel"
                    class="form-control"
                    aria-describedby="phoneHelp"
                    pattern="[0-9]{2}[0-9]{3}[0-9]{7}"
                    placeholder="Enter Phone"
                    @input="$v.form.phone.$touch()"
                  >
                  <div v-if="$v.form.phone.$error">
                    <span v-if="!$v.form.phone.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.phone.minLength" class="help-block help-block-error">
                      Phone must have at least {{ $v.form.phone.$params.minLength.min }} letters.
                    </span>
                  </div>
                </div>

                <div class="form-group col-md-6" >
                  <label >DOB*</label>
                  <date-picker
                    :class="{ 'is-invalid': $v.form.dob.$error }"
                    v-model.trim="form.dob"
                    lang="en"
                    format="YYYY-MM-DD"
                    @input="$v.form.dob.$touch()"
                  >
                    <div v-if="$v.form.dob.$error">
                      <span v-if="!$v.form.dob.required" class="help-block help-block-error">
                        Field is required
                      </span>
                    </div>
                  </date-picker>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputDOB">Gender* ( Use Word | Male OR Female)</label>
                  <input
                    id="inputDOB"
                    :class="{ 'is-invalid': $v.form.gender.$error }"
                    v-model.trim="form.gender"
                    type="text"
                    class="form-control"
                    placeholder="Gender"
                    @input="$v.form.gender.$touch()"
                  >
                  <div v-if="$v.form.gender.$error">
                    <span v-if="!$v.form.gender.required" class="help-block help-block-error">
                      Field is required
                    </span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail">Select Service*</label>
                  <select id="inputRole" v-model="form.selectedService" required class="form-control" placeholder="Select Service">
                    <option value="">Select Service</option>
                    <option
                      v-for="OneService in services"
                      :key="OneService"
                      :value="OneService.id"
                    > {{ OneService.service_name }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail">Select City*</label>
                  <select id="inputRole" v-model.trim="form.selectedCity" required class="form-control" placeholder="Select City">
                    <option value="">Select City</option>
                    <option
                      v-for="city in cities.data"
                      :key="city"
                      :value="city.id"
                    > {{ city.city_name }}
                    </option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputDOB">Price* (Per Hour)</label>
                  <input
                    id="inputDOB"
                    :class="{ 'is-invalid': $v.form.price.$error }"
                    v-model.trim="form.price"
                    type="number"
                    min="0"
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
              </div>

              <button
                :disabled="$v.$invalid"
                type="submit"
                class="btn btn-primary"
              >{{ submitBtn }}</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>

          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="form-row">
                <div class="custom-file">
                  <label for="packageImage">Choose Image*  (jpg, jpeg, gif, png)</label>
                  <input
                    id="packageImage"
                    ref="file"
                    type="file"
                    class="form-control"
                    required
                    accept="image/*"
                    name="packageImage"
                  >

                </div>
                <!-- <div id class="container col-sm-12" align="center">
                  <div>
                    <img
                      @error="onImageLoadFailure($event)"
                      height="300"
                      :src=" imageLink + form.profile_picture"
                    >
                  </div>
                </div> -->
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, maxLength, between } from 'vuelidate/lib/validators'
import { Tabs, Tab } from 'vue-tabs-component'
import DatePicker from 'vue2-datepicker'
// import {  imageLink } from "../../../helpers/constants";

export default {

  components: {
    DatePicker,
    tabs: Tabs,
    tab: Tab
  },
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      //  imageLink :  imageLink,
      submitBtn: 'Add',
      services: '',
      cities: '',
      form: {
        price: '',
        full_name: '',
        dob: '',
        email: '',
        phone: '',
        gender: '',
        fromDate: '',
        toDate: '',
        fromTime: '',
        toTime: '',
        selectedCity: '',
        selectedService: '',
        Id: ''
      }
    }
  },
  validations: {
    form: {
      full_name: {
        required,
        minLength: minLength(4),
        maxLength: maxLength(15)
      },
      price: {
        required
      },
      dob: {
        required
      },
      email: {
        required,
        minLength: minLength(6)
      },
      phone: {
        required,
        minLength: minLength(11)
      },

      selectedCity: {
        required
      },
      selectedService: {
        required
      },
      gender: {
        required
      }
    }
  },
  mounted () {
    this.getServices()
    this.getCities()
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },
  methods: {
    async updateProfilePic (id) {
      this.selectedFile = this.$refs.file.files[0]
      let formData = new FormData()
      formData.append('name', this.selectedFile.name)
      formData.append('file', this.selectedFile)
      formData.append('id', this.admin_id)
      try {
        let userId = this.id
        let response = await window.axios.post(`/api/admin/providers/updatepimage/${userId}`,
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
    },
    async submit () {
      this.$v.form.$touch()
      if (this.$v.form.$error) return
      try {
        this.form.Id = this.$route.params.ProvidersId
        let response = await window.axios.post('/api/admin/providers/add', {
          data: this.form
        })
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.id = response.data.ResponseHeader.id
        this.updateProfilePic(this.id)
        this.$router.push('/providers')
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response.data.ResponseHeader.ResponseMessage,
            'Error'
          )
        }
      }
    },

    async getServices () {
      try {
        let Id = this.$route.params.ProvidersId
        const response = await axios.get(`/api/admin/Services/Dropdown/get`)
        this.services = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async getCities () {
      try {
        const response = await axios.get(
          `/api/admin/cities/get`
        )
        this.cities = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    onImageLoadFailure (event) {
      event.target.src = this.imagelink + 'users/no-photo.jpg'
    },
    async cancel () {
      this.$router.push('/providers')
    }
  }
}
</script>
