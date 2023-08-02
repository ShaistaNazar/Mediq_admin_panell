<template>
  <div   class="main-content">
    <div class="page-header">
      <h3 class="page-title">Add Complaints</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/Complaint">
            <a>Complaints</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Add</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <form >
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputUserName">Complainer Phone</label>
                  <input
                    id="inputUserName"
                    type="number"
                    min=0
                    value=1000
                    class="form-control"
                    placeholder="Complainer Phone"
                    v-model.trim="form.phone"
                    :class="{ 'is-invalid': $v.form.phone.$error }"
                     @input="$v.form.phone.$touch()"
                  />
                  <div v-if="$v.form.phone.$error">
                    <span v-if="!$v.form.phone.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.phone.minLength" class="help-block help-block-error">
                      Medicine Name must have at least {{ $v.form.phone.$params.minLength.min }} letters.
                    </span>
                </div>
                </div>
                  
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputUserName">Complaint About</label>
                  <input
                    id="inputUserName"
                    type="text"
                    class="form-control"
                    placeholder="Complaint About"
                    v-model.trim="form.complaint_title"
                    :class="{ 'is-invalid': $v.form.complaint_title.$error }"
                     @input="$v.form.complaint_title.$touch()"
                  />
                  <div v-if="$v.form.complaint_title.$error">
                    <span v-if="!$v.form.complaint_title.required" class="help-block help-block-error">
                      Field is required
                    </span>
                </div>
                </div>
              </div>

              <div class="form-group">
                <label for="inputDescription">Complaint Description</label>
                <b-form-textarea
                  id="inputDescription"
                  type="text"
                  class="form-control"
                  rows="4"
                  max-rows="6"
                  placeholder="Complaint Description"
                  v-model.trim="form.complaint_description"
                ></b-form-textarea>
              </div>
              

              <button v-if="form.complaintId == 0"
              @click.prevent="submit"
                class="btn btn-primary"
                :disabled="$v.form.$invalid"
              >{{form.submitBtn}}</button>
              <button v-if="form.complaintId != 0"
                @click.prevent="update"
                class="btn btn-primary"
                :disabled="$v.form.$invalid"
              >Update</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <!-- <div class="form-group col-md-6">
                 
                    <img  @error="onImageLoadFailure($event)"  height="27" :src="imageLink + form.phone" />
                  </div> -->
      </div>
    </div>
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";
import DatePicker from 'vue2-datepicker'
import { imageLink } from '../../../helpers/constants' 
import Ls from "../../../services/ls";


export default {
     components: { 
        DatePicker,
       },

  data() {
    return {
      Read: "",
      Write: "",
      Delete: "",
      id:"",
      form: {
          complaintId:0,
          phone:92,
          complaint_title:"",
          complaint_description: "",
          submitBtn: "Submit",
      }
    };
  },
    validations: {
    form: {
      phone: {
        required,
        minLength: minLength(11)
      },
      complaint_title: {
        required,
      },
      complaint_description: {
        required,
      },
    } 
  },

  mounted() {
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
    this.getComplaint();
  },
  methods: {
    async submit() {
      try {
        let response = await window.axios.post(
          "/api/admin/UserComplaints/add",
          { data: this.form }
        );
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        this.$router.push("/complaint");
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
    async update() {
      try {
        let response = await window.axios.post(
          "/api/admin/UserComplaints/update",
          { data: this.form }
        );
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        this.$router.push("/Complaint");
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
       async getComplaint () {
         if(this.$route.params.complaintId){
         this.form.complaintId = this.$route.params.complaintId;
           try {
        const response = await axios.get(`/api/admin/UserComplaints/edit/${this.form.complaintId}`);        
      
        this.form.phone =  response.data.user_phone;
        this.form.complaint_title =  response.data.complaint_title;
        this.form.complaint_description =  response.data.complaint_description;

        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
         }
      
    },
    async cancel() {
      this.$router.push("/Complaint");
    },
  }
};
</script>
