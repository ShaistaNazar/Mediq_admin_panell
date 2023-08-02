<template>
  <div  class="main-content">
    <div class="page-header">
      <h3 class="page-title">Promotion</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Promotion</li>
      </ol>
    </div>  
    <div class="row">
      <div class="col-sm-5 hide">           
        <div class="card">
            
          <div class="card-body" v-if="Read == 1 && ifNull != false">
              <h4 for="inputUserName">Existing Promotion's Detail</h4>
             <div>
                         Promotion is already active <br> <b>{{percentage}}% Discount</b> for users who have minimum <b>{{order_ratio}}</b> order<span v-if="order_ratio > 1">s</span> in a week,<br>
                         Promotion was created  <br>Date : <b>{{created_at | formatter}}</b> <br> 
                         Time : <b>{{created_at | formatterTime}}</b> <br>
                         Promotion will automatically stop on <b>{{expiry | formatter}} at 12:00:00 AM </b> <br>
                         Total eligible Users: <b>{{total_users}}</b><br>
                         Promotion Code is: <b>{{code}}</b>
              </div>
          </div>
            <div v-else class="alert alert-info" role="alert">
                  No Promotion is Active
                          </div>
        </div>
      </div>

       <div class="col-sm-7" v-if="Read == 1 && alreadyPromotion != false">
        <div class="card">
          <div class="card-body">
            <form v-on:submit.prevent="submit">
                <h4 for="inputUserName">Start New Promotion</h4>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputUserName">Discount in percentage </label>
                  <input
                    id="inputUserName"
                    type="number"
                    min=0
                    class="form-control"
                    :class="{ 'is-invalid': $v.form.discount.$error }"
                    placeholder="Discount %"
                    v-model.trim="form.discount"
                    @input="$v.form.discount.$touch()"
                  />
                  <div v-if="$v.form.discount.$error">
                  <span v-if="!$v.form.discount.required" class="help-block help-block-error">
                    <p class="text-danger"> Discount % is required.</p> 
                  </span>
                </div>
                </div>

                <div class="form-group col-md-6">
                  <label for="inputUserName">For How many orders in a week ?</label>
                  <input
                    id="inputUser"
                    type="number"
                    min=0
                    class="form-control"
                    :class="{ 'is-invalid': $v.form.orders.$error }"
                    placeholder="How many orders"
                    v-model.trim="form.orders"
                    @input="$v.form.orders.$touch()"

                  />
                  <div v-if="$v.form.orders.$error">
                  <span v-if="!$v.form.orders.required" class="help-block help-block-error">
                    <p class="text-danger"> No of orders is required.</p> 
                  </span>
                </div>
                </div>

              </div>           

              <button
                type="submit"
                :disabled="$v.form.$invalid || buttonDisable==true"
                class="btn btn-primary"
              >{{form.submitBtn}}</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
      </div>
 <div v-else class="alert alert-info col-sm-6" role="alert">
                  One Promotion is already active, multiple promotions are not supported.<br> in case you want to start a promotion, you can wait for the promotion to end automatically on {{expiry | formatter}}
                  or you can <a class="stopPromotion" @click="destroyPromotion()"><b>" click here "</b></a> to stop it manually.
                          </div>

    </div>
  </div>
</template>



<script type="text/babel">
import Ls from "../../../services/ls"
import { TableComponent, TableColumn } from 'vue-table-component'
import { imageLink } from '../../../helpers/constants' 
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import moment from 'moment'; 
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";

export default {
  components: {
    TableComponent,
    TableColumn,
    // SweetModal,
    // SweetModalTab,
  },
  data () {
    return {
      buttonDisable: false,
      Read:"",
      Write:"",
      ifNull:true,
      Delete:"",
      percentage:"",
      created_at:"",
      order_ratio:"",
      alreadyPromotion:true,
      code:"",
      total_users:"",
      expiry:"",
      form:{
        discount:"",
        orders:"",
        submitBtn: "Start Promotion",
      }
    }
  },
  validations: {
    form: {
      discount: {
        required,
      },
      orders: {
        required,
      }
    }
  },

    filters: {
  formatter: function (value) {
    return moment(value).format("Do MMM YYYY");
  },
    formatterTime: function (value) {
    return moment(value).format("hh : mm a");
  },
},

mounted(){
    this.getServices();
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
}, 

  methods: {
        async submit() {
      try {
        this.buttonDisable = true
        this.$v.form.$touch();
        if(this.$v.form.$error) return;
        // alert(this.form.UID);
        let response = await window.axios.post("/api/admin/orders/promotion/add", {
          data: this.form
        });        
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        location.reload();
      } catch (error) {
        this.buttonDisable = false
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
        async endPromotion()
        {
            try{
                let response = await window.axios.post("/api/admin/orders/promotion/end");
                location.reload();
            }
            catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
        },
    async getServices () {

      try {
        // alert(this.alreadyPromotion)
        const response = await axios.get(`/api/admin/orders/promotion/get`)
        console.log(response)
            if(response.data == " " || response.data == "")
            {
                this.ifNull = false;            
            }
            else
            {
                this.percentage = response.data[0][0].percentage;
                if(this.percentage)
                {
                    this.alreadyPromotion = false;
                }
                this.created_at = response.data[0][0].created_at;
                this.order_ratio = response.data[0][0].order_ratio;
                this.code = response.data[0][0].code;
                this.total_users = response.data[2];
                this.expiry = response.data[1].date;
                
                // this.$refs.tablePro.refresh();
                // alert('7')
            }
            
      } catch (error) {
        if (error) {
          // window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    onImageLoadFailure (event) {
        event.target.src = this.imageLink + 'users/no-photo.jpg';     
    },

    // Block User 

       destroyPromotion (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {
         
        },
        submitCallback: function () {
          self.endPromotion()
        }
      })
    },

   destroyUser (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {
         
        },
        submitCallback: function () {
          self.destroyUserData(id)
        }
      })
    },
 
    async destroyUserData (id) {
      try {
        let response = await window.axios.delete('/api/admin/Services/' + id)
        this.users = response.data
        window.toastr['success']('Medicine Deleted', 'Success')
        this.$refs.allUsers.refresh();
        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
//  openprmodel(id) {

//    this.form.UID = id;
//       this.$refs.dark_html_modal_statuscomm.open();
//     },
    
  }
};
</script>
