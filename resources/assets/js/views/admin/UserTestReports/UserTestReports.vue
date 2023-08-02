<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">User Test Reports</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">User Test Reports</li>
      </ol>
      <!-- <div class="page-actions">
        <router-link to="/cities/add">
          <a href="/cities/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus" /> New City
          </a>
        </router-link>
      </div> -->
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
          </div>-->
          <div v-if="Read == 1" class="card-body hide">
            <table-component
              ref="reports"
              :data="getUserTestReports"
              sort-by="id"
              sort-order="desc"
              table-class="table"
            >

              <table-column :sortable="false" :filterable="false" label="User Name">
                <template slot-scope="row">
                  <div>
                    <router-link
                      v-b-popover.hover="'View Profile'"
                      :to="{ name: 'viewprofile', params: { userId: row.id }}"
                      class="user-color"
                    >{{ row.users.full_name }}</router-link>
                  </div>
                </template>
              </table-column>

              <table-column :sortable="false" label="Test Name">
                <template slot-scope="row">
                  <div v-if="row.tests.test_name">
                    {{ row.tests.test_name }}
                  </div>
                </template>
              </table-column>

              <table-column :sortable="false" label="Lab Name">
                <template slot-scope="row">
                  <div>
                    {{ row.tests.labs.lab_name }}
                  </div>
                </template>
              </table-column>

              <table-column :sortable="false" label="Price">
                <template slot-scope="row">
                  <div>
                    {{ formatPrice(row.tests.price) }}
                  </div>
                </template>
              </table-column>

              <table-column :sortable="false" show="Report Available">
                <template slot-scope="row">
                  <div v-if="Write == 1 && row.file ==null || row.file =='' " class="badge badge-warning">
                    No
                  </div>
                  <div v-else class="badge badge-success">
                    Yes
                  </div>
                </template>
              </table-column>

              <table-column :sortable="false"
                            :formatter="formatter"
                            show="created_at"
                            label="Registered On"
                            data-type="date:YYYY-MM-DD"
              />

              <table-column v-if="Write == 1 || Delete == 1" :sortable="false" :filterable="false" label>
                <template slot-scope="row">
                  <div class="table__actions">
                    <router-link :to="{ name: 'editUserTestReports', params: { UserTestReportsId: row.id }}">
                      <a v-b-popover.hover="'Upload Report'" class="btn btn-default btn-sm">
                        <i class="icon-fa icon-fa-upload" />
                      </a>
                    </router-link>
                    <!-- <a v-b-popover.hover="'Already Uploaded'" ><i class="icon-fa icon-fa-check-circle"  style="color:green;font-size: 23px;padding-right: 0.2em; padding-left: 0.2em;" /></a> -->
                    <a v-b-popover.hover="'Download'"
                       v-if="Write == 1 && (row.file !=null && row.file !='' ) "
                       class="btn btn-default btn-sm"
                       data-delete
                       data-confirmation="notie"
                       @click="downloadLink(row.file)"
                    >
                      <link rel="icon" href="<%= BASE_URL %>favicon.ico">

                      <i class="icon-fa icon-fa-download" />
                    </a>
                    <a v-b-popover.hover="'DELETE'"
                       v-if="Delete == 1"
                       class="btn btn-default btn-sm"
                       data-delete
                       data-confirmation="notie"
                       @click="destroyCity(row.id)"
                    >
                      <i class="icon-fa icon-fa-trash" />
                    </a>

                    <!-- <a
                      v-b-popover.hover ="'BLOCK'"
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="blockCity(row.id)"

                    >
                      <i class="icon-fa icon-fa-lock"/>
                    </a>-->
                  </div>
                </template>
              </table-column>
            </table-component>
          </div>
          <div v-else class="alert alert-info" role="alert">Sorry! you dont have permission</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import { TableComponent, TableColumn } from 'vue-table-component'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Ls from '../../../services/ls'
import moment from 'moment'
import { imageLink} from '../../../helpers/constants'

Vue.use(BootstrapVue)

export default {
  components: {
    TableComponent,
    TableColumn
  },
  data () {
    return {
      imageLink: imageLink,
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
    async downloadLink (file) {
      window.location.href = imageLink + file
    },
    formatPrice(value) {
        let val = (value/1).toFixed(2).replace(',', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },

    async getUserTestReports ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/UserTestReports/get?page=${page}&filter=${filter}&sort=${sort.order}&sortcol=${sort.fieldName}`
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

    destroyCity (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {},
        submitCallback: function () {
          self.destroyCityData(id)
        }
      })
    },
    async destroyCityData (id) {
      try {
        let response = await window.axios.delete('/api/admin/UserTestReports/' + id)
        window.toastr['success']('City Deleted', 'Success')
        this.$refs.reports.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    formatter (value, rowProperties) {
      return moment(value).format('Do MMM YYYY')
    }
  }
}
</script>
