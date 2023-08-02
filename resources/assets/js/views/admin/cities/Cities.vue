<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Cities</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Cities</li>
      </ol>
      <div  v-if="Delete == 1" class="page-actions">
        <router-link to="/cities/add">
          <a href="/cities/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus" /> New City
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
              :data="getCities"
              sort-by="id"
              sort-order="desc"
              table-class="table"
            >
              <table-column show="id" label="No" />
              <table-column show="city_name" label="City Name" />
              <table-column show="province" label="Province" />

              <table-column v-if="Write == 1 || Delete == 1" :sortable="false" :filterable="false" label>
                <template slot-scope="row">
                  <div class="table__actions">
                    <!-- <router-link :to="{ name: 'editcity', params: { cityId: row.id }}">
                      <a v-b-popover.hover="'EDIT'" class="btn btn-default btn-sm">
                        <i class="icon-fa icon-fa-pencil" />
                      </a>
                    </router-link> -->
                    <a v-b-popover.hover="'Remove city to App'"
                       v-if="row.is_show == 1"
                       class="btn btn-default btn-sm"
                       @click="cityToShow(row.id,0)"
                    >
                      <i class="icon-fa icon-fa-minus-circle" style="color:red;font-size: 23px;"/>
                    </a>
                    <a v-b-popover.hover="'Add city from App'"
                       v-else
                       class="btn btn-default btn-sm"
                       @click="cityToShow(row.id,1)"
                    >
                      <i class="icon-fa icon-fa-plus-circle" style="color:green;font-size: 23px;" />
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
      cities: []
    }
  },
  mounted () {
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },
  methods: {
    async getCities ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/cities/get?page=${page}&filter=${filter}`
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
        let response = await window.axios.delete('/api/admin/cities/' + id)
        this.cities = response.data
        window.toastr['success']('City Delete Successfully!', 'Success')
        this.$refs.city.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    cityToShow (id, val) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {},
        submitCallback: function () {
          self.cityToShowData(id, val)
        }
      })
    },
    async cityToShowData (id, val) {
      try {
        let response = await window.axios.post(`/api/admin/cities/status?city=${id}&status=${val}`)
        this.cities = response.data
        window.toastr['success']('City Deleted', 'Success')
        this.$refs.city.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    }
  }
}
</script>
