<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit Employees</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/employees"><a>Employees</a></router-link></li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">

          <div class="card-body">
            <form autocomplete="off" @submit.prevent="submit">

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleInputphone">Phone Number</label>
                  <input
                    id="exampleInputphone"
                    v-model.trim="form.phone"
                    :disabled="true"
                    type="number"
                    class="form-control"
                    aria-describedby="phoneHelp"
                    placeholder="Enter Phone"
                  >

                  <!-- <div v-if="$v.form.phone.$error">
                    <span v-if="!$v.form.phone.required" class="help-block help-block-error">
                      <p class="text-danger">Phone is required.</p>
                    </span>
                    <span v-if="!$v.form.phone.isUnique" class="help-block help-block-error">
                    <p class="text-danger"> This phone is already registered.</p></span>
                    <span v-if="!$v.form.phone.minLength" class="help-block help-block-error text-warning">
                      <p class="text-danger">Phone must have at least {{ $v.form.phone.$params.minLength.min }} letters.</p>
                    </span>
                  </div> -->
                </div>
                <div class="form-group col-md-6">
                  <label for="inputGender">Gender*</label>
                  <!-- <input
                    id="inputGender"
                    type="text"
                    class="form-control"
                    placeholder="Gender"
                    v-model.trim="form.gender"
                     @input="$v.form.gender.$touch()"
                  > -->
                  <select v-model="form.gender"
                          :class="{ 'is-invalid': $v.form.gender.$error }"
                          class="form-control"
                          required
                          @input="$v.form.gender.$touch()">
                    <option
                      disabled
                      value=""
                    >Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                  </select>
                  <div
                    v-if="$v.form.gender.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.gender.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                  </div>
                </div>

              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputUserName">User Name*</label>
                  <input
                    id="inputUserName"
                    :class="{ 'is-invalid': $v.form.full_name.$error }"
                    v-model.trim="form.full_name"
                    type="text"
                    minlength="4"
                    maxlength="20"
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
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail">Email*</label>
                  <input
                    id="inputEmail"
                    :class="{ 'is-invalid': $v.form.email.$error }"
                    v-model.trim="form.email"
                    type="email"
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                    class="form-control"
                    placeholder="Email"
                    @input="$v.form.email.$touch()"
                  >
                  <div
                    v-if="$v.form.email.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.email.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <!-- <span
                      v-if="!$v.form.full_name.minLength"
                      class="help-block help-block-error"
                    >User Name must have at least {{ $v.form.full_name.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.full_name.maxLength"
                      class="help-block help-block-error"
                    >User Name should not exceed {{ $v.form.full_name.$params.maxLength.max }} letters.</span> -->

                  </div>
                </div>

              </div>

              <div class="form-group">
                <label for="exampleInputPassword">Password*</label>
                <input
                  id="exampleInputPassword1"
                  :class="{ 'is-invalid': $v.form.password.$error }"
                  v-model.trim="form.password"
                  type="password"
                  class="form-control"
                  placeholder="Password"
                  @input="$v.form.password.$touch()"
                >
                <div v-if="$v.form.password.$error">
                  <span v-if="!$v.form.password.required" class="help-block help-block-error">
                    <p class="text-danger"> Password is required.</p>
                  </span>
                  <span v-if="!$v.form.password.minLength" class="help-block help-block-error">
                    <p class="text-danger">Password must have at least {{ $v.form.password.$params.minLength.min }} letters.</p>
                  </span>
                </div>
              </div>

              <div class="form-group">
                <label for="exampleInputrepeatPassword">Confirm Password*</label>
                <input
                  id="exampleInputrepeatPassword"
                  :class="{ 'is-invalid': $v.form.repeatPassword.$error }"
                  v-model.trim="form.repeatPassword"
                  type="password"
                  class="form-control"
                  placeholder="Confirm Password"
                  @input="$v.form.repeatPassword.$touch()"
                >
                <div v-if="$v.form.repeatPassword.$error">
                  <span v-if="!$v.form.repeatPassword.sameAsPassword" class="help-block help-block-error">
                    <p class="text-danger"> Passwords must be identical.</p>
                  </span>
                </div>
              </div>

               <div class="form-group col-4 hide margin-top">
                  <label>Can Read </label>
                  <toggle-button :value="form.ReadPermissions"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    v-model.trim="form.ReadPermissions"
                     class="toggleStyle"
                  />

              </div>

                <div class="form-group col-4 hide margin-top">
                  <label>Can Write</label>
                  <toggle-button :value="form.WritePermissions"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    v-model.trim="form.WritePermissions"
                     class="toggleStyle"
                  />

              </div>

                <div class="form-group col-4 hide margin-top">
                  <label>Can Delete</label>
                  <toggle-button :value="form.DeletePermissions"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    class="toggleStyle"
                    v-model.trim="form.DeletePermissions"
                  />

              </div>

              <button :disabled="$v.form.$invalid" type="submit" class="btn btn-primary" >{{ form.submitBtn }}</button>
              <b-button type="button" @click.prevent="cancel" >Cancel</b-button>
            </form>
          </div>
        </div>
      </div>

    </div>

  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, maxLength, between } from 'vuelidate/lib/validators'
import Ls from '../../../services/ls'

export default {
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      form: {
        ID: '',
        phone: '',
        email: '',
        full_name: '',
        gender: '',
        password: '',
        submitBtn: 'Submit',
        repeatPassword: false,
        ReadPermissions: false,
        WritePermissions: false,
        DeletePermissions: false
      }
    }
  },
  validations: {
    form: {
      gender: {
        required
      },
      full_name: {
        required,
        minLength: minLength(4),
        maxLength: maxLength(15)
      },
      email: {
        required
      },
      password: {
        required,
        minLength: minLength(6)
      },
      repeatPassword: {
        required,
        minLength: minLength(6),
        sameAsPassword: sameAs('password')
      },
      phone: {
        required,
        minLength: minLength(11),
      }
    }
  },
  mounted () {
    this.getEmployee()
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },
  methods: {
    async submit () {
      if(this.form.WritePermissions == true || this.form.DeletePermissions == true){
        this.form.ReadPermissions = true
      }
      this.$v.form.$touch()
      if (this.$v.form.$error) return
      try {
        let response = await window.axios.post('/api/admin/users/EmployeeUpdate', { data: this.form })
        window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
        this.$router.push('/employees')
      } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
    },
    async cancel () {
      this.$router.push('/employees')
    },
    async getEmployee () {
      try {
        let userId = this.$route.params.employeesId
        const response = await axios.get(`/api/admin/users/employee/edit/${userId}`)
        this.form.full_name = response.data.user.full_name
        this.form.ID = response.data.user.id
        this.form.email = response.data.user.email
        this.form.phone = response.data.user.phone
        this.form.gender = response.data.user.gender
        this.form.ReadPermissions = Boolean(response.data.permission.Read)
        this.form.WritePermissions = Boolean(response.data.permission.Write)
        this.form.DeletePermissions = Boolean(response.data.permission.Delete)
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    changeValue (index) {
      this.form.permissions[index].enable = true
    }
  }
}
</script>
