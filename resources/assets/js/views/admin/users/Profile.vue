<template>
  <div  class="main-content page-profile">
    <div class="page-header">
      <h3 class="page-title">User's Profile</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="/users">Users</a>
        </li>
        <li class="breadcrumb-item active">{{form.user_name}}</li>
      </ol>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
                <div id class="container-fluid col-sm-6 float-left" align="center">
                  <div class="display-image">
                    <img
                      @error="onImageLoadFailure($event)"
                      :src="imagelink + form.avatar"
                    >
                  </div>
                </div>
<!-- 
                <tab id="album" name="User's Album">
                <div class="row" v-if="mediaForm.mediaImg">
                 <div class="col-sm-4 mediaShow" v-for="item in mediaForm.mediaImg" :key="item">
                    <img
                      @error="onImageLoadFailureAlbum($event)"
                      height="300"
                      width="300"
                      :src="mediaLink + item"
                    >               
              </div>
          </div>
          <div v-else>
          </div>
              </tab> -->

                <div id class="container-fluid col-sm-6" align="center">
                  <table class="table table-striped table-bordered col-sm-6 float-right">
                    <!-- <thead class="thead-dark">
                      <tr>
                        <th>Keys</th>
                        <th scope="col"  class="full-width">Personal Information</th>
                      </tr>
                    </thead>-->
                    <tbody>
                      <tr>
                        <td>
                          <i class="icon-fa icon-fa-address-book"/>
                          <b>Fisrt Name:</b>
                        </td>
                        <td>
                          <div>
                            <b>{{form.full_name}}</b>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <i class="icon-fa icon-fa-envelope"/>
                          <b>Email:</b>
                        </td>
                        <td>
                          <div v-if="form.email">{{form.email}}</div>
                          <div v-else>{{form.NotAvailabe}}</div>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <i class="icon-fa icon-fa-mars-stroke"/>
                          <b>Gender:</b>
                        </td>
                        <td>
                          <div v-if="form.gender">{{form.gender}}</div>
                          <div v-else>{{form.NotAvailabe}}</div>
                        </td>
                      </tr>
                      <!-- <tr>
                        <td>
                          <i class="icon-fa icon-fa-birthday-cake"/>
                          <b>Dob:</b>
                        </td>
                        <td>
                          <div v-if="form.dob">{{form.dob}}</div>
                          <div v-else>{{form.NotAvailabe}}</div>
                        </td>
                      </tr> -->
                      <tr>
                        <td>
                          <i class="icon-fa icon-fa-mobile-phone"/>
                          <b>Phone:</b>
                        </td>
                        <td>
                          <div v-if="form.phone">{{form.phone}}</div>
                          <div v-else>{{form.NotAvailabe}}</div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- -----------------left table ends here--------------------- -->
                </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script type="text/babel">
import { Tabs, Tab } from "vue-tabs-component";
import { TableComponent, TableColumn } from "vue-table-component";
import { media } from "../../../helpers/constants";
import { mobileImageLink } from "../../../helpers/constants";
import Vue from "vue";
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import moment from "moment";
import Ls from "../../../services/ls";

export default {
  components: {
    tabs: Tabs,
    tab: Tab
  },
  data() {
    return {
      
      Read: "",
      Write: "",
      Delete: "",
      imagelink: mobileImageLink,
      // mediaLink: media,
      form: {
        avatar: "",
        full_name: "",
        gender: "",
        phone: "",
        NotAvailabe: "Not Available..."
      },
      //  mediaForm: {
      //   mediaImg: "",
      // }
    };
  },
  mounted: function() {
    this.getUser();
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
    // this.getUserMedia();
  },
  filters: {
    formatter(value) {
      return moment(value).format("Do MMM YYYY");
    }
  },
  methods: {
    async getUser() {
      try {
        let userId = this.$route.params.userId;
        const response = await axios.get(`/api/admin/users/edit/${userId}`);
        this.form.avatar = response.data[0].avatar;
        this.form.full_name = response.data[0].full_name;
        this.form.gender = response.data[0].gender;
        this.form.phone = response.data[0].phone;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    //   async getUserMedia() {
    //   try {
    //     let userId = this.$route.params.userId;
    //     const response = await axios.get(`/api/admin/users/album/${userId}`);
    //     this.mediaForm.mediaImg = response.data;
    //   } catch (error) {
    //     if (error) {
    //       window.toastr["error"]("There was an error", "Error");
    //     }
    //   }
    // },
    onImageLoadFailure(event) {
      event.target.src = this.imagelink + "users/no-photo.jpg";
    },
    //  onImageLoadFailureAlbum(event) {
    //   event.target.src = this.imagelink + "no-album.png";
    // }
  }
};
</script>