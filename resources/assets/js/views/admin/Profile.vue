<template>
 <div class="main-content">
   <div class="page-header">
     <h3 class="page-title">Profile</h3>
     <ol class="breadcrumb">
       <li class="breadcrumb-item active"><a href="#">Edit Profile</a></li>
     </ol>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
       <h6>Edit Admin's Profile</h6>
     </div>
          <div class="card-body">
            <form  v-on:submit.prevent="submit">
               <div class="form-row">
                                
                                    <div class="form-group col-md-12">
                                        <label for="inputusername">User Name</label>
                                        <input
                                               id="inputusername"
                                               type="text"
                                               class="form-control"
                                               placeholder="Title"                                              
                                               v-model.trim="form.user_name"
                                                @input="$v.form.user_name.$touch()"
                                               >
                                    </div>
                                    
                                
               
                                      <div class="form-group col-md-12">
                                        <label for="inputFirstName">First Name</label>
                                        <input
                                                   id="inputFirstName"
                                                   type="text"
                                                   class="form-control"
                                                   placeholder="inputFirstName"
                                                   v-model.trim="form.first_name"
                                                   @input="$v.form.first_name.$touch()" 
                                                   > 
                                    </div>
                         
                                   
                                    
                                        <div class="col form-group col-md-12">
                                            <label for="inputLastName">Last Name</label>
                                            <input
                                                   id="inputLastName"
                                                   type="text"
                                                   class="form-control"
                                                   placeholder="inputLastName"
                                                   v-model.trim="form.last_name"
                                                   @input="$v.form.last_name.$touch()" 
                                                   > 
                                        
                                         </div>
                 </div>                      

              <button type="submit" class="btn btn-primary" :disabled="$v.form.$invalid" >{{form.submitBtn}}</button>
            </form>
          </div>
        </div>
      </div>
      
    </div>
    
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";

export default {
  mounted: function() {
    this.getCity();
  },
  data() {
    return {
      form: {
        name: "",
        submitBtn: "Update",
      }
    };
  },
  validations: {
    form: {
      name: {
      required,
      minLength: minLength(4)
      },
    } 
  },
  methods: {
      async submit() {
        this.$v.form.$touch();
        if(this.$v.form.$error) return;
        try {
        this.form.Id = this.$route.params.cityId;
        alert('111')
        let response = await window.axios.post('/api/admin/cms/update', { data: this.form });
        window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
         this.$router.push('/cities')
        } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
      },
      async getCity () {
      try {
        let cityId = this.$route.params.cityId;
        const response = await axios.get(`/api/admin/cities/edit/${cityId}`)
        this.form.name =  response.data.name;
        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    }
};
</script>
