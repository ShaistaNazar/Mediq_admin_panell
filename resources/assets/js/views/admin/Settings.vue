<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Settings</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard">Home</a>
        </li>
        <li class="breadcrumb-item active">
          <a href="#">Settings</a>
        </li>
      </ol>
    </div>
    <div class="card">
      <div class="card-header">
        <h6>Settings</h6>
      </div>
      <div class="card-body">
        <div class="col-lg-12 mb-4">
          <h5 class="section-semi-title"></h5>
          <tabs
            :options="{ useUrlFragment: false }"
            class="tabs-simple"
          >
            <!-- tab 1 profile start here -->
            <tab
              id="vertical-primary-Profile"
              name="Admin's Profile"
            >
              <template>
                <div class>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="card">
                        <div class="card-header">
                          <h6>Edit Admin's Profile</h6>
                        </div>
                        <div
                          class="card-body"
                          v-if="Read == 1"
                        >
                          <form v-on:submit.prevent="submitprofile">
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label for="inputFirstName">Name</label>
                                    <input
                                      id="inputFirstName"
                                      type="text"
                                      class="form-control"
                                      placeholder="Enter Full Name"
                                      v-model.trim="form.full_name"
                                      @input="$v.form.full_name.$touch()"
                                    >
                                  </div>
                                  <div class="form-group col-md-12">
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
                                      <span
                                        v-if="!$v.form.phone.required"
                                        class="help-block help-block-error"
                                      >
                                        <p class="text-danger"> Phone is required.</p>
                                      </span>
                                      <span
                                        v-if="!$v.form.phone.isUnique"
                                        class="help-block help-block-error"
                                      >
                                        <p class="text-danger"> This phone is already registered.</p>
                                      </span>
                                    </div>
                                  </div>

                                  <div class="form-group col-md-12">
                                    <label for="inputFirstName">Email</label>
                                    <input
                                      id="inputFirstName"
                                      type="email"
                                      class="form-control"
                                      placeholder="Enter Email"
                                      v-model.trim="form.email"
                                      @input="$v.form.email.$touch()"
                                    >
                                  </div>
                                  <div class="form-group col-md-12">
                                    <div class="custom-file">
                                      <label for="packageImage">Choose Image (jpg, jpeg, gif, png)</label>
                                      <input
                                        type="file"
                                        accept="image/*"
                                        class="form-control"
                                        id="packageImage"
                                        ref="file"
                                        name="packageImage"
                                      />
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="form-group col-md-6">
                                <div class="admin-pic">
                                  <img
                                    @error="onImageLoadFailure($event)"
                                    v-b-popover.hover="'View Profile Picture'"
                                    height="250"
                                    width="250"
                                    :src="imagelink + this.form.profile_picture"
                                  />
                                </div>
                              </div>
                            </div>

                            <button
                              v-if="Write == 1"
                              type="submit"
                              class="btn btn-primary"
                              :disabled="$v.form.$invalid"
                            >{{form.submitBtn}}</button>
                            <div v-else></div>
                          </form>
                        </div>
                        <div
                          v-else
                          class="alert alert-info"
                          role="alert"
                        >
                          Sorry! you dont have permission
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </tab>
            <!-- tab 1 profile ends here -->
            <tab
              id="simple-home"
              name="Reset Password"
            >
              <!-- tab 1 reset Password start here -->
              <div class="card">
                <div class="card-header">
                  <h6>Reset Password</h6>
                </div>
                <div
                  class="card-body"
                  v-if="Read == 1"
                >
                  <form v-on:submit.prevent="submitpassword">
                    <div class="form-row">
                      <div class="form-group col-md-8">
                        <div class="form-group">
                          <div>
                            <label for="exampleInputCPassword">Current Password</label>
                            <input
                              id="exampleInputCPassword1"
                              type="password"
                              class="form-control"
                              placeholder="Current Password"
                              :class="{ 'is-invalid': $v.formPassword.currentpassword.$error }"
                              v-model.trim="formPassword.currentpassword"
                              @input="$v.formPassword.currentpassword.$touch()"
                            >
                            <div v-if="$v.formPassword.currentpassword.$error">
                              <span
                                v-if="!$v.formPassword.currentpassword.required"
                                class="help-block help-block-error"
                              >
                                <p class="text-danger">old Password is required.</p>
                              </span>
                              <span
                                v-if="!$v.formPassword.currentpassword.isUnique"
                                class="help-block help-block-error"
                              >
                                <p class="text-danger"> Incorrent Password.</p>
                              </span>

                            </div>
                          </div>
                          <label for="exampleInputPassword">New Password</label>
                          <input
                            id="exampleInputPassword1"
                            type="password"
                            class="form-control"
                            placeholder="Password"
                            :class="{ 'is-invalid': $v.formPassword.password.$error }"
                            v-model.trim="formPassword.password"
                            @input="$v.formPassword.password.$touch()"
                          >
                          <div v-if="$v.formPassword.password.$error ">
                            <span
                              v-if="!$v.formPassword.password.required"
                              class="help-block help-block-error"
                            >
                              <p class="text-danger"> Password is required.</p>
                            </span>
                            <span
                              v-if="!$v.formPassword.password.minLength"
                              class="help-block help-block-error"
                            >
                              <p class="text-danger">Password must have at least {{ $v.formPassword.password.$params.minLength.min }} letters.</p>
                            </span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputrepeatPassword">Confirm New Password</label>
                          <input
                            id="exampleInputrepeatPassword"
                            type="password"
                            class="form-control"
                            placeholder="Confirm Password"
                            :class="{ 'is-invalid': $v.formPassword.repeatPassword.$error }"
                            v-model.trim="formPassword.repeatPassword"
                            @input="$v.formPassword.repeatPassword.$touch()"
                          >
                          <div v-if="$v.formPassword.repeatPassword$error ">
                            <span
                              v-if="!$v.formPassword.repeatPassword.sameAsPassword"
                              class="help-block help-block-error"
                            >
                              <p class="text-danger"> This phone is already registered.</p>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button
                      v-if="Write == 1"
                      type="update"
                      class="btn btn-primary"
                      :disabled="$v.formPassword.$invalid"
                    >{{formPassword.submitBtn}}</button>
                    <div v-else></div>
                  </form>
                </div>
                <div
                  v-else
                  class="alert alert-info"
                  role="alert"
                >
                  Sorry! you dont have permission
                </div>
              </div>
            </tab>

          </tabs>
        </div>
      </div>
      <!-- <div v-if="Read == 0">
                <div class="alert alert-info" role="alert">
                  Sorry! you dont have permission
                </div>
              </div> -->
    </div>
  </div>
