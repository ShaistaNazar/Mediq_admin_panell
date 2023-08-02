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
    </div>
    <tabs :options="{ useUrlFragment: false }" class="tabs-default">
      <!--------------------- Products -------------------->
      <tab id="sold-products" name="Highest Grossing Products">
        <div class="row">
          <div class="col-sm-12 hide">
            <div class="card border">
              <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
          </div>-->
              <div v-if="Read == 1" class="card-body">
                <table-component
                  ref="city"
                  :data="getHighestGrossingProducts"
                  sort-by="id"
                  sort-order="desc"
                  table-class="table"
                >
                  <table-column label="Type" >
                    <template slot-scope="row">

                      <div v-if="row.product_type == 'Equipments'">
                        <b>Equipment</b>
                      </div>
                      <div v-else-if="row.product_type == 'LabTest'">
                        <b>Lab Test</b>
                      </div>
                      <div v-else-if="row.product_type == 'Medicines'">
                        <b>Medicine</b>
                      </div>
                      <div v-else-if="row.product_type == 'OtherMedicines'">
                        <b>Miscellaneous Medicine</b>
                      </div>
                      <div v-else>
                        <b>Not Available</b>
                      </div>
                    </template>
                  </table-column>

                  <table-column label="Product Name" >
                    <template slot-scope="row">

                      <div v-if="row.product_type == 'Equipments' && row.equ_products != null">
                        <b>{{ row.equ_products.equipment_name }}</b>
                      </div>
                      <div v-else-if="row.product_type == 'LabTest' && row.test_products != null">
                        <b>{{ row.test_products.test_name }}</b>
                      </div>
                      <div v-else-if="row.product_type == 'Medicines' && row.med_products != null">
                        <b>{{ row.med_products.medicine_name }}</b>
                      </div>
                      <div v-else-if="row.product_type == 'OtherMedicines' && row.other_medicines != null">
                        <b>{{ row.other_medicines.medicine_name }}</b>
                      </div>
                      <div v-else>
                        <b>Not Available</b>
                      </div>
                    </template>
                  </table-column>

                  <table-column label="No of orders" >
                    <template slot-scope="row">
                      <span class="badge badge-warning">{{ row.total_product }}</span>

                    </template>
                  </table-column>

                  <table-column
                    :formatter="formatter"
                    show="created_at"
                    label="Order Date"
                    data-type="date:YYYY-MM-DD"
                  />

                </table-component>
              </div>
              <div v-else class="alert alert-info" role="alert">Sorry! you dont have permission</div>
            </div>
          </div>
        </div>
      </tab>

      <!--------------------- Services -------------------->
      <tab id="sold-service" name="Highest Grossing Services">
        <div class="row">
          <div class="col-sm-12 hide">
            <div class="card border">
              <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
          </div>-->
              <div v-if="Read == 1" class="card-body">
                <table-component
                  ref="city"
                  :data="getHighestGrossingServices"
                  sort-by="id"
                  sort-order="desc"
                  table-class="table"
                >
                  <table-column label="Type" >
                    Service
                  </table-column>

                  <table-column label="Service Name" >
                    <template slot-scope="row">

                      <div v-if="row.service_id != null">
                        <b>{{ row.services[0].service_name }}</b>
                      </div>

                    </template>
                  </table-column>

                  <table-column label="No of orders" >
                    <template slot-scope="row">
                      <span class="badge badge-warning">{{ row.total_product }}</span>

                    </template>
                  </table-column>

                  <table-column
                    :formatter="formatter"
                    show="created_at"
                    label="Order Date"
                    data-type="date:YYYY-MM-DD"
                  />

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
import moment from 'moment'
import { SweetModal, SweetModalTab } from 'sweet-modal-vue'
import { required, sameAs, minLength, between } from 'vuelidate/lib/validators'
import { Tabs, Tab } from 'vue-tabs-component'

Vue.use(BootstrapVue)

export default {
  components: {
    TableComponent,
    TableColumn,
    SweetModal,
    SweetModalTab,
    tabs: Tabs,
    tab: Tab
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
        orderId: 0
      }
    }
  },
  validations: {
    form: {
      SelectedProvider: {
        required
      }
    }
  },
  mounted () {
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
    this.getHighestGrossingServices()
  },
  methods: {

    async getHighestGrossingProducts ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/getHighestGrossingProducts?page=${page}&filter=${filter}&completed=${1}`
        )

        return {
          data: response.data,
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
    async getHighestGrossingServices () {
      try {
        const response = await axios.get(
          `/api/admin/orders/getHighestGrossingServices`
        )

        return {
          data: response.data
        }
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    formatter (value, rowProperties) {
      return moment(value).format('Do MMM YYYY, hh : mm a')
    }

  }
}
</script>
