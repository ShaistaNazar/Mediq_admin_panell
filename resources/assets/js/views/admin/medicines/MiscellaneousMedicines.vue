<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Miscellaneous Medicines</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Miscellaneous Medicines</li>
      </ol>
      <div v-if="Delete == 1" class="page-actions">
        <router-link to="miscellaneousMedicines/add">
          <a href="miscellaneousMedicines/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus" /> New Miscellaneous Medicine
          </a>
        </router-link>
      </div>

    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">

          <div v-if="Read == 1" class="card-body">
            <table-component
              ref="allMiscellaneousMedicines"
              :data="getMiscellaneousMedicines"
              sort-by="id"
              sort-order="desc"
              table-class="table"
              class="equipments"
            >

              <table-column show="medicine_name" label="medicine name"/>
              <table-column :formatter="formatPrice" show="price" label="Price"/>

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
                    <router-link v-if="Write == 1" :to="{ name: 'EditMiscellaneousMedicines', params: { mMedId: row.id }}"><a v-b-popover.hover ="'EDIT'"
                                                                                                                              class="btn btn-default btn-sm">
                      <i class="icon-fa icon-fa-pencil"/>
                    </a>
                    </router-link>

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
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import moment from 'moment'

export default {
  components: {
    TableComponent,
    TableColumn
  },
  data () {
    return {
      Read: '',
      Write: '',
      Delete: ''
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
    formatter (value, rowProperties) {
      return moment(value).format('Do MMM YYYY')
    },
    async getMiscellaneousMedicines ({ page, filter, sort }) {
      try {
        const response = await axios.get(`/api/admin/medicines/getMiscellaneousMedicines?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`)

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
        let response = await window.axios.delete('/api/admin/medicines/miscellaneous/' + id)
        this.users = response.data
        window.toastr['success']('Medicine Deleted', 'Success')
        this.$refs.allUsers.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    }
  }
}
</script>
