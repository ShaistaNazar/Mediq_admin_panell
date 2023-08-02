<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Deactivated Users</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">All Deactivated Users</li>
      </ol>
       <div class="page-actions">
        <router-link to="/users">
          <a href="/users" class="btn btn-primary">
            <i class="icon-fa icon-fa-minus"/> All Users
          </a>
        </router-link>
         <!-- <router-link to="/features">
          <a href="/features" class="btn btn-primary">
            <i class="icon-fa icon-fa-eye"/> Features
          </a>
        </router-link> -->
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <div class="card-body">
            <table-component
              :data="getAllDeactive"
              sort-by="id"
              sort-order="desc"
              table-class="table"
              ref="refresh"
            >
              <table-column
                :sortable="false"
                :filterable="false"
                label="User Name"
              >
                <template slot-scope="row">
                  {{row.deactive_users[0].user_name}} 
                </template>
              </table-column>

               <table-column
                :sortable="false"
                :filterable="false"
                label="Reason for Deactivation"
              >
                <template slot-scope="row">
                  {{row.reason}} 
                </template>
              </table-column>

              <table-column
                show="created_at"
                label="Deactivated On"
                data-type="date:YYYY-MM-DD"
                :formatter="formatter"
              />

              <table-column
                :sortable="false"
                :filterable="false"
                label="Actions"
              >
                <template slot-scope="row">
                    <div>
                    <a
                     v-b-popover.hover ="'Activate User'"
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="activateUser(row.user_id)"
                    >
                      <i class="icon-fa icon-fa-check"/> 
                    </a>
                    </div>
                </template>
              </table-column>

            </table-component>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import { TableComponent, TableColumn } from "vue-table-component";
import Vue from "vue";
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import moment from "moment";


Vue.use(BootstrapVue);

export default {
  components: {
    TableComponent,
    TableColumn,
  },

  data() {
    return {};
  },

  methods: {
       formatter(value, rowProperties) {
      return moment(value).format("Do MMM YYYY");
    },
    async getAllDeactive({ page, filter }) {
      try {
        const response = await axios.get(`/api/admin/users/deactive?page=${page}&filter=${filter}`);
        return {
          data: response.data.data,
          pagination: {
            totalPages: response.data.last_page,
            currentPage: page,
            count: response.data.count
          }
        };
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
        activateUser (user_id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {
          window.toastr['info']('Cancel')
        },
        submitCallback: function () {
          self.statusUserDataUnAct(user_id)
        }
      })
    },
    async statusUserDataUnAct (user_id) {
      try {
        let response = await window.axios.post('/api/admin/users/deActivate_activate/' + user_id)
        this.users = response.data
        window.toastr['success']('User Activated', 'Success')
        this.$refs.refresh.refresh();
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
  }
};
</script>
