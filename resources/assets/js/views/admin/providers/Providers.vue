<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Service Providers</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Providers</li>
      </ol>
      <div class="page-actions">
        <router-link v-if="Write == 1" to="/Providers/add">
          <a href="/Providers/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus"/> Register New Provider
          </a>
        </router-link>
      </div>
    </div>
    <div class="row">
      <!-- <div class="ser-pro"> -->
      <div class="card col-sm-12 col-md-12 col-lg-12">

        <div v-if="Read == 1" class="card-body">
          <table-component
            ref="allUsers"
            :data="getProviders"
            sort-by="id"
            sort-order="desc"
            table-class="table"
          >
            <table-column
              :sortable="false"
              :filterable="false"
              label="Picture"
            >
              <template slot-scope="row">
                <div>
                  <img :src="imagelink + row.avatar" height="27" @error="onImageLoadFailure($event)" >
                </div>
              </template>
            </table-column>

            <table-column show="full_name" label="Name"/>
            <!-- <table-column show="gender" label="Gender"/>
              <table-column show="email" label="email"/> -->
            <table-column show="phone" label="Phone"/>
            <table-column label="Provides Service">
              <template slot-scope="row">
                <div>
                  {{ row.services[0].service_name }}
                </div>
              </template>
            </table-column>

            <!-- <table-column label="Available_From">
                <template slot-scope="row">
                  <div>
                      {{row.services_details.available_from | formatter}}
                  </div>
                </template>
              </table-column>

              <table-column label="Available_till">
                <template slot-scope="row">
                  <div>
                      {{row.services_details.available_to | formatter}}}
                  </div>
                </template>
              </table-column> -->

            <table-column label="In City">
              <template slot-scope="row">
                <div v-if="row.services_details != null">
                  {{ row.services_details.all_cities.city_name }}
                </div>
                <div v-else>
                  {{ "N/A" }}
                </div>
              </template>
            </table-column>

            <!-- <table-column label="Price/PerHour">
                <template slot-scope="row">
                  <div>
                      {{row.services_details.price_per_hour}}
                  </div>
                </template>
              </table-column> -->

            <!-- <table-column
                show="created_at"
                label="Registered On"
                data-type="date:YYYY-MM-DD"
                :formatter="formatter"
              /> -->
            <table-column label="Completed Jobs">
              <template slot-scope="row">
                <div class="count">
                  <b> {{ row.providers_count }}</b>
                </div>
              </template>
            </table-column>

            <table-column
              v-if="Write == 1 || Delete == 1"
              :sortable="false"
              :filterable="false"
              label="Actions"
            >
              <template slot-scope="row">
                <div class="table__actions">
                  <router-link v-if="Write == 1" :to="{ name: 'editProviders', params: { ProvidersId: row.id }}"><a v-b-popover.hover ="'EDIT'"
                                                                                                                    class="btn btn-default btn-sm">
                    <i class="icon-fa icon-fa-pencil"/>
                  </a>
                  </router-link>
                  <div>
                    <!-- <div v-if="row.is_blocked == 0">
                      <a
                       v-b-popover.hover ="'BLOCK'"
                        class="btn btn-default btn-sm"
                        data-delete
                        data-confirmation="notie"
                        @click="blockUser(row.id)"
                      >
                        <i class="icon-fa icon-fa-lock"/>
                      </a>
                      </div>
                      <div v-else>
                       <a
                         v-b-popover.hover ="'UN-BLOCK'"
                          class="btn btn-default btn-sm"
                          data-delete
                          data-confirmation="notie"
                          @click="unblockUser(row.id)"
                        >
                          <i class="icon-fa icon-fa-unlock"/>
                        </a>
                      </div> -->
                  </div>
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

                </div>
              </template>
            </table-column>
          </table-component>
        </div>
        <div v-else class="alert alert-info" role="alert">
          Sorry! you dont have permission
        </div>
      </div>
      <!-- </div> -->
    </div>
  </div>
</template>

<script type="text/babel">
import Ls from '../../../services/ls'
import { TableComponent, TableColumn } from 'vue-table-component'
import {imageLink} from '../../../helpers/constants'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import moment from 'moment'
// import { SweetModal, SweetModalTab } from "sweet-modal-vue";

export default {
  components: {
    TableComponent,
    TableColumn
    // SweetModal,
    // SweetModalTab,
  },
  data () {
    return {
      users: [],
      imagelink: imageLink,
      auth_user: [],
      Read: '',
      Write: '',
      Delete: '',
      form: {
        UID: '',
        selectedstatus: '',
        packages: [],
        submitBtn: 'Update'
      }
    }
  },
  mounted () {
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },

  methods: {
    async submit () {
      try {
        // alert(this.form.UID);
        let response = await window.axios.post('/api/admin/users/updatePkg', {
          data: this.form
        })
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.$router.push('/users')
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response.data.ResponseHeader.ResponseMessage,
            'Error'
          )
        }
      }
    },
    formatter (value, rowProperties) {
      return moment(value).format('Do MMM YYYY')
    },
    // async getAuthUser() {
    //       try {
    //       let response = await window.axios.get('/api/admin/employees/authuser');
    //       this.auth_user=response.data;
    //       // console.log(this.auth_user.);
    //       } catch (error) {
    //       if (error) {
    //         window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
    //       }
    //     }
    //     },
    async getProviders ({ page, filter, sort }) {
      try {
        const response = await axios.get(`/api/admin/providers/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`)
        // console.log(response.data.data)
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
    onImageLoadFailure (event) {
      event.target.src = this.imagelink + 'users/no-photo.jpg'
    },

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
        let response = await window.axios.delete('/api/admin/providers/' + id)
        this.users = response.data
        window.toastr['success']('User Deleted', 'Success')
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
