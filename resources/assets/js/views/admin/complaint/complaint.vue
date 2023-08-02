<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Complaints List</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Complaints</li>
      </ol>
      <div class="page-actions">
        <router-link v-if="Write == 1" to="/complaint/add">
          <a href="/complaint/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus"/> Add New Complaint
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
              :data="getComplaints"
              sort-by="id"
              sort-order="desc"
              table-class="table"
            >
              <table-column label="Complain From">
                <template slot-scope="row">
                  <span v-if="row.complainer != null">
                    {{ row.complainer.full_name }} |
                  </span>
                  {{ row.user_phone }}
                </template>
              </table-column>
              <table-column show="complaint_title" label="Complain About"/>
              <table-column show="complaint_description" label="Complain Description"/>

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
                    <router-link v-if="Write == 1" :to="{ name: 'EditComplaint', params: { complaintId: row.id }}"><a v-b-popover.hover ="'EDIT'"
                                                                                                                      class="btn btn-default btn-sm">
                      <i class="icon-fa icon-fa-pencil"/>
                    </a>
                    </router-link>
                    <div/>
                    <a
                      v-b-popover.hover="'Test Description'"
                      class="btn btn-default btn-sm"
                      @click="$refs.test_description.open(),testDescription(row.complaint_description)"
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
    formatter (value, rowProperties) {
      return moment(value).format('Do MMM YYYY')
    },
    async getComplaints ({ page, filter, sort }) {
      try {
        const response = await axios.get(`/api/admin/UserComplaints/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`)

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
    testDescription (description) {
      this.Description = description
      // this.$refs.medicine_warnings.refresh();
    }
  }
}
</script>
