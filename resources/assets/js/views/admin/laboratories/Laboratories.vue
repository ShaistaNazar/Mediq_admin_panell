<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Laboratories</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Laboratories</li>
      </ol>
      <div class="page-actions">
        <!-- <router-link v-if="Write == 1" to="/Laboratories/add">
          <a href="/Laboratories/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus"/> Add New Laboratory
          </a>
        </router-link> -->
        <router-link v-if="Write == 1" to="/LabCategory">
          <a href="/LabCategory" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus"/> Laboratory Test's Categories
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
              :data="getLaboratories"
              sort-by="id"
              sort-order="desc"
              table-class="table"
            >

              <table-column show="lab_name" label="Laboratory Name"/>

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
                    <router-link v-if="Write == 1" :to="{ name: 'editLaboratories', params: { LaboratoriesId: row.id }}"><a v-b-popover.hover ="'EDIT'"
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
      form: {
        submitBtn: 'Update',
        lab_name: ''
      }
    }
  },
  validations: {
    form: {
      lab_name: {
        required,
        minLength: minLength(4)
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
        this.$v.form.$touch()
        if (this.$v.form.$error) return
        let response = await window.axios.post('/api/admin/Laboratories/add', {
          data: this.form
        })
        window.toastr['success'](
          response,
          'Success'
        )
        this.$refs.allUsers.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response,
            'Error'
          )
        }
      }
    },
    formatter (value, rowProperties) {
      return moment(value).format('Do MMM YYYY')
    },

    async getLaboratories ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/Laboratories/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`
        )

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
        cancelCallback: function () {},
        submitCallback: function () {
          self.destroyUserData(id)
        }
      })
    },

    async destroyUserData (id) {
      try {
        let response = await window.axios.delete('/api/admin/Laboratories/' + id)
        this.users = response.data
        window.toastr['success']('Laboratory Deleted', 'Success')
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
