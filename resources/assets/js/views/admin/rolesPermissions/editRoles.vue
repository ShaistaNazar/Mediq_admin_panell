<template>
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">Edit Role</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
                <li class="breadcrumb-item"><router-link to="/cms"><a>Roles</a></router-link></li>
                <li class="breadcrumb-item active">Edit Role</li>
            </ol>
        </div>
                <div class="card">
                   
                    <div class="card-body">
                        <form  v-on:submit.prevent="submit">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="form-group">
                                        <label for="inputTitle">Name</label>
                                        <input
                                               id="inputName"
                                               type="text"
                                               required
                                               class="form-control"
                                               placeholder="Role Name"
                                               v-model.trim="form.name"
                                               @input="$v.form[0].city_names"
                                               >
                                    </div>
                                   <div class="form-group">
                                        <label for="inputRead">Can Read</label>
                                         <select name="read"  @input="$v.form.read" required id="inputRole" class="form-control" placeholder="Select permission" v-model.trim="form.read">
                                          <option value="0"> No</option>
                                          <option value="1"> Yes</option>
                   
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputWrite">Can Write</label>
                                         <select name="write" required id="inputRole" class="form-control" placeholder="Select permission" v-model.trim="form.write">
                                          <option value="0"> No</option>
                                          <option value="1"> Yes</option>
                   
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDelete">Can Delete</label>
                                         <select name="delete" required id="inputRole" class="form-control" placeholder="Select permission" v-model.trim="form.delete">
                                          <option value="0"> No</option>
                                          <option value="1"> Yes</option>
                   
                                        </select>
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
      }
    };
  },
  validations: {
   form: {
      slug: {}, 

     
    }
  },
  mounted(){
    this.getRoles();
  },
  methods: {
      async submit() {
        this.$v.form.$touch();
        if(this.$v.form.$error) return;
        try {
        let response = await window.axios.post('/api/admin/roles/update', { 
            data: this.form,
            status: this.form.value
            });
         // this.$router.push("/users");
        window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
       
        } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
      },
    async getRoles () {
      
      try {
        let pageId = this.$route.params.roleId;
        const response = await axios.get(`/api/admin/roles/edit/${pageId}`)
        this.form=response.data;
        // console.log(this.form);
        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
 
      
    }
};
</script>
