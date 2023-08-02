<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Orders</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Orders</li>
      </ol>
      <div v-if="Write == 1" class="page-actions">
        <router-link to="/orders/add">
          <a href="/orders/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus" /> New Order
          </a>
        </router-link>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <!-- <div class="card-header">
            <h6>All Existing orders in Database</h6>
            <div class="card-actions" />
          </div>-->
          <div v-if="Read == 1" class="card-body">
            <table-component
              ref="orders"
              :data="getorders"
              sort-by="id"
              sort-order="desc"
              table-class="table"
            >
              <table-column show="order_number" label="Order ID" />
              <!-- <table-column 
                :sortable="false"
                :filterable="false" show="payment_methods.name" label="Payment Method" /> -->
              <table-column 
                :sortable="false"
                :filterable="false" show="users.full_name" label="Ordered By" />
              <table-column 
                :sortable="false"
                :filterable="false" show="users.phone" label="Phone" />
              <!-- <table-column 
                :sortable="false"
                :filterable="false" show="status.status" label="Status" /> -->
              <table-column 
                :sortable="false"
                :filterable="false" label="Source" >
                <template slot-scope="row">

                  <div v-if="row.is_admin == 1" class="text-success">
                    <b>Admin Panel </b>
                  </div>
                  <div v-else class="text-danger">
                    <b>Mobile App</b>
                  </div>
                </template>
              </table-column>
              <table-column 
                :sortable="false"
                :filterable="false" label="Payment" >
                <template slot-scope="row">
                  <!-- <div> -->
                  <div v-if="row.payment_method_id == 0" class="text-warning">
                    <b>Not selected yet..
                    </b>

                  </div>
                  <img v-b-popover.hover="'Cash On Delivery'" v-else-if="row.payment_method_id == 4"
                       id="logo-payment"
                       src="/assets/img/cash-on-delivery.png"
                       alt="Laraspace Logo"
                       class="d-none d-md-inline"
                  >
                  <img v-b-popover.hover="'Easy Paisa'" v-else-if="row.payment_method_id == 5 || row.payment_method_id == 6"
                       id="logo-payment"
                       src="/assets/img/easy-paisa.png"
                       alt="Laraspace Logo"
                       class="d-none d-md-inline"
                  >
                  <img v-b-popover.hover="'Jazz Cash'" v-else
                       id="logo-payment"
                       src="/assets/img/jazz-cash.png"
                       alt="Laraspace Logo"
                       class="d-none d-md-inline"
                  >
                  <!-- </div> -->

                </template>
              </table-column>
              <table-column 
                :sortable="false"
                :filterable="false" label="Status" >
                <template slot-scope="row">
                  <div v-if="row.status.id == 1" class="text-danger">
                    <b>Cancelled</b>
                  </div>
                  <div v-if="row.status.id == 3" class="text-warning">
                    <b>Not Paid</b>
                  </div>
                  <div v-if="row.status.id == 2" class="text-info">
                    <b>Paid but not deliverd</b>
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
                data-type="date:YYYY-MM-DD MM-HH"
              />
              <!-- <table-column
                show="created_at"
                label="created at"
                data-type="a/A: a/A	"
                :formatter="timeFormatter"
              /> -->

              <table-column v-if="Write == 1 || Delete == 1" :sortable="false" :filterable="false" label>
                <template slot-scope="row">
                  <div class="table__actions">
                    <router-link v-if="Write == 1" :to="{ name: 'editOrders', params: { OrdersId: row.id }}">
                      <a v-b-popover.hover="'Order Details'">
                        <i class="icon-fa icon-fa-cog" style="color:lightblue;font-size: 23px;" />
                      </a>
                    </router-link>
                    <a v-b-popover.hover="'Mark Complete'"
                       v-if="Write == 1"
                       data-delete
                       data-confirmation="notie"
                       @click="ChnageStatus(4, row.id, row.order_number)"
                    ><i class="icon-fa icon-fa-check-circle" style="color:green;font-size: 23px;" />
                    </a>
                    <a v-b-popover.hover="'Cancel Order'"
                       v-if="Delete == 1"
                       data-delete
                       data-confirmation="notie"
                       @click="ChnageStatus(1, row.id, row.order_number)"
                    ><i class="icon-fa icon-fa-times-circle" style="color:red;font-size: 23px;" />
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

Vue.use(BootstrapVue)

export default {
  components: {
    TableComponent,
    TableColumn
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
    async getorders ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`
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

    ChnageStatus (val, data, order) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {},
        submitCallback: function () {
          self.ChnageStatusFun(val, data, order)
        }
      })
    },
    async ChnageStatusFun (val, data, order) {
      try {
        let id = this.$route.params.OrdersId
        let response = await window.axios.post(`/api/admin/orders/status?val=${val}&data=${data}&order=${order}`)
        // this.orders = response.data;
        window.toastr['success']('Status Changed', 'Success')
        // this.getorders();
        this.$refs.orders.refresh()
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
