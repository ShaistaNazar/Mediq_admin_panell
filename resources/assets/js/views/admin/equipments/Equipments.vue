<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Equipments</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Equipments</li>
      </ol>
      <div class="page-actions">
        <router-link v-if="Write == 1" to="/Equipments/add">
          <a href="/Equipments/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus"/> Add New Equipment
          </a>
        </router-link>
      </div>
    </div>
    <tabs :options="{ useUrlFragment: false }" class="tabs-default">
      <tab id="equipments" name="Equipments">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">

              <div v-if="Read == 1" class="card-body">
                <table-component
                  ref="allUsers"
                  :data="getEquipments"
                  sort-by="id"
                  sort-order="desc"
                  table-class="table"
                  class="equipments"
                >
                  <table-column
                    :sortable="false"
                    :filterable="false"
                    label="Photo"
                  >
                    <template slot-scope="row">
                      <div class="equipment-mg">
                        <img :src=" imageLink + row.image" width="100" @error="onImageLoadFailure($event)" >
                      </div>
                    </template>
                  </table-column>

                  <table-column show="equipment_name" label="Equipment Name"/>
                  <table-column :formatter="formatPrice" show="price" label="price"/>
                  <table-column show="brand" label="Brand"/>

                  <table-column
                    :formatter="formatter"
                    show="created_at"
                    label="Registered On"
                    data-type="date:YYYY-MM-DD"
                  />

                  <table-column
                    :sortable="false"
                    :filterable="false"
                    label="Actions"
                  >
                    <template slot-scope="row">
                      <div class="table__actions">
                        <router-link v-if="Write == 1" :to="{ name: 'editEquipments', params: { EquipmentsId: row.id }}"><a v-b-popover.hover ="'EDIT'"
                                                                                                                            class="btn btn-default btn-sm">
                          <i class="icon-fa icon-fa-pencil"/>
                        </a>
                        </router-link>

                        <!-- <div> -->
                        <a v-if="Delete == 1"
                           v-b-popover.
                             ="'DELETE'"
                           class="btn btn-default btn-sm"
                           data-delete
                           data-confirmation="notie"
                           @click="destroyUser(row.id)"
                        >
                          <i class="icon-fa icon-fa-trash"/>
                        </a>

                        <!-- </div>     -->
                        <div v-if="row.in_demand == 0" class="float-right">
                          <a
                            v-b-popover.hover="'Add To In-demand'"
                            class="btn btn-warning btn-sm "
                            data-confirmation="notie"
                            style="color:white !important"
                            @click="AddInDemand(row.id , type = 'equipment')"
                          >Add to In-Demand
                          </a>
                        </div>
                        <div v-else style="color:white !important" class="btn btn-success btn-sm">Already In-Demand</div>
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
      </tab>
      <tab id="rental-equipments" name="Rental Equipments">

        <div class="row">
          <div class="col-sm-12">
            <div class="card">

              <div v-if="Read == 1" class="card-body">
                <table-component
                  ref="allUsers"
                  :data="getRentalEquipments"
                  sort-by="id"
                  sort-order="desc"
                  table-class="table"
                  class="equipments"
                >

                  <table-column show="equipment_name" label="Equipment Name"/>

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
                        <router-link v-if="Write == 1" :to="{ name: 'editEquipments', params: { EquipmentsId: row.id }}"><a v-b-popover.hover ="'EDIT'"
                                                                                                                            class="btn btn-default btn-sm">
                          <i class="icon-fa icon-fa-pencil"/>
                        </a>
                        </router-link>

                        <!-- <div> -->
                        <a v-if="Delete == 1"
                           v-b-popover.
                             ="'DELETE'"
                           class="btn btn-default btn-sm"
                           data-delete
                           data-confirmation="notie"
                           @click="destroyUser(row.id)"
                        >
                          <i class="icon-fa icon-fa-trash"/>
                        </a>

                        <div v-if="row.in_demand == 0" class="float-right">
                          <a
                            v-b-popover.hover="'Add To In-demand'"
                            class="btn btn-warning btn-sm "
                            style="color:white !important"
                            data-confirmation="notie"
                            @click="AddInDemand(row.id , type = 'equipment')"
                          >Add to In-Demand
                          </a>
                        </div>
                        <div v-else style="color:white !important" class="btn btn-success btn-sm">Already In-Demand</div>
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
      </tab>
    </tabs>

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
import { Tabs, Tab } from 'vue-tabs-component'

import { required, sameAs, minLength, between } from 'vuelidate/lib/validators'
// import { SweetModal, SweetModalTab } from "sweet-modal-vue";

export default {
  components: {
    TableComponent,
    TableColumn,
    tabs: Tabs,
    tab: Tab
    // SweetModal,
    // SweetModalTab,
  },
  data () {
    return {
      imageLink: imageLink,
      Read: '',
      Write: '',
      Delete: '',
      form: {
        submitBtn: 'Update',
        lab_name: ''
      }
    }
  },
  validations: {
    form: {
      lab_name: {
        required,
        minLength: minLength(4)
      }
    }
  },
  mounted () {
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },

  methods: {
    formatPrice(value) {
        let val = (value/1).toFixed(2).replace(',', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
    async submit () {
      try {
        this.$v.form.$touch()
        if (this.$v.form.$error) return
        let response = await window.axios.post('/api/admin/Equipments/add', {
          data: this.form
        })
        window.toastr['success'](
          response,
          'Success'
        )
        this.$refs.allUsers.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response,
            'Error'
          )
        }
      }
    },
    formatter (value, rowProperties) {
      return moment(value).format('Do MMM YYYY')
    },

    async getEquipments ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/Equipments/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}&is_rental=${0}`
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
    async getRentalEquipments ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/Equipments/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}&is_rental=${1}`
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
    onImageLoadFailure (event) {
      event.target.src = this.imageLink + 'equipmentImg/equipmets-icon.jpg'
    },

    destroyUser (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {},
        submitCallback: function () {
          self.destroyUserData(id)
        }
      })
    },

    async destroyUserData (id) {
      try {
        let response = await window.axios.delete('/api/admin/Equipments/' + id)
        this.users = response.data
        window.toastr['success']('Equipment Deleted', 'Success')
        this.$refs.allUsers.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    AddInDemand (id, type) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {},
        submitCallback: function () {
          self.AddInDemandData(id, type)
        }
      })
    },
    async AddInDemandData (id, type) {
      try {
        let response = await window.axios.post('/api/admin/orders/inDemandAdd', {id, type})
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.$refs.allUsers.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    }

    //  openprmodel(id) {

    //    this.form.UID = id;
    //       this.$refs.dark_html_modal_statuscomm.open();
    //     },
  }
}
</script>
