<template>
  <div  class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit Medicine</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/MiscellaneousMedicines">
            <a>Miscellaneous Medicines</a>
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
                  <label for="inputUserName">Medicine Name</label>
                  <input
                    id="inputUserName"
                    type="text"
                    class="form-control"
                    placeholder="User Name"
                    v-model.trim="form.medicine_name"
                    :class="{ 'is-invalid': $v.form.medicine_name.$error }"
                    @input="$v.form.medicine_name.$touch()"
                  />
                
                </div>
                <div class="form-group col-md-6">
                  <label for="inputUserName">Price</label>
                  <input
                    id="inputUserName"
                    type="number"
                    class="form-control"
                    placeholder="Price"
                    v-model.trim="form.price"
                    :class="{ 'is-invalid': $v.form.price.$error }"
                    @input="$v.form.price.$touch()"
                  />
                 
                </div>
              </div>

              

              <div class="form-row">
                

                <div class="form-group col-4 hide toggleMed">
                  <label style="width:100%">Prescription Required?</label>
                  <toggle-button
                    :value="form.is_prescription_req"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    class="toggleStyle"
                    style="float:left"
                    v-model.trim="form.is_prescription_req"
                  />
                </div>
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
      <div class="col-sm-6">
        <!-- <div class="form-group col-md-6">
                 
                    <img  @error="onImageLoadFailure($event)"  height="27" :src="imageLink + form.medicine_image" />
        </div>-->
      </div>
    </div>
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";
import DatePicker from "vue2-datepicker";
import { imageLink } from "../../../helpers/constants";
import Ls from "../../../services/ls"

export default {
  components: {
    DatePicker
  },

  data() {
    return {
      Read: "",
      Write: "",
      Delete: "",
      category: "",
      form: {
        id: "",
        medicine_name: "",
        is_prescription_req: "",
        price: "",
        status: "",
        submitBtn: "Submit"
      }
    };
  },

  validations: {
    form: {
      medicine_name: {
        required,
        minLength: minLength(2)
      },
      price: {
        required
      },
     
    }
  },

  mounted() {
    this.getMedicine();
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
  },
  methods: {
    async submit() {
      try {
        this.$v.form.$touch();
        if (this.$v.form.$error) return;
        let response = await window.axios.post("/api/admin/medicines/updateMiscellaneous", {
          data: this.form
        });
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        this.id = response.data.ResponseHeader.id;
        
        this.$router.push("/MiscellaneousMedicines");
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
    async cancel() {
      this.$router.push("/employees");
    },
    async getMedicine() {
      try {
        this.form.id = this.$route.params.mMedId;
        const response = await axios.get(`/api/admin/medicines/editMiscellaneous/${this.form.id}`);
        this.form.medicine_name = response.data.medicine_name;
        this.form.price = response.data.price;
        this.form.is_prescription_req = response.data.is_prescription_req;
        
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },

    
   
  }
};
</script>
