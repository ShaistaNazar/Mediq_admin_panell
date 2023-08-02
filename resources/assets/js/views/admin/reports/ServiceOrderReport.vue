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
     <tabs  :options="{ useUrlFragment: false }" class="tabs-default">
    <!--------------------- Completed -------------------->
   <tab id="completed" name="Completed Orders">
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card border">
          <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
          </div>-->
          <div class="card-body" v-if="Read == 1">
            <table-component
              :data="getCompletedHM_Service"
              sort-by="id"
              sort-order="desc"
              table-class="table"
              ref="city"
            >
               <table-column label="Order For" >
                   <template slot-scope="row">
                     
                       <div v-if="row.by_admin == 1">
                           <b>Ordered For: {{row.order_for}} | Ordered by: {{row.users.full_name}} </b>
                       </div>
                       <div v-else>
                           <b>{{row.users.full_name}} | {{row.users.phone}}</b>
                       </div>
                   </template>
               </table-column>

               <table-column label="Service Selected" >
                   <template slot-scope="row">
                       <div v-if="row.services.length != 0">
                           <b>{{row.services[0].service_name}}</b>
                       </div>
                       <div v-else>Not Selected Yet</div>
                   </template>
               </table-column>


                <table-column label="Source" >
                   <template slot-scope="row">
                     
                       <div v-if="row.by_admin == 1" class="text-success">
                           <b>Admin Panel </b>
                       </div>
                       <div v-else class="text-danger">
                           <b>Mobile App</b>
                       </div>
                   </template>
               </table-column>
               <table-column label="Status" >
                   <template slot-scope="row">
                       <div v-if="row.status == 1" class="text-danger">
                           <b>Cancelled</b>
                       </div>
                       <div v-if="row.status == 3" class="text-warning">
                           <b>Not Paid</b>
                       </div>
                       <div v-if="row.status == 2" class="text-info">
                           <b>Paid</b>
                       </div>                       
                       <div v-if="row.status == 4" class="text-success">
                           <b>Paid & Completed</b>
                       </div>
                   </template>
               </table-column>
               <table-column label="Provider Selected" >
                   <template slot-scope="row">
                       <div v-if="row.provider_id != 0">
                           <b>{{row.providers.full_name}} | {{row.providers.phone}}</b>
                       </div>
                       <div v-else>Not Selected Yet</div>
                   </template>
               </table-column>
              <table-column
                show="created_at"
                label="Order Date"
                data-type="date:YYYY-MM-DD"
                :formatter="formatter"
              />

             
            </table-component>
          </div>
          <div v-else class="alert alert-info" role="alert">Sorry! you dont have permission</div>
        </div>
      </div>
    </div>
    </tab>
    <!--------------------- Pending -------------------->
   <tab id="Pending" name="Pending Orders">
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card border">
          <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
          </div>-->
          <div class="card-body" v-if="Read == 1">
            <table-component
              :data="getPendingHM_Service"
              sort-by="id"
              sort-order="desc"
              table-class="table"
              ref="city"
            >
               <table-column label="Order For" >
                   <template slot-scope="row">
                     
                       <div v-if="row.by_admin == 1">
                           <b>Ordered For: {{row.order_for}} | Ordered by: {{row.users.full_name}} </b>
                       </div>
                       <div v-else>
                           <b>{{row.users.full_name}} | {{row.users.phone}}</b>
                       </div>
                   </template>
               </table-column>

               <table-column label="Service Selected" >
                   <template slot-scope="row">
                       <div v-if="row.services.length != 0">
                           <b>{{row.services[0].service_name}}</b>
                       </div>
                       <div v-else>Not Selected Yet</div>
                   </template>
               </table-column>


                <table-column label="Source" >
                   <template slot-scope="row">
                     
                       <div v-if="row.by_admin == 1" class="text-success">
                           <b>Admin Panel </b>
                       </div>
                       <div v-else class="text-danger">
                           <b>Mobile App</b>
                       </div>
                   </template>
               </table-column>
               <table-column label="Status" >
                   <template slot-scope="row">
                       <div v-if="row.status == 1" class="text-danger">
                           <b>Cancelled</b>
                       </div>
                       <div v-if="row.status == 3" class="text-warning">
                           <b>Not Paid</b>
                       </div>
                       <div v-if="row.status == 2" class="text-info">
                           <b>Paid</b>
                       </div>                       
                       <div v-if="row.status == 4" class="text-success">
                           <b>Paid & Completed</b>
                       </div>
                   </template>
               </table-column>
               <table-column label="Provider Selected" >
                   <template slot-scope="row">
                       <div v-if="row.provider_id != 0 && row.provider_id != null && row.providers != null">
                           <b>{{row.providers.full_name}} | {{row.providers.phone}}</b>
                       </div>
                       <div v-else>Not Selected Yet</div>
                   </template>
               </table-column>
              <table-column
                show="created_at"
                label="Order Date"
                data-type="date:YYYY-MM-DD"
                :formatter="formatter"
              />

             
            </table-component>
          </div>
          <div v-else class="alert alert-info" role="alert">Sorry! you dont have permission</div>
        </div>
      </div>
    </div>
    </tab>
    <!--------------------- Cancelled -------------------->
   <tab id="Cancelled" name="Cancelled Orders">
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card border">
          <!-- <div class="card-header">
            <h6>All Existing Cities in Database</h6>
            <div class="card-actions" />
          </div>-->
          <div class="card-body" v-if="Read == 1">
            <table-component
              :data="getCancelledHM_Service"
              sort-by="id"
              sort-order="desc"
              table-class="table"
              ref="city"
            >
               <table-column label="Order For" >
                   <template slot-scope="row">
                     
                       <div v-if="row.by_admin == 1">
                           <b>Ordered For: {{row.order_for}} | Ordered by: {{row.users.full_name}} </b>
                       </div>
                       <div v-else>
                           <b>{{row.users.full_name}} | {{row.users.phone}}</b>
                       </div>
                   </template>
               </table-column>

               <table-column label="Service Selected" >
                   <template slot-scope="row">
                       <div v-if="row.services.length != 0">
                           <b>{{row.services[0].service_name}}</b>
                       </div>
                       <div v-else>Not Selected Yet</div>
                   </template>
               </table-column>


                <table-column label="Source" >
                   <template slot-scope="row">
                     
                       <div v-if="row.by_admin == 1" class="text-success">
                           <b>Admin Panel </b>
                       </div>
                       <div v-else class="text-danger">
                           <b>Mobile App</b>
                       </div>
                   </template>
               </table-column>
               <table-column label="Status" >
                   <template slot-scope="row">
                       <div v-if="row.status == 1" class="text-danger">
                           <b>Cancelled</b>
                       </div>
                       <div v-if="row.status == 3" class="text-warning">
                           <b>Not Paid</b>
                       </div>
                       <div v-if="row.status == 2" class="text-info">
                           <b>Paid</b>
                       </div>                       
                       <div v-if="row.status == 4" class="text-success">
                           <b>Paid & Completed</b>
                       </div>
                   </template>
               </table-column>
               <table-column label="Provider Selected" >
                   <template slot-scope="row">
                       <div v-if="row.provider_id != 0">
                           <b>{{row.providers.full_name}} | {{row.providers.phone}}</b>
                       </div>
                       <div v-else>Not Selected Yet</div>
                   </template>
               </table-column>
              <table-column
                show="created_at"
                label="Order Date"
                data-type="date:YYYY-MM-DD"
                :formatter="formatter"
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
import { TableComponent, TableColumn } from "vue-table-component";
import Vue from "vue";
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import Ls from "../../../services/ls";
import moment from 'moment'; 
import { SweetModal, SweetModalTab } from "sweet-modal-vue";
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";
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
      Read: "",
      comments:"",
      Write: "",
      Delete: "",
      services:"",
      submitBtn: "Submit",
      form:{
        SelectedProvider:"",
        orderId:0,
      }
    };
  },
   validations: {
    form: {
      SelectedProvider: {
        required,
      },
    } 
  },
  mounted() {
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
  },
  methods: {
      
    async getCompletedHM_Service({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/serviceOrders/get?page=${page}&filter=${filter}&completed=${1}&sortcol=${sort.fieldName}&sort=${sort.order}`
        );

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
    async getPendingHM_Service({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/serviceOrders/get?page=${page}&filter=${filter}&pending=${1}&sortcol=${sort.fieldName}&sort=${sort.order}`
        );

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
    async getCancelledHM_Service({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/serviceOrders/get?page=${page}&filter=${filter}&cancelled=${1}&sortcol=${sort.fieldName}&sort=${sort.order}`
        );

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
      formatter(value, rowProperties) {
            return  moment(value).format('Do MMM YYYY, hh : mm a');
    },   

  }
};
</script>
