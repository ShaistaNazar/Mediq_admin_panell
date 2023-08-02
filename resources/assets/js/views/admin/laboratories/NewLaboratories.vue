<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Add Laboratory</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/Laboratories">
            <a>Laboratories</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <form autocomplete="off" @submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputUserName">Laboratory Names*</label>
                  <input
                    id="inputUserName"
                    v-model.trim="form.lab_name"
                    type="text"
                    class="form-control"
                    required
                    placeholder="Laboratory Names"
                  >
                </div>
                <!-- <div class="form-group col-md-6">
                  <label for="inputEmail">Select City</label>
                  <select required id="inputRole" class="form-control" placeholder="Select City" v-model.trim="form.selectedCity">
                     <option
                        v-for="city in form.cities.data"
                        :key="city"
                        > {{city.city_name}}
                     </option>
                  </select>
                </div> -->
              </div>
              <button
                :disabled="form.$invalid"
                type="submit"
                class="btn btn-primary"
              >{{ form.submitBtn }}</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-6 hide">
        <div class="card">
          <div class="card-body formDesign">
            <div class="form-row border-bottom">
              <div class="form-group col-6 hide">Category Name</div>
              <div class="form-group col-6 hide text-center">Enable/Disable</div>
            </div>

            <div v-for="(list, index) in form.pharmaCat" :key="(list, index)" class="form-row">

              <div class="form-group col-6 hide" style="margin: 10px 0px;">
                {{ list.category_name }}
              </div>

            <div class="form-row" v-for="(list, index) in form.pharmaCat" :key="(list, index)">
                
                <div class="form-group col-6 hide" style="margin: 10px 0px;">
                  {{ list.category_name }}
                </div>
               
                <div class="form-group col-6 hide margin-top text-center">
                  
                  <toggle-button :value="list.category"
                    @change="changeValue(index)"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from 'vuelidate/lib/validators'
import GoogleMap from '../../../../js/components/GoogleMap'
import Ls from '../../../services/ls'

export default {
  name: 'App',
  components: {GoogleMap},
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      form: {
        pharmaCat: '',
        pharmacy_name: '',
        cities: '',
        selectedCity: '',
        submitBtn: 'Submit'
      }
    }
  },

  mounted () {
    this.getCities()
    this.getCategory()
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },
  methods: {
    changeValue (index) {
      this.form.pharmaCat[index].enable = true
    },
    async submit () {
      try {
        let response = await window.axios.post(
          '/api/admin/Laboratories/add',
          { data: this.form }
        )
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.$router.push('/Laboratories')
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response.data.ResponseHeader.ResponseMessage,
            'Error'
          )
        }
      }
    },
    async getCategory () {
      try {
        const response = await axios.get(`/api/admin/TestsCategory/get`)
        this.form.pharmaCat = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async cancel () {
      this.$router.push('/employees')
    },
    async getCities () {
      try {
        const response = await axios.get(
          `/api/admin/cities/get`
        )
        this.form.cities = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    }
    // changeValue(index) {
    //   this.form.permissions[index].enable = true;
    // }
  }
}
</script>
