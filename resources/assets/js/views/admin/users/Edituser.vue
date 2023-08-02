<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit User</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/users">
            <a>Users</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <h5 class="text-bold">Personal Details</h5>
            <form
              ref="userEdit"
              @submit.prevent="submit"
            >
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail">Email</label>
                  <input
                    id="inputEmail"
                    :disabled="true"
                    v-model.trim="form.userForm.email"
                    type="text"
                    class="form-control"
                    placeholder="Email"
                  >
                </div>
                <div class="form-group col-md-6">
                  <label for="inputUserName">User Full Name*</label>
                  <input
                    id="inputUserName"
                    :class="{ 'is-invalid': $v.form.userForm.full_name.$error }"
                    v-model.trim="form.userForm.full_name"
                    type="text"
                    class="form-control"
                    placeholder="User Name"
                    @input="$v.form.userForm.full_name.$touch()"
                  >
                  <div
                    v-if="$v.form.userForm.full_name.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.userForm.full_name.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.userForm.full_name.minLength"
                      class="help-block help-block-error"
                    >User Name must have at least {{ $v.form.userForm.full_name.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.userForm.full_name.maxLength"
                      class="help-block help-block-error"
                    >User Name should not exceed {{ $v.form.userForm.full_name.$params.maxLength.max }} letters.</span>
                  </div>
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleInputphone">Phone Number</label>
                  <input
                    id="exampleInputphone"
                    :disabled="true"
                    v-model.trim="form.userForm.phone"
                    type="number"
                    min="0"
                    class="form-control"
                    aria-describedby="phoneHelp"
                    placeholder="Enter Phone"
                  >
                </div>

                <!-- <div class="form-group col-md-6">
                      <label for="inputDOB">DOB (YYYY-MM-DD)</label>
                      <input
                        id="inputDOB"
                        type="text"
                        class="form-control"
                        placeholder="DOB"
                        v-model.trim="form.dob"
                      >
                    </div> -->
              </div>

              <button
                :disabled="$v.form.userForm.$invalid"
                type="submit"
                class="btn btn-primary"
              >{{ submitBtn }}</button>
              <b-button
                type="button"
                @click.prevent="cancel"
              >Cancel</b-button>
            </form>

          </div>
        </div>
      </div>

      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <h5 class="text-bold">Shipping Details</h5>
            <form autocomplete="off" @submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail">Address*</label>
                  <input
                    id="inputEmail"
                    :class="{ 'is-invalid': $v.form.shippingForm.shippingHome_address.$error }"
                    v-model.trim="form.shippingForm.shippingHome_address"
                    type="text"
                    class="form-control"
                    placeholder="Address"
                    @input="$v.form.shippingForm.shippingHome_address.$touch()"
                  >
                  <div
                    v-if="$v.form.shippingForm.shippingHome_address.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingForm.shippingHome_address.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.shippingForm.shippingHome_address.minLength"
                      class="help-block help-block-error"
                    >Address must have at least {{ $v.form.shippingForm.shippingHome_address.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.shippingForm.shippingHome_address.maxLength"
                      class="help-block help-block-error"
                    >Address should not exceed {{ $v.form.shippingForm.shippingHome_address.$params.maxLength.max }} letters.</span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputUserName"> City*</label>
                  <!-- <input
                    id="inputUserName"
                    type="text"
                    class="form-control"
                    placeholder=" City"
                    v-model.trim="form.shippingForm.shippingCity"
                  > -->
                  <select
                    id="inputRole"
                    v-model="form.shippingForm.shippingCity"
                    :class="{ 'is-invalid': $v.form.shippingForm.shippingCity.$error }"
                    class="form-control"
                    placeholder="Select Category"
                    required
                    @input="$v.form.shippingForm.shippingCity.$touch()"

                  >
                    <option value>Select City</option>
                    <option
                      v-for="(city, idX) in cities"
                      :key="idX"
                      :value="city.city_name"
                    >{{ city.city_name }}</option>
                  </select>
                  <div
                    v-if="$v.form.shippingForm.shippingCity.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingForm.shippingCity.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                  </div>
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleInputphone"> Province*</label>
                  <!-- <input
                    id="exampleInputphone"
                    type="text"
                    class="form-control"
                    aria-describedby="phoneHelp"
                    placeholder="Enter Province"
                    v-model.trim="form.shippingForm.shippingProvince"
                  > -->
                  <select
                    id="inputRole"
                    v-model="form.shippingForm.shippingProvince"
                    :class="{ 'is-invalid': $v.form.shippingForm.shippingProvince.$error }"
                    class="form-control"
                    placeholder="Select Category"
                    required
                    @input="$v.form.shippingForm.shippingProvince.$touch()"
                  >
                    <option value>Select Province</option>
                    <option
                      v-for="(province, idX) in provinces"
                      :key="idX"
                      :value="province.province_name"
                    >{{ province.province_name }}</option>
                  </select>
                  <div
                    v-if="$v.form.shippingForm.shippingProvince.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingForm.shippingProvince.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputphone"> Phone* <small>Format: 923001234567</small></label>
                  <input
                    id="exampleInputphone"
                    v-model.trim="form.shippingForm.shippingPhone"
                    :class="{ 'is-invalid': $v.form.shippingForm.shippingPhone.$error }"
                    type="tel"
                    class="form-control"
                    pattern="[0-9]{2}[0-9]{3}[0-9]{7}"
                    aria-describedby="phoneHelp"
                    placeholder="Enter Phone"
                    @input="$v.form.shippingForm.shippingPhone.$touch()"
                  >
                  <div
                    v-if="$v.form.shippingForm.shippingPhone.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingForm.shippingPhone.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.shippingForm.shippingPhone.minLength"
                      class="help-block help-block-error"
                    >Phone must have at least {{ $v.form.shippingForm.shippingPhone.$params.minLength.min }} numbers.</span>
                    <span
                      v-if="!$v.form.shippingForm.shippingPhone.maxLength"
                      class="help-block help-block-error"
                    >Phone should not exceed {{ $v.form.shippingForm.shippingPhone.$params.maxLength.max }} numbers.</span>
                  </div>
                </div>

              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleInputphone"> First Name*</label>
                  <input
                    id="exampleInputphone"
                    v-model.trim="form.shippingForm.shippingFirstName"
                    :class="{ 'is-invalid': $v.form.shippingForm.shippingFirstName.$error }"
                    type="text"
                    class="form-control"
                    aria-describedby="phoneHelp"
                    placeholder="Enter First Name"
                    @input="$v.form.shippingForm.shippingFirstName.$touch()"
                  >
                  <div
                    v-if="$v.form.shippingForm.shippingFirstName.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingForm.shippingFirstName.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.shippingForm.shippingFirstName.minLength"
                      class="help-block help-block-error"
                    >First Name must have at least {{ $v.form.shippingForm.shippingFirstName.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.shippingForm.shippingFirstName.maxLength"
                      class="help-block help-block-error"
                    >First Name should not exceed {{ $v.form.shippingForm.shippingFirstName.$params.maxLength.max }} letters.</span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputphone"> Last Name*</label>
                  <input
                    id="exampleInputphone"
                    v-model.trim="form.shippingForm.shippingLastName"
                    :class="{ 'is-invalid': $v.form.shippingForm.shippingLastName.$error }"
                    type="text"
                    class="form-control"
                    aria-describedby="phoneHelp"
                    placeholder="Enter Last Name"
                    @input="$v.form.shippingForm.shippingLastName.$touch()"
                  >
                  <div
                    v-if="$v.form.shippingForm.shippingLastName.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingForm.shippingLastName.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.shippingForm.shippingLastName.minLength"
                      class="help-block help-block-error"
                    >First Name must have at least {{ $v.form.shippingForm.shippingLastName.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.shippingForm.shippingLastName.maxLength"
                      class="help-block help-block-error"
                    >First Name should not exceed {{ $v.form.shippingForm.shippingLastName.$params.maxLength.max }} letters.</span>
                  </div>
                </div>

              </div>

              <button
                :disabled="$v.form.shippingForm.$invalid"
                type="submit"
                class="btn btn-primary"
              >{{ submitBtn }}</button>
              <b-button
                type="button"
                @click.prevent="cancel"
              >Cancel</b-button>
            </form>

          </div>
        </div>
      </div>

      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <h5 class="text-bold">Billing Details</h5>
            <form autocomplete="off" @submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail"> Address*</label>
                  <input
                    id="inputEmail"
                    v-model.trim="form.billingForm.billingHome_address"
                    :class="{ 'is-invalid': $v.form.billingForm.billingHome_address.$error }"
                    type="text"
                    class="form-control"
                    placeholder="Enter Address"
                    @input="$v.form.billingForm.billingHome_address.$touch()"
                  >
                  <div
                    v-if="$v.form.billingForm.billingHome_address.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.billingForm.billingHome_address.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.billingForm.billingHome_address.minLength"
                      class="help-block help-block-error"
                    >Address must have at least {{ $v.form.billingForm.billingHome_address.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.billingForm.billingHome_address.maxLength"
                      class="help-block help-block-error"
                    >Address should not exceed {{ $v.form.billingForm.billingHome_address.$params.maxLength.max }} letters.</span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputUserName"> City*</label>
                  <!-- <input
                    id="inputUserName"
                    type="text"
                    class="form-control"
                    placeholder="Enter City"
                    v-model.trim="form.billingForm.billingCity"
                  > -->
                  <select
                    id="inputRole"
                    v-model="form.billingForm.billingCity"
                    class="form-control"
                    placeholder="Select Category"
                    required
                  >
                    <option value>Select City</option>
                    <option
                      v-for="(city, idX) in cities"
                      :key="idX"
                      :value="city.city_name"
                    >{{ city.city_name }}</option>
                  </select>
                  <!-- <div
                    v-if="$v.form.shippingForm.shippingCity.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingForm.shippingCity.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                  </div> -->
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleInputphone"> Province*</label>
                  <!-- <input
                    id="exampleInputphone"
                    type="text"
                    class="form-control"
                    aria-describedby="phoneHelp"
                    placeholder="Enter Province"
                    v-model.trim="form.billingForm.billingProvince"
                  > -->
                  <select
                    id="inputRole"
                    v-model="form.billingForm.billingProvince"
                    :class="{ 'is-invalid': $v.form.billingForm.billingProvince.$error }"
                    class="form-control"
                    placeholder="Select Category"
                    @input="$v.form.billingForm.billingProvince.$touch()"
                  >
                    <option value>Select Province</option>
                    <option
                      v-for="(province, idX) in provinces"
                      :key="idX"
                      :value="province.province_name"
                    >{{ province.province_name }}</option>
                  </select>
                  <div
                    v-if="$v.form.billingForm.billingProvince.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.billingForm.billingProvince.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputphone">Phone* <small>Format: 923001234567</small></label>
                  <input
                    id="exampleInputphone"
                    :class="{ 'is-invalid': $v.form.billingForm.billingPhone.$error }"
                    v-model.trim="form.billingForm.billingPhone"
                    type="tel"
                    class="form-control"
                    pattern="[0-9]{2}[0-9]{3}[0-9]{7}"
                    aria-describedby="phoneHelp"
                    placeholder="Enter Phone"
                    @input="$v.form.billingForm.billingPhone.$touch()"
                  >
                  <div
                    v-if="$v.form.billingForm.billingPhone.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.billingForm.billingPhone.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.billingForm.billingPhone.minLength"
                      class="help-block help-block-error"
                    >Phone must have at least {{ $v.form.billingForm.billingPhone.$params.minLength.min }} numbers.</span>
                    <span
                      v-if="!$v.form.billingForm.billingPhone.maxLength"
                      class="help-block help-block-error"
                    >Phone should not exceed {{ $v.form.billingForm.billingPhone.$params.maxLength.max }} numbers.</span>
                  </div>
                </div>

              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleInputphone"> First Name*</label>
                  <input
                    id="exampleInputphone"
                    v-model.trim="form.billingForm.billingFirstName"
                    :class="{ 'is-invalid': $v.form.billingForm.billingFirstName.$error }"
                    type="text"
                    class="form-control"
                    minlength="4"
                    maxlength="15"
                    aria-describedby="phoneHelp"
                    placeholder="Enter First Name"
                    @input="$v.form.billingForm.billingFirstName.$touch()"
                  >
                  <div
                    v-if="$v.form.billingForm.billingFirstName.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.billingForm.billingFirstName.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.billingForm.billingFirstName.minLength"
                      class="help-block help-block-error"
                    >First Name must have at least {{ $v.form.billingForm.billingFirstName.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.billingForm.billingFirstName.maxLength"
                      class="help-block help-block-error"
                    >First Name should not exceed {{ $v.form.billingForm.billingFirstName.$params.maxLength.max }} letters.</span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputphone"> Last Name*</label>
                  <input
                    id="exampleInputphone"
                    v-model.trim="form.billingForm.billingLastName"
                    :class="{ 'is-invalid': $v.form.billingForm.billingLastName.$error }"
                    type="text"
                    minlength="4"
                    maxlength="15"
                    class="form-control"
                    aria-describedby="phoneHelp"
                    placeholder="Enter Last Name"
                    @input="$v.form.billingForm.billingLastName.$touch()"
                  >
                  <div
                    v-if="$v.form.billingForm.billingLastName.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.billingForm.billingLastName.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.billingForm.billingLastName.minLength"
                      class="help-block help-block-error"
                    >First Name must have at least {{ $v.form.billingForm.billingLastName.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.billingForm.billingLastName.maxLength"
                      class="help-block help-block-error"
                    >First Name should not exceed {{ $v.form.billingForm.billingLastName.$params.maxLength.max }} letters.</span>
                  </div>
                </div>

              </div>

              <button
                :disabled="$v.form.billingForm.$invalid"
                type="submit"
                class="btn btn-primary"
              >{{ submitBtn }}</button>
              <b-button
                type="button"
                @click.prevent="cancel"
              >Cancel</b-button>
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
import Ls from '../../../services/ls'

export default {

  components: {
    tabs: Tabs,
    tab: Tab
  },
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      submitBtn: 'Update',
      provinces: [
        { province_name: 'Punjab' }
      ],
      cities: [
        { city_name: 'Islamabad' },
        { city_name: 'Rawalpindi' }
      ],
      form: {
        userForm: {
          full_name: '',
          email: '',
          dob: '',
          phone: '',
          Id: ''
        },
        billingForm: {
          billingCity: '',
          billingHome_address: '',
          billingProvince: '',
          billingPhone: '',
          billingFirstName: '',
          billingLastName: ''
        },
        shippingForm: {
          shippingPhone: '',
          shippingFirstName: '',
          shippingLastName: '',
          shippingCity: '',
          shippingHome_address: '',
          shippingProvince: ''
        }
      }
    }
  },
  validations: {
    form: {
      userForm: {
        full_name: {
          required,
          minLength: minLength(4),
          maxLength: maxLength(15)
        }
      },
      billingForm: {
        billingCity: {
          required,
          minLength: minLength(4)
        },
        billingHome_address: {
          required,
          minLength: minLength(4),
          maxLength: maxLength(30)

        },
        billingProvince: {
          required,
          minLength: minLength(4)
        },
        billingPhone: {
          required,
          minLength: minLength(4),
          maxLength: maxLength(12)

        },
        billingFirstName: {
          required,
          minLength: minLength(4),
          maxLength: maxLength(15)

        },
        billingLastName: {
          required,
          minLength: minLength(4),
          maxLength: maxLength(15)

        }

      },
      shippingForm: {
        shippingPhone: {
          required
          // minLength: minLength(4),
          // maxLength: maxLength(11)

        },
        shippingFirstName: {
          required,
          minLength: minLength(4),
          maxLength: maxLength(15)

        },
        shippingLastName: {
          required,
          minLength: minLength(4),
          maxLength: maxLength(15)

        },
        shippingCity: {
          required,
          minLength: minLength(4)
        },
        shippingHome_address: {
          required,
          minLength: minLength(4),
          maxLength: maxLength(30)

        },
        shippingProvince: {
          required,
          minLength: minLength(4)
        }

      }

    }
  },
  mounted () {
    this.getUser()
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },
  methods: {
    async submit () {
      this.$v.form.$touch()
      // if (this.$v.form.$error) return;
      try {
        this.form.Id = this.$route.params.userId
        let response = await window.axios.post('/api/admin/users/update', {
          data: this.form
        })
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        // this.$router.push("/users");
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response.data.ResponseHeader.ResponseMessage,
            'Error'
          )
        }
      }
    },
    async getUser () {
      try {
        let userId = this.$route.params.userId
        const response = await axios.get(`/api/admin/users/edit/${userId}`)
        this.form.userForm.full_name = response.data[0].full_name
        this.form.userForm.phone = response.data[0].phone
        this.form.userForm.email = response.data[0].email
        this.form.userForm.dob = response.data[0].dob
        if (response.data[0].billing != null) {
          this.form.billingForm.billingCity = response.data[0].billing.city
          this.form.billingForm.billingHome_address = response.data[0].billing.home_address
          this.form.billingForm.billingProvince = response.data[0].billing.province
          this.form.billingForm.billingPhone = response.data[0].billing.phone
          this.form.billingForm.billingFirstName = response.data[0].billing.first_name
          this.form.billingForm.billingLastName = response.data[0].billing.last_name
        }
        if (response.data[0].shipping != null) {
          this.form.shippingForm.shippingCity = response.data[0].shipping.city
          this.form.shippingForm.shippingHome_address = response.data[0].shipping.home_address
          this.form.shippingForm.shippingProvince = response.data[0].shipping.province
          this.form.shippingForm.shippingPhone = response.data[0].shipping.phone
          this.form.shippingForm.shippingFirstName = response.data[0].shipping.first_name
          this.form.shippingForm.shippingLastName = response.data[0].shipping.last_name
        }
      } catch (error) {
        if (error) {
          // window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async cancel () {
      this.$router.push('/users')
    }
  }
}
</script>
