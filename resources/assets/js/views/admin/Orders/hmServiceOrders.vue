<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Home-Medical Services Orders</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Home-Medical Service Orders</li>
      </ol>
      <div class="page-actions">
        <router-link to="/NewOrderService">
          <a href="/NewOrderService" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus" /> New Home-Medical Service Order
          </a>
        </router-link>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
          </div>-->
          <div v-if="Read == 1" class="card-body">
            <table-component
              ref="city"
              :data="getHM_Service"
              sort-by="id"
              sort-order="desc"
              table-class="table"
            >
              <table-column label="From"   :sortable="false" :filterable="false">
                <template slot-scope="row">

                  <div v-if="row.by_admin == 1">
                    <b>Ordered by: {{ row.users.full_name }} </b>
                  </div>
                  <div v-else>
                    <b v-if="row.users">{{ row.users.full_name }} | {{ row.users.phone }}</b>
                    <b v-else>User Unknown</b>
                  </div>
                </template>
              </table-column>

              <table-column label="Service Selected" :sortable="false" :filterable="false" >
                <template slot-scope="row">
                  <div v-if="row.services.length != 0">
                    <b>{{ row.services[0].service_name }}</b>
                  </div>
                  <div v-else>Not Selected Yet</div>
                </template>
              </table-column>

              <table-column label="Source" :sortable="false" :filterable="false" >
                <template slot-scope="row">

                  <div v-if="row.by_admin == 1" class="text-success">
                    <b>Admin Panel </b>
                  </div>
                  <div v-else class="text-danger">
                    <b>Mobile App</b>
                  </div>
                </template>
              </table-column>

              <table-column label="Payment" :sortable="false" :filterable="false" >
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

              <table-column label="Status" :sortable="false" :filterable="false" >
                <template slot-scope="row">
                  <div v-if="row.payment_status == 1" class="text-danger">
                    <b>Cancelled</b>
                  </div>
                  <div v-if="row.payment_status == 3 || row.payment_status == 0" class="text-warning">
                    <b>Not Paid</b>
                  </div>
                  <div v-if="row.payment_status == 2" class="text-info">
                    <b>Paid but not deliverd</b>
                  </div>
                  <div v-if="row.payment_status == 4" class="text-success">
                    <b>Paid & Completed</b>
                  </div>
                </template>
              </table-column>
              <table-column label="Provider Selected" :sortable="false" :filterable="false" >
                <template slot-scope="row">
                  <div v-if="row.providers != null">
                    <b>{{ row.providers.full_name }}</b>
                  </div>
                  <div v-else>Not Selected Yet</div>
                </template>
              </table-column>
              <table-column
                :formatter="formatter"
                show="created_at"
                label="Order Date"
                data-type="date:YYYY-MM-DD"
              />

              <table-column :sortable="false" :filterable="false" label>
                <template v-if="Write == 1 || Delete == 1" slot-scope="row">
                  <div class="table__actions">
                    <!-- <router-link :to="{ name: 'editcity', params: { cityId: row.id }}">
                      <a v-b-popover.hover="'EDIT'" class="btn btn-default btn-sm">
                        <i class="icon-fa icon-fa-pencil" />
                      </a>
                    </router-link> -->
                    <a
                      v-b-popover.hover="'Mark Complete'"
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="statusConfirm(row.id, 4)"
                    ><i class="icon-fa icon-fa-check-circle" style="color:green;font-size: 23px;" /></a>
                    <a
                      v-b-popover.hover="'Mark Cancel'"
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="statusConfirm(row.id, 1)"
                    ><i class="icon-fa icon-fa-times-circle" style="color:red;font-size: 23px;" /></a>
                    <a
                      v-b-popover.hover="'View Comments'"
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="openComment(row.comments)"
                    >
                      <i class="icon-fa icon-fa-comment" style="color:lightblue;font-size: 23px;" />
                    </a>
                    <a
                      v-b-popover.hover="'Select Service Provider'"
                      @click="LoadAllServices(row.services[0].id,row.id,row.total_amount, row.order_number,row.providers)"
                    ><i class="icon-fa icon-fa-medkit" style="color:#cc85ad ;font-size: 23px;" />
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
    <sweet-modal
      ref="popup"
      modal-theme="dark"
      overlay-theme="dark"
    >
      <div class="card-header hide">
        <div class="card-actions hide" />
      </div>
      <div class="card-body hide">
        <template>
          <div class="form-group col-md-12">
            <label for="inputEmail">Select Service Provider</label>
            <select
              id="inputRole"
              v-model="form.SelectedProvider"
              required
              class="form-control"
              placeholder="Select City"
            >
              <option disabled value>Service Providers</option>
              <option
                v-for="(OneCat, OneCatIndex) in services"
                :key="OneCatIndex"
                :value="OneCat"
              > {{ OneCat.full_name }}</option>
            </select>
            <div v-if="$v.form.SelectedProvider.$error">
              <span v-if="!$v.form.SelectedProvider.required" class="help-block help-block-error">
                <p class="text-danger">Must select a provider.</p>
              </span>
            </div>
          </div>
          <div class="form-group col-md-12">
            <label for="inputAmount">Total Amount</label>
            <input
              id="inputAmount"
              v-model.trim="form.TotalAmount"
              type="number"
              min= 0
              step= 0.01
              class="form-control"
              placeholder="Total Amount"
            >
            <div v-if="$v.form.TotalAmount.$error">
              <span v-if="!$v.form.TotalAmount.required" class="help-block help-block-error">
                Field is required
              </span>
            </div>
          </div>
          <button
            :disabled="$v.$invalid"
            type="submit"
            class="btn btn-primary"
            @click.prevent="submit"
          >Submit</button>
        </template>
      </div>
    </sweet-modal>
    <sweet-modal
      ref="comments"
      modal-theme="dark"
      overlay-theme="dark"
    >
      <div class="card-header hide">
        <div class="card-actions hide" />
      </div>
      <div class="card-body hide">
        <template>
          <h6>These are the comments User submitted when placing this request</h6><br>
          <b>"{{ comments }}"</b>
        </template>
      </div>
    </sweet-modal>
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
import { SweetModal, SweetModalTab } from 'sweet-modal-vue'
import { required, sameAs, minLength, between } from 'vuelidate/lib/validators'

