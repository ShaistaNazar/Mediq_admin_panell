<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Rental Equipments Orders</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Rental Equipment Orders</li>
      </ol>
    </div>
    <!-- <tabs class="tabs-default"  :options="{ useUrlFragment: false }"> -->
    <!--------------------- Products -------------------->
    <!-- <tab id="sold-products" name="Highest Grossing Products"> -->
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
              :data="getRentalEquipmentReport"
              sort-by="id"
              sort-order="desc"
              table-class="table"
            >

              <table-column label="Equipment Name" class="equipment-width">
                <template slot-scope="row">
                  {{ row.equipment.equipment_name }}
                </template>
              </table-column>

              <table-column label="Is Popular" >
                <template slot-scope="row">
                  <span v-if="row.equipment.in_demand == 1" class="badge in_demand">
                    In_Demand
                  </span>
                  <span v-else class="badge out_demand">
                    Not In_Demand
                  </span>
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

    <!-- </tab> -->

    <!-- </tabs> -->
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

    async getRentalEquipmentReport ({ page, filter, sort }) {
      try {
        const response = await window.axios.get(
          `/api/admin/orders/getRentalEquipmentReport?page=${page}&filter=${filter}`
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
    }

  }
}
</script>
