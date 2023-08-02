<template>
  <div  class="main-content">
    <div class="page-header">
      <h3 class="page-title">Add New User</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/users"><a>Users</a></router-link></li>
        <li class="breadcrumb-item active">New</li>
        </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <!-- <div class="card-header">
            <h6>Basic Form</h6>
          </div> -->
          <div class="card-body">
            <form  v-on:submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputFirstName">First Name</label>
                  <input
                    id="inputFirstName"
                    type="text"
                    class="form-control"
                    placeholder="First Name"
                    :class="{ 'is-invalid': $v.form.first_name.$error }"
                    v-model.trim="form.first_name"
                    @input="$v.form.first_name.$touch()"
                  >
                  <div v-if="$v.form.first_name.$error">
                    <span v-if="!$v.form.first_name.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.first_name.minLength" class="help-block help-block-error">
                      First Name must have at least {{ $v.form.first_name.$params.minLength.min }} letters.
                    </span>
                </div>
                </div>
                <div class="form-group col-md-12">
                  <label for="inputLastName">Last Name</label>
                  <input
                    id="inputLastName"
                    type="text"
                    class="form-control"
                    placeholder="Last Name"
                    v-model.trim="form.last_name"
                  >
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputphone">Phone Number</label>
                <input 
                  id="exampleInputphone"
                  type="text"
                  class="form-control"
                  aria-describedby="phoneHelp"
                  placeholder="Enter Phone"
                  :class="{ 'is-invalid': $v.form.phone.$error }"
                  v-model.trim="form.phone"
                  @input="$v.form.phone.$touch()"
                >
               
                <div v-if="$v.form.phone.$error">
                  <span v-if="!$v.form.phone.required" class="help-block help-block-error">
                   <p class="text-danger">Phone is required.</p> 
                  </span>
                  <span v-if="!$v.form.phone.isUnique" class="help-block help-block-error">
                   <p class="text-danger"> This phone is already registered.</p></span>
                   <span v-if="!$v.form.phone.minLength" class="help-block help-block-error text-warning">
                   <p class="text-danger">Phone must have at least {{ $v.form.phone.$params.minLength.min }} letters.</p>
                  </span>
                </div>
              </div>
              
              
              <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input
                  id="exampleInputPassword1"
                  type="password"
                  class="form-control"
                  placeholder="Password"
                  :class="{ 'is-invalid': $v.form.password.$error }"
                  v-model.trim="form.password"
                  @input="$v.form.password.$touch()"
                >
                <div v-if="$v.form.password.$error">
                  <span v-if="!$v.form.password.required" class="help-block help-block-error">
                   <p class="text-danger"> Password is required.</p> 
                  </span>
                  <span v-if="!$v.form.password.minLength" class="help-block help-block-error">
                    <p class="text-danger">Password must have at least {{ $v.form.password.$params.minLength.min }} letters.</p>
                  </span>
                </div>
              </div>

              <div class="form-group">
                <label for="exampleInputrepeatPassword">Confirm Password</label>
                <input
                  id="exampleInputrepeatPassword"
                  type="password"
                  class="form-control"
                  placeholder="Confirm Password"
                  :class="{ 'is-invalid': $v.form.repeatPassword.$error }"
                  v-model.trim="form.repeatPassword"
                  @input="$v.form.repeatPassword.$touch()"
                >
                <div v-if="$v.form.repeatPassword.$error">
                  <span v-if="!$v.form.repeatPassword.sameAsPassword" class="help-block help-block-error">
                    <p class="text-danger"> Passwords must be identical.</p> 
                  </span>
                </div>
              </div>

              <button type="submit" class="btn btn-primary" :disabled="$v.form.$invalid" >{{form.submitBtn}}</button>
              <b-button type=button @click.prevent="cancel" >Cancel</b-button>
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
  data() {
    return {
      Read: "",
      Write: "",
      Delete: "",
      form: {
        first_name: "",
        last_name: "",
        phone: "",
        password: "",
        submitBtn: "Submit",
        repeatPassword: ""
      }
    };
  },
  validations: {
    form: {
      first_name: {
        required,
        minLength: minLength(4)
      },
      password: {
        required,
        minLength: minLength(6)
      },
      repeatPassword: {
        required,
        minLength: minLength(6),
        sameAsPassword: sameAs("password")
      },
      phone: {
        required,
        minLength: minLength(11),
        async isUnique(value) {
          if (value === "") return true;
          let response = await window.axios.post("/api/phone-exist", {
            phone: value
          });
          return response.data;
        }
      }
    } 
  },
  mounted() {
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
  },
  methods: {
      async submit() {
        this.$v.form.$touch();
        if(this.$v.form.$error) return;
        try {
        let response = await window.axios.post('/api/admin/users/add', { data: this.form });
        window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
         this.$router.push('/users')
        } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
      },
        async cancel()
      {
           this.$router.push('/users')
      },
    }
};
</script>