</template>




<script type="text/babel">
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";
import { Tabs, Tab } from "vue-tabs-component";
import { imageLink } from "../../helpers/constants";
import Ls from "../../services/ls";
import { serverBus } from '../../app';

export default {
  name: "image-input",
  components: {
    tabs: Tabs,
    tab: Tab
  },
  data () {
    return {
      selectedFile: "",
      social: "",
      Read: "",
      Write: "",
      Delete: "",
      imagelink: imageLink,
      admin_id: "",
      profilepicture: "abc",
      form: {
        full_name: "",
        phone: "",
        email: "",
        profile_picture: "",
        Id: "",
        submitBtn: "Submit"
      },
      formFB: {
        value: []
      },
      formPassword: {
        currentpassword: "",
        Id: "",
        password: "",
        repeatPassword: "",
        submitBtn: "Submit"
      },
      formSocial: {
        facebook_api: "",
        facebook_secret: "",
        submitBtn: "Submit"
      },
      submitChat: {

      },
      submitChat: {

      },
    };
  },
  validations: {
    form: {


      phone: {
        required,
        minLength: minLength(10),
        async isUnique (value) {
          if (value === "") return true;
          let userId = this.admin_id;
          let response = await window.axios.post(
            `/api/phone-existId/${userId}`,
            {
              phone: value
            }
          );
          return response.data;
        }
      },
      email: { required },
    },
    formPassword: {
      currentpassword: {
        required,
        minLength: minLength(6),
        async isUnique (value) {
          if (value === "") return true;
          let userId = this.admin_id;
          let response = await window.axios.post(`/api/passwordcheck`,

            {
              currentpassword: value,
              Id: userId
            }
          );
          return response.data;
        }
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
    }

  },
  mounted: function () {
    // this.submitsocial();
    // this.getUser();
    // this.submitsocial();
    //this.profilepicture = Ls.get("auth.profile_picture");
    this.admin_id = Ls.get("auth.admin_id");
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");

    this.getAdmin();
    this.getAdminProfile();
    this.getSocial();
  },
  methods: {
    onImageLoadFailure (event) {
      event.target.src = this.imagelink + "users/no-photo.jpg";
    },
    async updateProfilePic () {
      this.selectedFile = this.$refs.file.files[0];
      let formData = new FormData();
      formData.append("name", this.selectedFile.name);
      formData.append("image", this.selectedFile);
      formData.append("id", this.admin_id);
      try {
        let response = await window.axios.post(
          `/api/admin/adminprofile/upload_user_profile?admin_id=${this.admin_id}`,
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          }
        );
        location.reload();
        // this.icon = response.data.trim();
      } catch (error) {
        if (error) {
          window.toastr["error"]("Something went wrong", "Error");
        }
      }
    },

    // profile edit function
    async submitprofile () {
      try {
        this.form.Id = this.admin_id;
        let response = await window.axios.post(
          "/api/admin/adminprofile/update",
          {
            data: this.form
          }
        );
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        this.updateProfilePic();
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
    // password edit function
    async submitpassword () {
      try {
        this.formPassword.Id = this.admin_id;
        let response = await window.axios.post(
          "/api/admin/adminprofile/resetPass/update",
          {
            data: this.formPassword,
          }
        );
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        this.$router.push("settings");
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
    // password social function
    async submitsocial () {
      try {
        let response = await window.axios.post(
          "/api/admin/setting/edit",
          {
            data: this.formSocial
          }
        );
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        this.$router.push("settings");
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
    async getAdminProfile () {
      try {
        const response = await axios.get(
          `/api/admin/users/edit/` + this.admin_id
        );
        this.form.full_name = response.data[0].full_name;
        this.form.email = response.data[0].email;
        this.form.phone = response.data[0].phone;
        this.form.profile_picture = response.data[0].avatar;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async getSocial () {
      try {
        const response = await axios.get(`/api/admin/setting/edit`);

        this.social = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async submitsocial () {
      try {
        let response = await window.axios.post("/api/admin/setting/update", {
          value: this.social
        });
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        this.$router.push("/settings");
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
    async getAdmin () {
      try {
        const response = await axios.get(
          `/api/admin/appSettings/edit/` + this.admin_id
        );
        this.submitChat = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
  }
};
</script>