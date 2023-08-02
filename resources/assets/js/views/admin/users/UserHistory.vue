<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">User's Package's History</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">History</li>
      </ol>
      
    </div>
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          
          <div class="card-body">
            <table-component
              :data="getUsers"
              sort-by="id"
              sort-order="desc"
              table-class="table"
              ref="userHistory"
            >
            <table-column  label="User Name">
              <template slot-scope="row">
                <div>
                 {{row.users[0].user_name}}
                </div>
              </template>
            </table-column>
      
            <table-column show="package_price" label="Price Paid"/>

               <table-column label="Packages">
              <template slot-scope="row">
                <div v-if="row.is_active == 1" class="currentPkg">{{row.name}}Current Package</div>
                <div v-else>Not in Use</div>
              </template>
            </table-column>

             <table-column label="Packages">
              <template slot-scope="row">
              <div class="currentPkg">
                 {{row.packages[0].name}}
                </div>
              </template>
            </table-column>

            
            
            <table-column
              show="created_at"
              label="Registered On"
              data-type="date:YYYY-MM-DD"
              :formatter="formatter"
            />
             
            </table-component>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script type="text/babel">
import { TableComponent, TableColumn } from 'vue-table-component'
import {imageLink} from '../../../helpers/constants' 
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import moment from 'moment'; 

export default {
  components: {
    TableComponent,
    TableColumn
  },
  data () {
    return {
      users: [],
     name: response.data.data[0].users[0].user_name
    }
  },
 

  methods: {
    formatter(value, rowProperties) {
            return  moment(value).format('Do MMM YYYY');
    },
    async getUsers ({ page, filter, sort }) {

      try {
         
        let userID = this.$route.params.userId ;
        const response = await axios.get(`/api/admin/history/get/` + userID)

        // name = response.data.data[0].users[0].user_name;
        // alert(name);
        return {
          data: response.data.data,
          name:response.data.data[0].users[0].user_name,
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
        event.target.src = this.imagelink + 'users/no-photo.jpg';     
    },
    // destroyUser (id) {
    //   let self = this
    //   window.notie.confirm({
    //     text: 'Are you sure?',
    //     cancelCallback: function () {
         
    //     },
    //     submitCallback: function () {
    //       self.destroyUserData(id)
    //     }
    //   })
    // },
 
    // async destroyUserData (id) {
    //   try {
    //     let response = await window.axios.delete('/api/admin/users/' + id)
    //     this.users = response.data
    //     window.toastr['success']('User Deleted', 'Success')
    //     location.reload()
    //     } catch (error) {
    //     if (error) {
    //       window.toastr['error']('There was an error', 'Error')
    //     }
    //   }
    // },


   blockUser (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {
          window.toastr['info']('Cancel')
        },
        submitCallback: function () {
          self.blockUserData(id)
        }
      })
    },
    async blockUserData (id) {
      try {
        let response = await window.axios.put('/api/admin/users/' + id)
        this.users = response.data
        window.toastr['success']('User Blocked', 'Success')
        this.$refs.userHistory.refresh();
        // location.reload()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

     unblockUser (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {
          window.toastr['info']('Cancel')
        },
        submitCallback: function () {
          self.unblockUserData(id)
        }
      })
    },
    async unblockUserData (id) {
      try {
        let response = await window.axios.put('/api/admin/users/unblock/' + id)
        this.users = response.data
        window.toastr['success']('User Blocked', 'Success')
        this.$refs.userHistory.refresh();
        // location.reload()
       } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    
  }
}
</script>
