<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Add New Employees</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard"><a>Home</a></router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/employees"><a>Employees</a></router-link>
        </li>
        <li class="breadcrumb-item active">New</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">

          <div class="card-body">
            <form v-on:submit.prevent="submit" autocomplete=off>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="abcphone">Phone Number*</label>
                  <input
                    id="abcphones"
                    :class="{ 'is-invalid': $v.form.phone.$error }"
                    v-model.trim="form.phone"
                    type="number"
                    class="form-control"
                    placeholder="Enter Phone"
                    @input="$v.form.phone.$touch()"
                  >

                  <div v-if="$v.form.phone.$error">
                    <span
                      v-if="!$v.form.phone.required"
                      class="help-block help-block-error"
                    >
                      <p class="text-danger">Phone is required.</p>
                    </span>
                    <span
                      v-if="!$v.form.phone.isUnique"
                      class="help-block help-block-error"
                    >
                      <p class="text-danger"> This phone is already registered.</p>
                    </span>
                    <span
                      v-if="!$v.form.phone.minLength"
                      class="help-block help-block-error text-warning"
                    >
                      <p class="text-danger">Phone must have at least {{ $v.form.phone.$params.minLength.min }} letters.</p>
                    </span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputGender">Gender</label>
                  <!-- <input
                    id="inputGender"
                    type="text"
                    class="form-control"
                    placeholder="Gender"
                    v-model.trim="form.gender"
                  > -->
                  <select v-model="form.gender"
                          class="form-control">
                    <option
                      disabled
                      value=""
                    >Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                  </select>
                </div>

              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="abcname">User Name</label>
                  <input
                    autocomplete=off
                    id="abcname"
                    v-model.trim="form.full_name"
                    type="text"
                    class="form-control"
                    placeholder="User Name"
                  >
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail">Email</label>
                  <input
                    autocomplete=off
                    id="inputEmail"
                    v-model.trim="form.email"
                    type="email"
                    class="form-control"
                    placeholder="Email"
                    @input="$v.form.email.$touch()"
                  >
                </div>

              </div>

              <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input
                  autocomplete=off
                  id="exampleInputPassword1"
                  :class="{ 'is-invalid': $v.form.password.$error }"
                  v-model.trim="form.password"
                  type="password"
                  class="form-control"
                  placeholder="Password"
                  @input="$v.form.password.$touch()"
                >
                <div v-if="$v.form.password.$error">
                  <span
                    v-if="!$v.form.password.required"
                    class="help-block help-block-error"
                  >
                    <p class="text-danger"> Password is required.</p>
                  </span>
                  <span
                    v-if="!$v.form.password.minLength"
                    class="help-block help-block-error"
                  >
                    <p class="text-danger">Password must have at least {{ $v.form.password.$params.minLength.min }} letters.</p>
                  </span>
                </div>
              </div>

              <div class="form-group">
                <label for="exampleInputrepeatPassword">Confirm Password</label>
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
                  <span
                    v-if="!$v.form.repeatPassword.sameAsPassword"
                    class="help-block help-block-error"
                  >
                    <p class="text-danger"> Passwords must be identical.</p>
                  </span>
                </div>
              </div>

              <div class="form-group col-4 hide margin-top">
                <label>Can Read </label>
                <toggle-button
                  :value="form.ReadPermissions"
                  :sync="true"
                  :labels="{checked: 'Yes', unchecked: 'No'}"
                  v-model.trim="form.ReadPermissions"
                  color="#1a1a44"
                  class="toggleStyle"
                />

              </div>

              <div class="form-group col-4 hide margin-top">
                <label>Can Write</label>
                <toggle-button
                  :value="form.WritePermissions"
                  :sync="true"
                  :labels="{checked: 'Yes', unchecked: 'No'}"
                  v-model.trim="form.WritePermissions"
                  color="#1a1a44"
                  class="toggleStyle"
                />

              </div>

              <div class="form-group col-4 hide margin-top">
                <label>Can Delete</label>
                <toggle-button
                  :value="form.DeletePermissions"
                  :sync="true"
                  :labels="{checked: 'Yes', unchecked: 'No'}"
                  v-model.trim="form.DeletePermissions"
                  color="#1a1a44"
                  class="toggleStyle"
                />

              </div>

              <button
                :disabled="$v.form.$invalid"
                type="submit"
                class="btn btn-primary"
              >{{ form.submitBtn }}</button>
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
import { required, sameAs, minLength, between } from 'vuelidate/lib/validators'
import Ls from '../../../services/ls'

export default {
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      form: {
        phone: "",
        email: "",
        full_name: "",
        gender: "",
        password: "",
        submitBtn: "Submit",
        repeatPassword: "",
        ReadPermissions: false,
        WritePermissions: false,
        DeletePermissions: false
      }
    }
  },
  validations: {
    form: {
      full_name: {
        required,
        minLength: minLength(4)
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
        async isUnique (value) {
          if (value === '') return true
          let response = await window.axios.post('/api/phone-exist', {
            phone: value
          })
          return response.data
        }
      }
    }
  },
  mounted () {
    this.getRoles()
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },
  methods: {
    async submit () {
      if(this.form.WritePermissions == true || this.form.DeletePermissions == true){
        this.form.ReadPermissions = true
      }
      this.$v.form.$touch();
      
      if (this.$v.form.$error) return;
      try {
        let response = await window.axios.post('/api/admin/users/EmployeeAdd', { data: this.form })
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
    async getRoles () {
      try {
        let response = await window.axios.get('/api/admin/employees/userrole')
        this.form.roles = response.data
      } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
    },
    changeValue (index) {
      this.form.permissions[index].enable = true
    }
  }
}
</script>