Vue.use(BootstrapVue)

export default {
  components: {
    TableComponent,
    TableColumn,
    SweetModal,
    SweetModalTab
  },
  data () {
    return {
      Read: '',
      comments: '',
      Write: '',
      Delete: '',
      services: '',
      submitBtn: 'Submit',
      form: {
        SelectedProvider: '',
        TotalAmount: '',
        orderId: 0,
        orderNumber: 0
      }
    }
  },
  validations: {
    form: {
      SelectedProvider: {
        required
      },
      TotalAmount: {
        required
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
        let response = await window.axios.post(
          '/api/admin/orders/providerSelected/add',
          { data: this.form }
        )
        // console.log(this.form)
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.$refs.popup.close()
        this.$refs.city.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response.data.ResponseHeader.ResponseMessage,
            'Error'
          )
        }
      }
    },
    async getHM_Service ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/serviceOrders/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`
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
        let response = await window.axios.delete('/api/admin/cities/' + id)
        this.cities = response.data
        window.toastr['success']('City Deleted', 'Success')
        this.$refs.city.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async LoadAllServices (id, orderId, amount, order_number, providers) {
      try {
        if (providers != null) {
          this.form.SelectedProvider = providers.full_name
        }
        this.form.orderId = orderId
        this.form.orderNumber = order_number
        this.form.TotalAmount = amount
        const response = await axios.get(
          `/api/admin/providers/dropdownOfProv/orders/get`,
          {
            params: {
              service: id
            }
          }
        )
        console.log(this.form.SelectedProvider)
        console.log(response)
        this.services = response.data
        this.$refs.popup.open()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async openComment (comments) {
      this.comments = comments
      this.$refs.comments.open(comments)
    },
    async ChangeStatus (orderId, status) {
      try {
        let response = await window.axios.post(
          '/api/admin/orders/statusChange',
          { orderId: orderId, status: status }
        )
        this.$refs.city.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    statusConfirm (id, status) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {},
        submitCallback: function () {
          self.ChangeStatus(id, status)
        }
      })
    }

  }
}
</script>
