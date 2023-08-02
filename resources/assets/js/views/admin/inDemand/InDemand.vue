<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">In Demand Products</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">In Demand Products</li>
      </ol>
    </div>

    <tabs :options="{ useUrlFragment: false }" class="tabs-default">
      <tab id="medicines" name="Medicines">
        <div class="row">
          <div class="col-sm-12 hide">
            <div class="card">
              <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
              </div>-->
              <div v-if="Read == 1" class="card-body">
                <table-component
                  ref="allMedicineInDemand"
                  :data="inDemandMed"
                  sort-by="id"
                  sort-order="desc"
                  table-class="table"
                >
                  <table-column show="id" label="medicine id"/>
                  <table-column
                    :sortable="false"
                    :filterable="false"
                    label="Picture"
                  >
                    <template slot-scope="row">
                      <div>
                        <img :src="imageLink + row.medicine_image" height="27" @error="onImageLoadFailure($event)" >
                      </div>
                    </template>
                  </table-column>
                  <table-column show="medicine_name" label="medicine name"/>
                  <table-column :formatter="formatPrice" show="price" label="medicine price"/>

                  <table-column :sortable="false" :filterable="false" label>
                    <template slot-scope="row">
                      <div class="table__actions">
                        <a v-b-popover.hover="'Remove'"
                           v-if="Delete == 1"
                           class="btn btn-warning btn-sm"
                           style="color:white !important"
                           data-delete
                           data-confirmation="notie"
                           @click="NoInDemand(row.id , type = 'medicine')"
                        >Remove from In-Demand
                        </a>
                      </div>
                    </template>
                  </table-column>
                </table-component>
              </div>
              <div v-else class="alert alert-info" role="alert">Sorry! you dont have permission</div>
            </div>
          </div>
        </div>
      </tab>

      <tab id="Equipments" name="Equipments">
        <tabs :options="{ useUrlFragment: false }" class="tabs-default">
          <tab id="normalEquipments" name="Purchase Equipments">
            <div class="row">
              <div class="col-sm-12 hide">
                <div class="card">
                  <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
              </div>-->
                  <div v-if="Read == 1" class="card-body">
                    <table-component
                      ref="allEquipmentInDemand"
                      :data="inDemandEqu"
                      sort-by="id"
                      sort-order="desc"
                      table-class="table"
                    >
                      <table-column show="id" label="equipment id"/>
                      <table-column
                        :sortable="false"
                        :filterable="false"
                        label="Photo"
                      >
                        <template slot-scope="row">
                          <div>
                            <img :src=" imageLink + row.image" height="100" @error="onImageLoadFailure($event)" >
                          </div>
                        </template>
                      </table-column>
                      <table-column show="equipment_name" label="equipment name"/>
                      <table-column :formatter="formatPrice" show="price" label="equipment price"/>

                      <table-column :sortable="false" :filterable="false" label>
                        <template slot-scope="row">
                          <div class="table__actions">
                            <a v-b-popover.hover="'Remove'"
                               v-if="Delete == 1"
                               class="btn btn-warning btn-sm"
                               style="color:white !important"
                               data-delete
                               data-confirmation="notie"
                               @click="NoInDemand(row.id , type = 'equipment')"
                            >Remove from In-Demand

                            </a>
                          </div>
                        </template>
                      </table-column>
                    </table-component>
                  </div>
                </div>

          </div></div></tab>
          <tab id="rentalEquipments" name="Rental Equipments">
            <div class="row">
              <div class="col-sm-12 hide">
                <div class="card">
                  <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
              </div>-->
                  <div v-if="Read == 1" class="card-body">
                    <table-component
                      ref="allEquipmentInDemand"
                      :data="inDemandRentalEqu"
                      sort-by="id"
                      sort-order="desc"
                      table-class="table"
                    >
                      <table-column show="id" label="equipment id"/>

                      <table-column :sortable="false" :filterable="false" label>
                        <template slot-scope="row">
                          <div class="table__actions">
                            <a v-b-popover.hover="'Remove'"
                               v-if="Delete == 1"
                               class="btn btn-warning btn-sm"
                               style="color:white !important"
                               data-delete
                               data-confirmation="notie"
                               @click="NoInDemand(row.id , type = 'equipment')"
                            >Remove from In-Demand

                            </a>
                          </div>
                        </template>
                      </table-column>
                    </table-component>
                  </div>
                </div>

          </div></div></tab>

        </tabs>

      </tab>
      <tab id="Tests" name="Tests">
        <div class="row">
          <div class="col-sm-12 hide">
            <div class="card">
              <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
              </div>-->
              <div v-if="Read == 1" class="card-body">
                <table-component
                  ref="allTestInDemand"
                  :data="inDemandTest"
                  sort-by="id"
                  sort-order="desc"
                  table-class="table"
                >
                  <table-column show="id" label="test id"/>
                  <table-column show="test_name" label="Test name"/>
                  <table-column :formatter="formatPrice" show="price" label="Test price"/>
                  <table-column label="Category">
                    <template slot-scope="row">
                      <div>
                        {{ row.test_category[0].category_name }}
                      </div>
                    </template>
                  </table-column>

                  <table-column :sortable="false" :filterable="false" label>
                    <template slot-scope="row">
                      <div class="table__actions">
                        <a v-b-popover.hover="'Remove'"
                           v-if="Delete == 1"
                           class="btn btn-warning btn-sm"
                           style="color:white !important"
                           data-delete
                           data-confirmation="notie"
                           @click="NoInDemand(row.id ,type = 'test')"
                        >Remove from In-Demand
                        </a>
                      </div>
                    </template>
                  </table-column>
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
import { imageLink } from '../../../helpers/constants'
import { Tabs, Tab } from 'vue-tabs-component'

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
      imageLink: imageLink,
      Read: '',
      Write: '',
      Delete: '',
      cities: []
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
    async inDemandMed ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/inDemandMed/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`
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
    async inDemandEqu ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/inDemandEqu/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}&is_rental=${0}`
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
    async inDemandRentalEqu ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/inDemandEqu/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}&is_rental=${1}`
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
    async inDemandTest ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/inDemandTest/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`
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

    NoInDemand (id, type) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {},
        submitCallback: function () {
          self.NoInDemandData(id, type)
        }
      })
    },
    async NoInDemandData (id, type) {
      try {
        let response = await window.axios.post('/api/admin/orders/inDemandRem', {id, type})
        window.toastr['success']('Removed From In-Demand Products', 'Success')
        this.$refs.allTestInDemand.refresh()
        this.$refs.allEquipmentInDemand.refresh()
        this.$refs.allMedicineInDemand.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    onImageLoadFailure (event) {
      event.target.src = this.imageLink + 'users/no-photo.jpg'
    }
  }
}
</script>
