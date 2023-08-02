<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Add New City</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard"><a>Home</a></router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/cities"><a>Cities</a></router-link>
        </li>
        <li class="breadcrumb-item active">New City</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <!-- <div class="card-header">
            <h6>Enter Name of City</h6>
          </div> -->
          <div class="card-body">
            <form
              ref="city"
              autocomplete="off"
              @submit.prevent="submit"
            >
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleInputphone">Select Province</label>
                  <select
                    id="inputRole"
                    v-model="form.province_name"
                    :class="{ 'is-invalid': $v.form.province_name.$error }"
                    class="form-control"
                    placeholder="Select Category"
                    @input="$v.form.province_name.$touch()"
                  >
                    <option value>Select Province</option>
                    <option
                      v-for="(province, idX) in provinces"
                      :key="idX"
                      :value="province.province_name"
                    >{{ province.province_name }}</option>
                  </select>
                  <div
                    v-if="$v.form.province_name.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.province_name.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputCityName">City Name</label>
                  <input
                    id="inputCityName"
                    v-model.trim="form.name"
                    :class="{ 'is-invalid': $v.form.province_name.$error }"
                    type="text"
                    class="form-control"
                    placeholder="City Name"
                  >
                  <div
                    v-if="$v.form.name.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.name.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.name.minLength"
                      class="help-block help-block-error"
                    >Address must have at least {{ $v.form.name.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.name.maxLength"
                      class="help-block help-block-error"
                    >Address should not exceed {{ $v.form.name.$params.maxLength.max }} letters.</span>
                  </div>
                </div>
                <div class="form-group col-6 hide toggleMed">
                  <label>Show in the app???</label>
                  <toggle-button
                    :value="form.status"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    v-model.trim="form.status"
                    color="#1a1a44"
                    class="toggleStyle"
                  />
                </div>
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
import { required, sameAs, maxLength, minLength, between } from 'vuelidate/lib/validators'
import Ls from '../../../services/ls'

export default {
  data () {
    return {
      provinces: [
        { province_name: 'Punjab' },
        { province_name: 'Sindh' },
        { province_name: 'KPK' },
        { province_name: 'Balochistan' }
      ],
      form: {
        id: '',
        name: '',
        province_name: '',
        status: false,
        submitBtn: 'Submit'
      }
    }
  },
  validations: {
    form: {
      name: {
        required
      },
      province_name: {
        required,
        minLength: minLength(4),
        maxLength: maxLength(15)
      }

    }
  },
  methods: {
    async submit () {
      this.$v.form.$touch()
      if (this.$v.form.$error) return
      try {
        let response = await window.axios.post('/api/admin/cities/add', {
          data: this.form
        })
        window.toastr['success']('New City Added', 'Success')
        this.$router.push('/cities')
      } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
    },
    async cancel () {
      this.$router.push('/cities')
    }
  }
}
</script>
