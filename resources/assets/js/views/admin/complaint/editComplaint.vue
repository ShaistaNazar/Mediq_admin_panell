<template>
  <div   class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit Tests</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/Tests">
            <a>Tests</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <form v-on:submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputTestName">Test Name</label>
                  <input
                    id="inputTestName"
                    type="text"
                    class="form-control"
                    placeholder="User Name"
                    v-model.trim="form.test_name"
                    :class="{ 'is-invalid': $v.form.test_name.$error }"
                     @input="$v.form.test_name.$touch()"
                  />
                  <div v-if="$v.form.test_name.$error">
                    <span v-if="!$v.form.test_name.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.test_name.minLength" class="help-block help-block-error">
                      Test Name must have at least {{ $v.form.test_name.$params.minLength.min }} letters.
                    </span>
                </div>
                </div>
                  <div class="form-group col-md-6">
                  <label for="inputPrice">Price</label>
                  <input
                    id="inputPrice"
                    type="number"
                    min=0
                    class="form-control"
                    placeholder="Price"
                    v-model.trim="form.price"
                    :class="{ 'is-invalid': $v.form.price.$error }"
                     @input="$v.form.price.$touch()"
                  />
                  <div v-if="$v.form.price.$error">
                    <span v-if="!$v.form.price.required" class="help-block help-block-error">
                      Field is required
                    </span>
                </div>
                </div>
              </div>


                <div class="form-row">
                  <div class="form-group col-md-6">
                  <label for="inputCategory">Select Category</label>
                  <select  id="inputCategory" class="form-control" placeholder="Select City" v-model.trim="form.testcategory_id">
                       <option disabled value>Categories</option>
                     <option
                        v-for="OneCat in category"
                        :key="OneCat"
                        v-bind:value="OneCat.id"
                        > {{OneCat.category_name}}
                     </option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputLab">Select Lab</label>
                  <select  id="inputLab" class="form-control" placeholder="Select Lab" v-model.trim="form.selectedLab">
                       <option disabled value>Laboratories</option>
                     <option
                        v-for="OneLab in form.lab"
                        :key="OneLab"
                        v-bind:value="OneLab.id"
                        > {{OneLab.lab_name}}
                     </option>
                  </select>
                </div>
                                     
              </div>
              <div class="form-group col-md-12 hide toggleMed">
                  <label >Prescription Required ?</label>
                  <toggle-button 
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    class="toggleStyle"
                    v-model.trim="form.is_prescription_req"
                  />
                </div>
              <div class="form-group">
                <label for="inputDescription">Description</label>
                <b-form-textarea
                  id="inputDescription"
                  type="text"
                  class="form-control"
                  rows="3"
                  max-rows="6"
                  placeholder="Description"
                  v-model.trim="form.Description"
                ></b-form-textarea>
              </div>

              <button
                type="submit"
                class="btn btn-primary"
                :disabled="$v.form.$invalid"
              >{{form.submitBtn}}</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
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
  data() {
    return {
      Read: "",
      Write: "",
      Delete: "",
      form: {
          id:"",
          test_name:"",
          price:"",
          is_prescription_req:"",
          testcategory_id:"",
          selectedLab: "",
          submitBtn: "Submit",
          Description: "",
          lab: ""
      },
          category:"",
    };
  },
    validations: {
    form: {
      test_name: {
        required,
        minLength: minLength(2)
      },
      price: {
        required,
        minLength: minLength(2)
      },
    //   Category:{
    //     required,
    //   }
    } 
  },

  mounted() {
    this.testCatDropdown();
    this.LabDropdown();
    this.getTest();
    this.Read = Ls.get("auth.permissionsRead");
        this.Write = Ls.get("auth.permissionsWrite");
        this.Delete = Ls.get("auth.permissionsDelete");
  },
  methods: {
    async submit() {
      this.$v.form.$touch();
        if(this.$v.form.$error) return;
      try {
        this.form.id = this.$route.params.TestsId;
        let response = await window.axios.post(
          "/api/admin/Tests/update",
          { data: this.form }
        );
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        this.$router.push("/Tests");
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
         async getTest () {
      try {
        let TestsId = this.$route.params.TestsId;
        const response = await axios.get(`/api/admin/Tests/edit/${TestsId}`);        
      
        this.form.test_name =  response.data.test_name;
        this.form.price =  response.data.price;
        this.form.is_prescription_req =  Boolean(response.data.is_prescription_req);
        this.form.testcategory_id =  response.data.testcategory_id;
        this.form.Description =  response.data.description;
        this.form.id =  response.data.id;
        this.form.selectedLab = response.data.lab_id;

        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async cancel() {
      this.$router.push("/Tests");
    },
       async testCatDropdown() {
      try {
        const response = await axios.get(
          `/api/admin/TestsCategory/get`
        );
        this.category = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async LabDropdown() {
      try {
        const response = await axios.get(
          `/api/admin/Laboratories/dropdown/get`
        );
        this.form.lab = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },

    changeValue(index) {
      this.form.permissions[index].enable = true;
    }
  }
};
</script>
