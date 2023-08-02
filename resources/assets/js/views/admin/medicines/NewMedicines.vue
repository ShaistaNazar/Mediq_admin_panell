<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Add Medicine</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/medicines">
            <a>Medicines</a>
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
                  <label for="inputUserName">Medicine Name*</label>
                  <input
                    id="inputUserName"
                    v-model.trim="form.medicine_name"
                    :class="{ 'is-invalid': $v.form.medicine_name.$error }"
                    type="text"
                    class="form-control"
                    placeholder="Medicine Name"
                    @input="$v.form.medicine_name.$touch()"
                  >
                  <div v-if="$v.form.medicine_name.$error">
                    <span v-if="!$v.form.medicine_name.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.medicine_name.minLength" class="help-block help-block-error">
                      Medicine Name must have at least {{ $v.form.medicine_name.$params.minLength.min }} letters.
                    </span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputUserName">Price*</label>
                  <input
                    id="inputUserName"
                    v-model.trim="form.price"
                    :class="{ 'is-invalid': $v.form.price.$error }"
                    type="number"
                    min= 0
                    step= 0.01
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
-->

              <div class="form-row">

                <div class="custom-file">
                  <label for="packageImage">Choose Image  (jpg, jpeg, gif, png)</label>
                  <input
                    id="packageImage"
                    ref="file"
                    type="file"
                    accept="image/*"
                    class="form-control"
                    name="packageImage"
                  >

                </div>

                <div class="form-group col-4 hide toggleMed">
                  <label style="width:100%">PrescriptionRequired?</label>
                  <toggle-button :value="form.is_prescription_req"
                                 :sync="true"
                                 :labels="{checked: 'Yes', unchecked: 'No'}"
                                 v-model.trim="form.is_prescription_req"
                                 color="#1a1a44"
                                 class="toggleStyle"
                                 style="float:left"
                  />
                </div>
              </div>

              <div class="form-row">

                <div class="form-group col-md-6">
                  <label for="inputEmail">Select Category*</label>
                  <select id="inputRole" v-model="form.category_id" required class="form-control" placeholder="Select Category">
                    <option value="">Select Category</option>
                    <option
                      v-for="OneMedicine in category"
                      :key="OneMedicine"
                      :value="OneMedicine.id"
                    > {{ OneMedicine.category_name }}
                    </option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="inputComposition">Composition*</label>
                  <input
                    id="inputComposition"
                    v-model.trim="form.composition"
                    type="text"
                    class="form-control"
                    placeholder="Composition"
                    @input="$v.form.composition.$touch()"
                  >
                  <div v-if="$v.form.composition.$error">
                    <span
                      v-if="!$v.form.composition.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                  </div>
                </div>

              </div>

              <!-- <div class="form-row">
                  <div class="form-group col-md-12">
                  <label for="inputHowToTake">How To Take</label>
                  <input
                    id="inputHowToTake"
                    type="text"
                    class="form-control"
                    placeholder="How To Take"
                    v-model.trim="form.howToTake"
                    :class="{ 'is-invalid': $v.form.howToTake.$error }"
                    @input="$v.form.howToTake.$touch()"
                  />
                  <div v-if="$v.form.howToTake.$error">
                    <span
                      v-if="!$v.form.howToTake.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                  </div>
                </div>
              </div> -->

              <div class="form-group">
                <label for="inputPrimaryUse">Indication</label>
                <b-form-textarea
                  id="inputPrimaryUse"
                  v-model.trim="form.PrimaryUse"
                  type="text"
                  class="form-control"
                  rows="3"
                  max-rows="6"
                  placeholder="Indication"
                />
              </div>

              <a class="btn btn-warning" @click="addRow"><i class="icon-fa icon-fa-plus"/> Add Medicine Contradiction</a>
              <ul>
                <li v-for="(input, index) in this.form.MedicineWarnings" :key="input.id">
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="inputTitle">Title</label>
                      <input
                        id="inputTitle"
                        v-model="input.title"
                        type="text"
                        class="form-control"
                        placeholder="Contradiction Title"
                      >
                    </div>
                    <div class="form-group col-md-8">
                      <label for="inputDetail">Detail</label>
                      <b-form-textarea
                        id="inputDetail"
                        v-model="input.detail"
                        type="text"
                        class="form-control"
                        rows="3"
                        max-rows="6"
                        placeholder="Contradiction Detail"
                      />
                    </div>
                    <i class="icon-fa icon-fa-times" @click="deleteRow(index)"/>
                  </div>

                  <!-- <input type="text" v-model="input.title"> - {{ input.one }}
        <input type="text" v-model="input.detail"> - {{ input.two }}
        <button @click="deleteRow(index)">Delete</button> -->
                </li>
              </ul>

              <button
                :disabled="$v.form.$invalid"
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

                    <img  @error="onImageLoadFailure($event)"  height="27" :src="imageLink + form.medicine_image" />
                  </div> -->
      </div>
    </div>
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from 'vuelidate/lib/validators'
import DatePicker from 'vue2-datepicker'
import { imageLink } from '../../../helpers/constants'
import Ls from '../../../services/ls'

export default {
  components: {
    DatePicker
  },

  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      id: '',
      category: '',
      form: {
        ID: '',
        imageLink: imageLink,
        medicine_image: '',
        medicine_name: '',
        price: '',
        // expiry_date:"",
        // brand:"",
        category_id: '',
        is_prescription_req: false,
        // available_quantity:"",
        composition: '',
        // howToTake: "",
        MedicineWarnings: [],
        PrimaryUse: '',
        status: false,
        submitBtn: 'Submit'
      }
    }
  },
  validations: {
    form: {
      medicine_name: {
        required,
        minLength: minLength(2)
      },
      price: {
        required,
        minLength: minLength(2)
      },
      // expiry_date: {
      //   required,
      // },
      // brand: {
      //   required,
      // },
      // available_quantity:{
      //   required,
      // },
      composition: {
        required
      },
      // howToTake: {
      //   required
      // },
      // PrimaryUse: {
      //   required
      // },
      // MedicineWarnings: {
      //   title:required
      // }
      // phone: {
      //   required,
      //   minLength: minLength(11),
      //   async isUnique(value) {
      //     if (value === "") return true;
      //     let response = await window.axios.post("/api/phone-exist", {
      //       phone: value
      //     });
      //     return response.data;
      //   }
      // }
    }
  },

  mounted () {
    // this.PharmcyDropdown();
    this.MedicineCategory()
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
        let response = await window.axios.post(`/api/admin/medicines/updatepimage/${userId}`,
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
        let response = await window.axios.post(
          '/api/admin/medicines/add',
          { data: this.form }
        )
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.id = response.data.ResponseHeader.id
        this.updateProfilePic(this.id)
        this.$router.push('/medicines')
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
      this.$router.push('/medicines')
    },

    async MedicineCategory () {
      try {
        const response = await axios.get(
          `/api/admin/medicineCategory/MedicineCategory`
        )
        this.category = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    changeValue (index) {
      this.form.permissions[index].enable = true
    },
    addRow () {
      this.form.MedicineWarnings.push({
        title: '',
        detail: ''
      })
    },
    deleteRow (index) {
      this.form.MedicineWarnings.splice(index, 1)
    }
  }
}
</script>
