<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Employees</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Employees</li>
      </ol>
      <div class="page-actions">
        <router-link v-if="Write == 1" to="/Employees/add">
          <a href="/Employees/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus"/> New Employee
          </a>
        </router-link>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">

          <div v-if="Read == 1" class="card-body">
            <table-component
              ref="allUsers"
              :data="getEmployees"
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
                  <div class="profile-image">
                    <img :src="imagelink + row.avatar" @error="onImageLoadFailure($event)" >
                  </div>
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="User Name">
                <template slot-scope="row">
                  <div>
                    <router-link
                      v-b-popover.hover="'View Profile'"
                      :to="{ name: 'viewprofile', params: { userId: row.id }}"
                      class="user-color"
                    >{{ row.full_name }}</router-link>
                  </div>
                </template>
              </table-column>

              <table-column show="gender" label="Gender"/>
              <!-- <table-column show="email" label="email"/> -->
              <table-column show="phone" label="Phone"/>
              <table-column label="Role">
                <template slot-scope="row">
                  <div v-if="row.role_id == 2">Employee</div>
                  <div v-else>Undefined</div>
                </template>
              </table-column>

              <table-column
                v-if="Write == 1 || Delete == 1"
                :formatter="formatter"
                show="created_at"
                label="Registered On"
                data-type="date:YYYY-MM-DD"
              />
              <table-column

                :sortable="false"
                :filterable="false"
                label="Actions"
              >
                <template slot-scope="row">
                  <div class="table__actions">
                    <router-link v-if="Write == 1" :to="{ name: 'editemployees', params: { employeesId: row.id }}"><a v-b-popover.hover ="'EDIT'"
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
            <!-- <div v-else>
                <div class="alert alert-info" role="alert">
                  Sorry! you dont have permission
                </div>
            </div> -->
          </div>
        </div>
      </div>
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
    async getEmployees ({ page, filter, sort }) {
      try {
        const response = await axios.get(`/api/admin/users/employees/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`)

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

    blockUser (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {
          window.toastr['info']('Cancel')
        },
        submitCallback: function () {
          self.blockUserData(id)
        }
      })
    },
    async blockUserData (id) {
      try {
        let response = await window.axios.put('/api/admin/users/' + id)
        // this.users = response.data
        window.toastr['success']('User Blocked', 'Success')
        this.$refs.allUsers.refresh()
        // location.reload()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    // Block User
    unblockUser (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sureabout changing this users Block status?',
        cancelCallback: function () {
          window.toastr['info']('Cancel')
        },
        submitCallback: function () {
          self.unblockUserData(id)
        }
      })
    },

    // Unblock User
    async unblockUserData (id) {
      try {
        let response = await window.axios.put('/api/admin/users/unblock/' + id)
        this.users = response.data
        window.toastr['success']('User Blocked', 'Success')
        this.$refs.allUsers.refresh()
        // location.reload()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
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
        let response = await window.axios.delete('/api/admin/users/' + id)
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
