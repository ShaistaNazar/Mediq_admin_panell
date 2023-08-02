<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Laboratory Tests</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Tests</li>
      </ol>
      <div class="page-actions">
        <router-link v-if="Write == 1" to="/tests/add">
          <a href="/tests/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus"/> Add New Tests
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
              :data="getTests"
              sort-by="id"
              sort-order="desc"
              table-class="table"
            >

              <table-column show="test_name" label="Test Name"/>
              <table-column :formatter="formatPrice" show="price" label="price"/>
              <table-column :sortable="false" :filterable="false"
                            label="Category">
                <template slot-scope="row">
                  <div class="currentPkg">
                    {{ row.test_category[0].category_name }}
                  </div>
                </template>
              </table-column>

              <table-column label="Prescription" show="is_prescription_req">
                <template slot-scope="row">
                  <div v-if="row.is_prescription_req == 1">Required</div>
                  <div v-else>Not Required</div>
                </template>
              </table-column>

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
                    <router-link v-if="Write == 1" :to="{ name: 'editTests', params: { TestsId: row.id }}"><a v-b-popover.hover ="'EDIT'"
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
                    <a
                      v-b-popover.hover="'Test Description'"
                      class="btn btn-default btn-sm"
                      @click="$refs.test_description.open(),testDescription(row.description)"
                    >
                      <i class="icon-fa icon-fa-info-circle" />
                    </a>
                    <!-- <div v-if="Delete == 1"> -->
                    <a v-b-popover.hover ="'DELETE'"
                       v-if="Delete == 1"
                       class="btn btn-default btn-sm"
                       data-delete
                       data-confirmation="notie"
                       @click="destroyUser(row.id)"
                    >
                      <i class="icon-fa icon-fa-trash"/>
                    </a>

                    <!-- </div> -->
                    <div v-if="row.in_demand == 0" class="float-right">
                        <a
                          v-b-popover.hover="'DELETE'"
                          class="btn btn-warning btn-sm"
                          style="color:white !important"
                          data-delete
                          data-confirmation="notie"
                          @click="AddInDemand(row.id , type = 'test')"
                        >Add to In-Demand
                        </a>
                      </div>
                      <div v-else class="btn btn-success btn-sm">Already In-Demand</div>
                                    
                  </div>
                </template>
              </table-column>
            </table-component>
            <sweet-modal ref="test_description" modal-theme="dark" overlay-theme="dark">
              <div class="card-header">
                <h6>
                  Description
                </h6>

              </div>
              <div v-if="Description != ''" class="card-body">
                {{ Description }}
              </div>
              <div v-else class="card-body">
                <h6>Description Not Available</h6>

              </div>

            </sweet-modal>
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
import { SweetModal, SweetModalTab } from 'sweet-modal-vue'

export default {
  components: {
    TableComponent,
    TableColumn,
    SweetModal,
    SweetModalTab
  },
  data () {
    return {
      users: [],
      Description: '',
      imageLink: imageLink,
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
    formatPrice (value) {
      let val = (value / 1).toFixed(2).replace(',', '.')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    },
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
    async getTests ({ page, filter, sort }) {
      try {
        const response = await axios.get(`/api/admin/Tests/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`)

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
      event.target.src = this.imageLink + 'users/no-photo.jpg'
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
        let response = await window.axios.delete('/api/admin/Tests/' + id)
        this.users = response.data
        window.toastr['success']('Test Deleted', 'Success')
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
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    testDescription (description) {
      this.Description = description
      // this.$refs.medicine_warnings.refresh();
    }
    //  openprmodel(id) {

    //    this.form.UID = id;
    //       this.$refs.dark_html_modal_statuscomm.open();
    //     },

  }
}
</script>
