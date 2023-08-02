<template>
  <div  class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit Laboratory</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/Laboratories"><a>Laboratories</a></router-link></li>
        <li class="breadcrumb-item active">Edit Laboratory</li>
        </ol>
    </div>
    <div class="row">
      <div class="col-sm-6 hide">
        <div class="card">
          <!-- <div class="card-header">
            <h6>Edit the Name of City </h6>
          </div> -->
          <div class="card-body">
            <form  v-on:submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputFirstName">Laboratory Name</label>
                  <input
                    id="inputCityName"
                    type="text"
                    class="form-control"
                    placeholder="Laboratory Name"
                    :class="{ 'is-invalid': $v.form.lab_name.$error }"
                    v-model.trim="form.lab_name"
                    @input="$v.form.lab_name.$touch()"
                  >
                 </div>
             </div>
                  
              <button type="submit" class="btn btn-primary" :disabled="$v.form.$invalid" >{{form.submitBtn}}</button>
                   <b-button type=button @click.prevent="cancel" >Cancel</b-button>

            </form>
          </div>
        </div>
      </div>

          <div class="col-6 hide">
          <div class="card">
            <div class="card-body formDesign">
              <div class="form-row border-bottom">
                <div class="form-group col-6 hide">Category Name</div>
                <div class="form-group col-6 hide text-center">Enable/Disable</div>
              </div>

            <div class="form-row" v-for="(list, index) in form.pharmaCat" :key="(list, index)">
                
                <div class="form-group col-6 hide" style="margin: 10px 0px;">
                  {{ list.test_name }}
                </div>
               
                <div class="form-group col-6 hide margin-top text-center">
                  
                  <toggle-button :value="list.enable"
                    @change="changeValue(index)"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      
    </div>
    
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";
import Ls from "../../../services/ls";

export default {
  mounted: function() {
    this.getLab();
  },
  data() {
    return {
      Read: "",
      Write: "",
      Delete: "",
      form: {
        id:"",
        pharmaCat:"",
        status:0,
        lab_name: "",
        submitBtn: "Update",
      }
    };
  },
  validations: {
    form: {
      lab_name: {
      required,
      minLength: minLength(2)
      },
    } 
  },
  mounted(){
    this.getLabCat();
    this.getLab();
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
  },
  methods: {
      async submit() {
        this.$v.form.$touch();
        if(this.$v.form.$error) return;
        try {
        let cityId = this.$route.params.LaboratoriesId;
        let response = await window.axios.post('/api/admin/Laboratories/update', { data: this.form });
        window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
         this.$router.push('/Laboratories')
        } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
      },
      async getLab () {
      try {
        let cityId = this.$route.params.LaboratoriesId;
        const response = await axios.get(`/api/admin/Laboratories/edit/${cityId}`)
        this.form.lab_name =  response.data.lab_name;
        this.form.id =  response.data.id;
        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async getLabCat() {
      try {

        let labCat = this.$route.params.LaboratoriesId;
        const response = await axios.get(`/api/admin/Laboratories/labCatEdit/${labCat}`);        
        this.form.pharmaCat = response.data;

      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error1", "Error");
        }
      }
    },
    changeValue(index){
      this.form.pharmaCat[index].enable = !this.form.pharmaCat[index].enable;
    },
  async cancel()
      {
           this.$router.push('/cities')
      },
    }
};
</script>
