<template>
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">Add New Roles</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
                <li class="breadcrumb-item"><router-link to="/cms"><a>Roles</a></router-link></li>
                <li class="breadcrumb-item active">New Roles</li>
            </ol>
        </div>
                <div class="card">
                   
                    <div class="card-body">
                        <form  v-on:submit.prevent="submit">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                     <div class="form-group">
                                        <label for="inputTitle">Name</label>
                                        <input
                                               id="inputName"
                                               type="text"
                                               required
                                               class="form-control"
                                               placeholder="Role Name"
                                               v-model.trim="form.name">
                                    </div>

                                        <div class="">
                                          <b-form-group label>Can Read
                                            <b-form-radio-group name="read" required id="inputRole" class="form-control" placeholder="Select permission" v-model.trim="form.read">
                                                <b-form-radio value="1">Yes</b-form-radio>
                                                <b-form-radio value="2" class="radioStyle">No</b-form-radio>
                                            </b-form-radio-group>
                                          </b-form-group>
                                    </div>

                                    <div class="">
                                        <label for="inputRead">Can Write?</label>
                                          <b-form-group label>
                                            <b-form-radio-group name="read" required id="inputRole" class="form-control" placeholder="Select permission" v-model.trim="form.read">
                                                <b-form-radio value="1">Yes</b-form-radio>
                                                <b-form-radio value="2" class="radioStyle">No</b-form-radio>
                                            </b-form-radio-group>
                                          </b-form-group>
                                    </div>

                                      <div class="">
                                        <label for="inputRead">Can Delete?</label>
                                          <b-form-group label>
                                            <b-form-radio-group name="read" required id="inputRole" class="form-control" placeholder="Select permission" v-model.trim="form.read">
                                                <b-form-radio value="1">Yes</b-form-radio>
                                                <b-form-radio value="2" class="radioStyle">No</b-form-radio>
                                            </b-form-radio-group>
                                          </b-form-group>
                                    </div>

                                   

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" >{{form.submitBtn}}</button>
                            <!-- <b-button type=button @click.prevent="cancel" >Cancel</b-button> -->
                        </form>
                    </div>
                </div> <!--card-->
    </div>
</template>
<script src="https://unpkg.com/@johmun/vue-tags-input/dist/vue-tags-input.js"></script>
<script type="text/babel">
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";
import Multiselect from 'vue-multiselect';
import { VueEditor } from "vue2-editor";
import VueTagsInput from '@johmun/vue-tags-input';
// Advanced Use - Hook into Quill's API for Custom Functionality


export default {
    components: {
      VueEditor,
      VueTagsInput,
   },
  data() {
    return {        
       form: {
        name: '',
        write:'',
        read:'',
        delete:'',
        submitBtn: "Submit",
        selected: "", 
         options: [
          { text: "Yes", value: "1" },
          { text: "No", value: "0" }
        ]    
      }
    };
  },
  // validations: {
  //  form: {
  //     slug: {}, 

     
  //   }
  // },
  methods: {
      async submit() {
        // this.$v.form.$touch();
        // if(this.$v.form.$error) return;
        try {
        let response = await window.axios.post('/api/admin/roles/add', { 
            data: this.form,
            status: this.form.value
            });
        window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
       
        } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
      },
      // async cancel()
      // {
      //      this.$router.push('/roleslist')
      // },
      
    }
};
</script>
