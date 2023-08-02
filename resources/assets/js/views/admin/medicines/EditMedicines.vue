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
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-8">
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputUserName">Medicine Name</label>
                  <input
                    id="inputUserName"
                    v-model.trim="form.medicine_name"
                    :class="{ 'is-invalid': $v.form.medicine_name.$error }"
                    type="text"
                    class="form-control"
                    placeholder="User Name"
                    @input="$v.form.medicine_name.$touch()"
                  >
                  <!-- <div v-if="$v.form.medicine_name.$error">
                    <span
                      v-if="!$v.form.medicine_name.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.medicine_name.minLength"
                      class="help-block help-block-error"
                    >Medicine Name must have at least {{ $v.form.medicine_name.$params.minLength.min }} letters.</span>
                  </div> -->
                </div>
                <div class="form-group col-md-6">
                  <label for="inputUserName">Price</label>
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
                  <!-- <div v-if="$v.form.price.$error">
                    <span
                      v-if="!$v.form.price.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                  </div> -->
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
              </div>-->

              <!-- <div class="form-row">
                <div style="width:50%">
                  <label style="width:100%">Expiry Date</label>
                  <date-picker
                    v-model.trim="form.expairy_date"
                    :class="{ 'is-invalid': $v.form.expairy_date.$error }"
                    lang="en"
                    format="YYYY-MM-DD"
                    @input="$v.form.expairy_date.$touch()"
                  ></date-picker>
                </div>
                <div class="form-group col-4 hide toggleMed">
                  <label style="width:100%">Prescription Required ?</label>
                  <toggle-button
                    :value="form.is_prescription_req"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    class="toggleStyle"
                    style="float:left"
                    v-model.trim="form.is_prescription_req"
                  />
                </div>
              </div> -->

              <div class="form-row">
                <div class="custom-file">
                  <label for="packageImage">Choose Image (jpg, jpeg, gif, png)</label>
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
                  <label style="width:100%">Prescription Required??</label>
                  <toggle-button
                    :value="form.is_prescription_req"
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
                  <label for="inputEmail">Select Category</label>
                  <select id="inputRole" v-model="form.category_id" required class="form-control" placeholder="Select Category">
                    <option
                      v-for="OneMedicine in category"
                      :key="OneMedicine"
                      :value="OneMedicine.id"
                    > {{ OneMedicine.category_name }}
                    </option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputComposition">Composition</label>
                  <input
                    id="inputComposition"
                    v-model.trim="form.composition"
                    type="text"
                    class="form-control"
                    placeholder="Composition"
                    @input="$v.form.composition.$touch()"
                  >
                  <!-- <div v-if="$v.form.composition.$error">
                    <span
                      v-if="!$v.form.composition.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                  </div> -->
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

              <div v-if="this.form.MedicineWarnings.length != 0">
                Medicine Contradiction
                <div
                  v-for="(OneIndex, idX) in this.form.MedicineWarnings"
                  :key="idX"
                  :medicine_id="OneIndex.id"
                  class="row"
                >
                  <div class="form-group col-md-3">
                    <label for="inputTitle">Title</label>
                    <input
                      id="inputTitle"
                      v-model.trim="OneIndex.title"
                      type="text"
                      class="form-control"
                      placeholder="Warning"
                    >
                  </div>
                  <div class="form-group col-md-8">
                    <label for="inputDetail">Detail</label>
                    <b-form-textarea
                      id="inputDetail"
                      v-model.trim="OneIndex.detail"
                      type="text"
                      class="form-control"
                      rows="3"
                      max-rows="6"
                      placeholder="Contradiction detail"
                    />

                  </div>
                <!-- <i class="icon-fa icon-fa-times 2" @click="deleteRow(idX)"/> -->

                </div>

              </div>

              <a class="btn btn-warning" @click="addRow"><i class="icon-fa icon-fa-plus"/> Add Medicine Contradiction</a>
              <ul>
                <li v-for="(input, index) in this.form.addMedicineWarnings" :key="input.id">
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
        </div>-->
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
      category: '',
      form: {
        id: '',
        medicine_name: '',
        // brand: "",
        // expairy_date: "",
        category_id: '',
        is_prescription_req: '',
        // medicine_name: "",
        // available_quantity:"",
        price: '',
        composition: '',
        // howToTake: "",
        MedicineWarnings: [],
        addMedicineWarnings: [],
        PrimaryUse: '',
        status: '',
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
      }
      // expairy_date: {
      //   required
      // },
      // brand: {
      //   required
      // },

      // composition: {
      //   required
      // },
      // howToTake: {
      //   required
      // },
      // PrimaryUse: {
      //   required
      // },
      // MedicineWarnings: {
      //   required
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
    this.getMedicine()
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
        let response = await window.axios.post(
          `/api/admin/medicines/updatepimage/${userId}`,
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
      try {
        this.$v.form.$touch()
        if (this.$v.form.$error) return
        let response = await window.axios.post('/api/admin/medicines/update', {
          data: this.form
        })
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
    async getMedicine () {
      try {
        let userId = this.$route.params.medicineId
        const response = await axios.get(`/api/admin/medicines/edit/${userId}`)
        this.form.medicine_name = response.data.medicine_name
        // this.form.expairy_date = response.data.expairy_date;
        // this.form.brand = response.data.brand;
        this.form.price = response.data.price
        this.form.is_prescription_req = response.data.is_prescription_req
        this.form.status = response.data.status
        // this.form.medicine_name = response.data.medicine_name;
        this.form.id = response.data.id
        this.form.category_id = response.data.category_id
        // this.form.available_quantity = response.data.available_quantity;
        this.form.composition = response.data.composition
        // this.form.howToTake = response.data.how_to_take;
        this.form.PrimaryUse = response.data.primary_use
        this.form.MedicineWarnings = response.data.medicine_warning
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
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
      this.form.addMedicineWarnings.push({
        title: '',
        detail: ''
      })
    },
    deleteRow (index) {
      this.form.addMedicineWarnings.splice(index, 1)
    }
  }
}
</script>
