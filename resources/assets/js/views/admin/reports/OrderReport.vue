<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">orders</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/Orders">
            <a>Orders</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Product Order Report</li>
      </ol>
    </div>
    <tabs :options="{ useUrlFragment: false }" class="tabs-default">
      <!--------------------- Completed -------------------->
      <tab id="completed" name="Completed Orders">
        <div class="row">
          <div class="col-sm-12 hide">
            <div class="card border">

              <!-- <div class="card-header">
            <h6>All Existing orders in Database</h6>
            <div class="card-actions" />
          </div>-->
              <div v-if="Read == 1" class="card-body">
                <table-component
                  ref="orders"
                  :data="getCompletedOrders"
                  sort-by="id"
                  sort-order="desc"
                  table-class="table"
                >
                  <table-column show="order_number" label="Order ID" />
                  <table-column :sortable="false" :filterable="false" show="payment_methods.name" label="Payment Method" />
                  <table-column :sortable="false" :filterable="false" show="users.full_name" label="Ordered By" />
                  <table-column :sortable="false" :filterable="false" show="users.phone" label="Phone" />
                  <table-column :formatter="formatPrice" show="total_amount" label="Total Amount" />
                  <!-- <table-column show="status.status" label="Status" /> -->
                  <table-column :sortable="false" :filterable="false" label="Source" >
                    <template slot-scope="row">

                      <div v-if="row.is_admin == 1" class="text-success">
                        <b>Admin Panel </b>
                      </div>
                      <div v-else class="text-danger">
                        <b>Mobile App</b>
                      </div>
                    </template>
                  </table-column>
                  <table-column :sortable="false" :filterable="false" label="Status" >
                    <template slot-scope="row">
                      <div v-if="row.status.id == 1" class="text-danger">
                        <b>Cancelled</b>
                      </div>
                      <div v-if="row.status.id == 3" class="text-warning">
                        <b>Not Paid</b>
                      </div>
                      <div v-if="row.status.id == 2" class="text-info">
                        <b>Paid</b>
                      </div>
                      <div v-if="row.status.id == 4" class="text-success">
                        <b>Paid & Completed</b>
                      </div>
                    </template>
                  </table-column>
                  <table-column
                    :formatter="formatter"
                    show="created_at"
                    label="created at"
                    data-type="YYYY-MM-DD MM-HH"
                  />
                  <!-- <table-column
                show="created_at"
                label="created at"
                data-type="a/A: a/A	"
                :formatter="timeFormatter"
              /> -->

                </table-component>
              </div>
              <div v-else class="alert alert-info" role="alert">Sorry! you dont have permission</div>
            </div>
          </div>
        </div>
      </tab>
      <!--------------------- Pending -------------------->
      <tab id="Pending" name="Pending Orders">
        <div class="row">
          <div class="col-sm-12 hide">
            <div class="card border">

              <!-- <div class="card-header">
            <h6>All Existing orders in Database</h6>
            <div class="card-actions" />
          </div>-->
              <div v-if="Read == 1" class="card-body">
                <table-component
                  ref="orders"
                  :data="getPendingOrders"
                  sort-by="id"
                  sort-order="desc"
                  table-class="table"
                >
                  <table-column show="order_number" label="Order ID" />
                  <table-column :sortable="false" :filterable="false" show="payment_methods.name" label="Payment Method" />
                  <table-column :sortable="false" :filterable="false" show="users.full_name" label="Ordered By" />
                  <table-column :sortable="false" :filterable="false" show="users.phone" label="Phone" />
                  <table-column :formatter="formatPrice" show="total_amount" label="Total Amount" />
                  <!-- <table-column show="status.status" label="Status" /> -->
                  <table-column :sortable="false" :filterable="false" label="Source" >
                    <template slot-scope="row">

                      <div v-if="row.is_admin == 1" class="text-success">
                        <b>Admin Panel </b>
                      </div>
                      <div v-else class="text-danger">
                        <b>Mobile App</b>
                      </div>
                    </template>
                  </table-column>
                  <table-column :sortable="false" :filterable="false" label="Status" >
                    <template slot-scope="row">
                      <div v-if="row.status.id == 1" class="text-danger">
                        <b>Cancelled</b>
                      </div>
                      <div v-if="row.status.id == 3" class="text-warning">
                        <b>Not Paid</b>
                      </div>
                      <div v-if="row.status.id == 2" class="text-info">
                        <b>Paid</b>
                      </div>
                      <div v-if="row.status.id == 4" class="text-success">
                        <b>Paid & Completed</b>
                      </div>
                    </template>
                  </table-column>
                  <table-column
                    :formatter="formatter"
                    show="created_at"
                    label="created at"
                    data-type="YYYY-MM-DD MM-HH"
                  />
                  <!-- <table-column
                show="created_at"
                label="created at"
                data-type="a/A: a/A	"
                :formatter="timeFormatter"
              /> -->

                </table-component>
              </div>
              <div v-else class="alert alert-info" role="alert">Sorry! you dont have permission</div>
            </div>
          </div>
        </div>
      </tab>
      <!--------------------- Cancelled -------------------->

      <tab id="Cancelled" name="Cancelled Orders">
        <div class="row">
          <div class="col-sm-12 hide">
            <div class="card border">

              <!-- <div class="card-header">
            <h6>All Existing orders in Database</h6>
            <div class="card-actions" />
          </div>-->
              <div v-if="Read == 1" class="card-body">
                <table-component
                  ref="orders"
                  :data="getCancelledOrders"
                  sort-by="id"
                  sort-order="desc"
                  table-class="table"
                >
                  <table-column show="order_number" label="Order ID" />
                  <table-column :sortable="false" :filterable="false" show="payment_methods.name" label="Payment Method" />
                  <table-column :sortable="false" :filterable="false" show="users.full_name" label="Ordered By" />
                  <table-column :sortable="false" :filterable="false" show="users.phone" label="Phone" />
                  <table-column :formatter="formatPrice" :filterable="false" show="total_amount" label="Total Amount" />
                  <!-- <table-column :sortable="false" :filterable="false" show="status.status" label="Status" /> -->
                  <table-column :sortable="false" :filterable="false" label="Source" >
                    <template slot-scope="row">

                      <div v-if="row.is_admin == 1" class="text-success">
                        <b>Admin Panel </b>
                      </div>
                      <div v-else class="text-danger">
                        <b>Mobile App</b>
                      </div>
                    </template>
                  </table-column>
                  <table-column :sortable="false" :filterable="false" label="Status" >
                    <template slot-scope="row">
                      <div v-if="row.status.id == 1" class="text-danger">
                        <b>Cancelled</b>
                      </div>
                      <div v-if="row.status.id == 3" class="text-warning">
                        <b>Not Paid</b>
                      </div>
                      <div v-if="row.status.id == 2" class="text-info">
                        <b>Paid</b>
                      </div>
                      <div v-if="row.status.id == 4" class="text-success">
                        <b>Paid & Completed</b>
                      </div>
                    </template>
                  </table-column>
                  <table-column
                    :formatter="formatter"
                    show="created_at"
                    label="created at"
                    data-type="YYYY-MM-DD MM-HH"
                  />
                  <!-- <table-column
                show="created_at"
                label="created at"
                data-type="a/A: a/A	"
                :formatter="timeFormatter"
              /> -->

                </table-component>
              </div>
              <div v-else class="alert alert-info" role="alert">Sorry! you dont have permission</div>
            </div>
          </div>
        </div>
      </tab>

    </tabs>
  </div>
</template>

<script type="text/babel">
import { TableComponent, TableColumn } from 'vue-table-component'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Ls from '../../../services/ls'
import { Tabs, Tab } from 'vue-tabs-component'
import moment from 'moment'

Vue.use(BootstrapVue)

export default {
  components: {
    TableComponent,
    TableColumn,
    tabs: Tabs,
    tab: Tab
  },
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      orders: []
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
    async getCompletedOrders ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/get?page=${page}&filter=${filter}&completed=${1}&sortcol=${sort.fieldName}&sort=${sort.order}`
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
    async getPendingOrders ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/get?page=${page}&filter=${filter}&pending=${1}&sortcol=${sort.fieldName}&sort=${sort.order}`
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
    async getCancelledOrders ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/get?page=${page}&filter=${filter}&cancelled=${1}&sortcol=${sort.fieldName}&sort=${sort.order}`
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

    formatter (value, rowProperties) {
      return moment(value).format('Do MMM YYYY, hh : mm a')
    },
    timeFormatter (value, rowProperties) {
      return moment(value).format('HH : mm')
    }
  }
}
</script>
