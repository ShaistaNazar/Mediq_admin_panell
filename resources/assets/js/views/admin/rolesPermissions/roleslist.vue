<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Roles List</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Roles</li>
      </ol>
   
    </div>
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <div class="card-body"  v-if="Read == 1">
            <table-component :data="getRoles" sort-by="row.id" sort-order="desc" table-class="table">

              <table-column :sortable="false" :filterable="false" label="User Name">
               <template slot-scope="row">
                 <div>
                   <router-link
                     :to="{ name: 'viewprofile', params: { userId: row.employees_nmaes[0].id }}"
                     class="user-color"
                     v-b-popover.hover="'View Profile'"
                   >{{row.employees_nmaes[0].full_name}}</router-link>
                 </div>
               </template>
             </table-column>
      
               <table-column label="Can Read">
                <template slot-scope="row">
                  <div class="cms-description">
                    <div v-if="row.Read == 1">
                        <i class="icon-fa icon-fa-check"/>
                    </div>
                    <div v-else>
                       <i class="icon-fa icon-fa-times"/>
                    </div>
                    </div>              
                </template>
              </table-column>

               <table-column label="Can Write">
                <template slot-scope="row">
                  <div class="cms-description">
                    <div v-if="row.Write == 1">
                        <i class="icon-fa icon-fa-check"/>
                    </div>
                    <div v-else>
                       <i class="icon-fa icon-fa-times"/>
                    </div>
                    </div>               
                </template>
              </table-column>

              <table-column label="Can Delete">
                <template slot-scope="row">
                  <div class="cms-description" >
                    <div v-if="row.Delete == 1">
                        <i class="icon-fa icon-fa-check"/>
                    </div>
                    <div v-else>
                       <i class="icon-fa icon-fa-times"/>
                    </div>
                    </div>                 
                </template>
              </table-column>
              <!-- <table-column :sortable="false" :filterable="false" label="Action">
                <template slot-scope="row">
                  <div class="table__actions">
                    <router-link :to="{ name: 'editrole', params: { roleId: row.id }}"><a v-b-popover.hover="'EDIT'" 
                      class="btn btn-default btn-sm">
                        <i class="icon-fa icon-fa-pencil"
                        
                        />
                      </a>
                    </router-link>  
                    <a
                      v-b-popover.hover="'DELETE'"
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="destroyRole(row.id)"
                     
                    >
                      <i class="icon-fa icon-fa-trash"/>
                    </a>
                  </div>
                </template>
              </table-column> -->
            </table-component>
            
          </div>
       <div v-else class="alert alert-info" role="alert">
                  Sorry! you dont have permission
                          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="https://vuejs.org/js/vue.min.js"></script>
<script type="text/babel">

import { TableComponent, TableColumn } from "vue-table-component";
import Vue from "vue";
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import Ls from "../../../services/ls"

import { SweetModal, SweetModalTab } from "sweet-modal-vue";
import { Tabs, Tab } from "vue-tabs-component";

Vue.use(BootstrapVue);

export default {
  components: {
    TableComponent,
    TableColumn,
    SweetModal,
    SweetModalTab,
    tabs: Tabs,
    tab: Tab
  },

  data() {
    return {
        Read:"",
      Write:"",
      Delete:"",
      form: {}
    };
  },
  mounted(){
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
  },
  methods: {
      async getAuthUser() {
          try {
          let response = await window.axios.get('/api/admin/employees/authuser');
          this.auth_user=response.data;
          } catch (error) {
          if (error) {
            window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
          }
        }
      },
    async getRoles({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/roles/PermissionsList/get`
        );
         // this.roles=response.data.data;
         // console.log(this.roles);
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
    async getCurrentUserRoles() {
      try {
        const response = await axios.get(
          `/api/admin/roles/currentUserRole`
        );
         this.roles=response.data;
         // console.log(this.roles);
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },


    destroyRole(id) {
      let self = this;
      window.notie.confirm({
        text: "Are you sure?",
        cancelCallback: function() {},
        submitCallback: function() {
          self.destroyRoleData(id);
        }
      });
    },
    async destroyRoleData(id) {
      try {
        let response = await window.axios.delete("/api/admin/roles/" + id);
        this.cms = response.data;
        window.toastr["success"]("Role Deleted", "Success");
        location.reload();
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },

  }
};
</script>
