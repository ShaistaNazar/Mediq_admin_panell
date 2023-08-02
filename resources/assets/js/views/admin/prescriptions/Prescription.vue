<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">User Prescriptions</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">User Prescriptions</li>
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
      <div class="col-sm-12 hide">
        <div class="card">
          <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
          </div>-->
          <div v-if="Read == 1" class="card-body">
            <table-component
              :data="getUserPrescription"
              sort-by="id"
              sort-order="desc"
              table-class="table"
              class="equipments"
            >
              <table-column
                :sortable="false"
                :filterable="false"
                label="Prescription"
              >
                <template slot-scope="row">
                  <div>
                    <a v-b-popover.hover ="'Open Priscription'" href="#" @click="$refs.prescription_info.open(),prescriptionModel(row.prescription_path)">

                      <img :src="imagelink + row.prescription_path" height="100" width="100" @error="onImageLoadFailure($event)">
                    </a>

                  </div>
                </template>
              </table-column>
              <table-column
                show="name"
                label="Name"
              />
              <table-column
                show="email"
                label="Email"
              />
              <table-column
                show="mobile_number"
                label="Phone"
              />
              <table-column
                :formatter="formatter"
                show="created_at"
                label="Ordered at"
                data-type="date:YYYY-MM-DD"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                label="Actions"
              >
                <template slot-scope="row">
                  <div class="table__actions">

                    <router-link v-if="Write == 1" :to="{ name: 'newOrders', params: { OrdersId: row.id, UserId: row.ordered_by_user }}"><a v-b-popover.hover ="'Add to cart'"
                                                                                                                                            class="btn btn-default btn-sm">
                      <i class="icon-fa icon-fa-cart-plus" style="font-size: 23px;"/>
                    </a>
                    </router-link>

                  </div>
                </template>
              </table-column>

            </table-component>
            <sweet-modal ref="prescription_info" modal-theme="dark" overlay-theme="dark" width="70%">
              <div class="card-body prescription">
                <img :src="imagelink + Prescription" height="500" @error="onImageLoadFailure($event)">

              </div>
            </sweet-modal>
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
import { mobileImageLink} from '../../../helpers/constants'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Ls from '../../../services/ls'
import moment from 'moment'
import { SweetModal, SweetModalTab } from 'sweet-modal-vue'

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
      imagelink: mobileImageLink,
      Read: '',
      Write: '',
      Delete: '',
      Prescription: ''
    }
  },
  mounted () {
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },
  methods: {
    async downloadLink (file) {
      window.location.href = imageLink + file
    },

    async getUserPrescription ({ page, filter, sort }) {
      try {
        let userId = this.$route.params.userId
        const response = await axios.get(
          `/api/admin/users/userprescription?page=${page}&filter=${filter}`
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
    onImageLoadFailure (event) {
      event.target.src = this.imagelink + 'prescriptions/prescription_icon.png'
    },
    prescriptionModel (Prescription) {
      this.Prescription = Prescription
      // this.$refs.medicine_warnings.refresh();
    }
  }

}
</script>
