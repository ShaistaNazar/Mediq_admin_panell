<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Home Medics Services</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Services</li>
      </ol>
    </div>
    <div class="row">

      <div v-if="Read == 1" class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <form ref="Add_hm" autocomplete="off" @submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputUserName">Add New Service*</label>
                  <input
                    id="inputUserName"
                    v-model.trim="form.service_name"
                    type="text"
                    class="form-control"
                    placeholder="Service Name"
                    required
                  >
                  <div v-if="$v.form.service_name.$error">
                    <span v-if="!$v.form.service_name.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.service_name.minLength" class="help-block help-block-error">
                      Service Name Name must have at least {{ $v.form.service_name.$params.minLength.min }} letters.
                    </span>
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <label >Add to In-Demand</label>
                  <toggle-button :value="form.in_demand"
                                 :sync="true"
                                 :labels="{checked: 'Yes', unchecked: 'No'}"
                                 v-model.trim="form.in_demand"
                                 color="#1a1a44"
                                 class="toggleStyle"
                  />
                </div>
              </div>
              <h3>Select the cities for service</h3>
              <div class="service_cities">
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
      <div v-else class="alert alert-info" role="alert">
        Sorry! you dont have permission
      </div>

      <div class="col-sm-12 hide">
        <div class="card">

          <div v-if="Read == 1" class="card-body">
            <table-component
              ref="allUsers"
              :data="getServices"
              sort-by="id"
              sort-order="desc"
              table-class="table"
            >

              <table-column show="service_name" label="service name"/>

              <table-column
                :formatter="formatter"
                show="created_at"
                label="Registered On"
                data-type="date:YYYY-MM-DD"
              />

              <table-column
                v-if="Write == 1 || Delete == 1"
                :sortable="false"
                :filterable="false"
                label="Actions"
              >
                <template slot-scope="row">
                  <div class="table__actions">
                    <router-link v-if="Write == 1" :to="{ name: 'editServices', params: { ServicesId: row.id }}"><a v-b-popover.hover ="'EDIT'"
                                                                                                                    class="btn btn-default btn-sm">
                      <i class="icon-fa icon-fa-pencil"/>
                    </a>
                    </router-link>
                    <div/>
                    <div v-if="Delete == 1">
                      <a
                        v-b-popover.hover ="'DELETE'"
                        class="btn btn-default btn-sm"
                        data-delete
                        data-confirmation="notie"
                        @click="destroyUser(row.id)"
                      >
                        <i class="icon-fa icon-fa-trash"/>
                      </a>
                    </div>
                    <div v-if="row.in_demand == 1" class="btn btn-success btn-sm" style="color:white !important">Already in_demand</div>
                    <div v-else class="float-right">
                      <a
                        v-b-popover.hover="'Add to In-demand'"
                        class="btn btn-warning btn-sm"
                        style="color:white !important"
                        data-delete
                        data-confirmation="notie"
                        @click="AddInDemand(row.id , type = 'hm_service')"
                      >Add to In-Demand
                      </a>
                    </div>
                  </div>
                </template>
              </table-column>
            </table-component>
          </div>
          <div v-else class="alert alert-info" role="alert">
            Sorry! you dont have permission
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import Ls from '../../../services/ls'
import { TableComponent, TableColumn } from 'vue-table-component'
import { imageLink } from '../../../helpers/constants'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import moment from 'moment'
import { required, sameAs, minLength, between } from 'vuelidate/lib/validators'
// import { SweetModal, SweetModalTab } from "sweet-modal-vue";
import PrettyCheckbox from 'pretty-checkbox-vue'
Vue.use(PrettyCheckbox)

export default {
  components: {
    TableComponent,
    TableColumn
    // SweetModal,
    // SweetModalTab,
  },
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      service_name: '',
      cities: [],
      form: {
        UID: '',
        selectedstatus: '',
        service_name: '',
        in_demand: false,
        cities: [],
        submitBtn: 'Add'
      }
    }
  },
  validations: {
    form: {
      service_name: {
        required,
        minLength: minLength(2)
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
    async submit () {
      try {
        // alert(this.form.UID);
        let response = await window.axios.post('/api/admin/Services/add', {
          data: this.form
        })
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.$refs.allUsers.refresh()
        this.resetForm()
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response.data.ResponseHeader.ResponseMessage,
            'Error'
          )
        }
      }
    },
    async resetForm () {
      this.form.service_name = ''
    },
    formatter (value, rowProperties) {
      return moment(value).format('Do MMM YYYY')
    },

    async getServices ({ page, filter, sort }) {
      try {
        const response = await axios.get(`/api/admin/Services/get?page=${page}&filter=${filter}`)

        return {
          data: response.data.data,
          pagination: {
            totalPages: response.data.last_page,
            currentPage: page,
            count: response.data.count
          }
        }
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
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
    },
    onImageLoadFailure (event) {
      event.target.src = this.imageLink + 'users/no-photo.jpg'
    },

    // Block User

    destroyUser (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {

        },
        submitCallback: function () {
          self.destroyUserData(id)
        }
      })
    },

    async destroyUserData (id) {
      try {
        let response = await window.axios.delete('/api/admin/Services/' + id)
        this.users = response.data
        window.toastr['success']('H-M Service Deleted', 'Success')
        this.$refs.allUsers.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    AddInDemand (id, type) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {},
        submitCallback: function () {
          self.AddInDemandData(id, type)
        }
      })
    },
    async AddInDemandData (id, type) {
      try {
        let response = await window.axios.post('/api/admin/orders/inDemandAdd', {id, type})
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.$refs.allUsers.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    }
    //  openprmodel(id) {

    //    this.form.UID = id;
    //       this.$refs.dark_html_modal_statuscomm.open();
    //     },

  }
}
</script>
