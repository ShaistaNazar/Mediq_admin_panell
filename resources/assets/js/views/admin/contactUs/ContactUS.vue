<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Emails</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Emails</li>
      </ol>
      <!-- <div v-if="Write == 1" class="page-actions">
        <router-link to="/Blogs/add">
          <a href="/Blogs/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus"/> New BLOG Page
          </a>
        </router-link>
      </div> -->
    </div>
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <div class="card-body">
            <table-component v-if="Read == 1" ref="allEmails" :data="getEmail" sort-by="row.id" sort-order="desc" table-class="table">
              <table-column show="email" label="Emails"/>
              <table-column show="subject" label="Subject"/>
              <table-column label="Status">
                <template slot-scope="row">
                  <div v-if="row.status == 0" class="text-danger">
                    <b>Request Not Processed</b>
                  </div>
                  <div v-if="row.status == 1" class="text-success">
                    <b>Request Processed</b>
                  </div>
                </template>
              </table-column>
              <table-column :sortable="false" :filterable="false" label>
                <template slot-scope="row">
                  <div v-if="row.status === 0" class="table__actions">
                    <a
                      v-b-popover.hover="'View Message'"
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="openComment(row.message)"
                    >
                      <i class="icon-fa icon-fa-comment" style="color:lightblue;font-size: 23px;" />
                    </a>
                    <a
                      v-b-popover.hover="'Mark Complete'"
                      :class="{disabled: btnDisabled}"
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="statusConfirm(row.id)"
                    ><i class="icon-fa icon-fa-check-circle" style="color:green;font-size: 23px; cursor:pointer" /></a>
                  </div>

                </template>
              </table-column>
            </table-component>

          </div>
        </div>
      </div>
    </div>
    <sweet-modal
      ref="message"
      modal-theme="dark"
      overlay-theme="dark"
    >
      <div class="card-header hide">
        <div class="card-actions hide" />
      </div>
      <div class="card-body hide">
        <template>
          <h6>Here is the message of email</h6><br>
          <b>"{{ message }}"</b>
        </template>
      </div>
    </sweet-modal>
  </div>
</template>

<script src="https://vuejs.org/js/vue.min.js"></script>
<script type="text/babel">

import { TableComponent, TableColumn } from "vue-table-component";
import Vue from "vue";
import Ls from "../../../services/ls"
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";

import { SweetModal, SweetModalTab } from "sweet-modal-vue";
import { Tabs, Tab } from "vue-tabs-component";

Vue.use(BootstrapVue);
export default {
  components: {
    TableComponent,
    TableColumn,
    SweetModal,
    SweetModalTab,
    tabs: Tabs,
    tab: Tab
  },

  filters: {
    tagged: function(value) {
      var elements = "";
      if (!value) return "";
      value = value.split(",");
      value.forEach(function(element) {
        elements += '<span class="tags-frontend">' + element + "</span>";
      });
      return elements;
    }
  },
  data() {
    return {
      Read: "",
      Write: "",
      Delete: "",
     message: '',
     email: "",
     subject: "",
     message: "",
     btnDisabled: false,
     status: 1
    };
  },
  validations: {
    form: {
      selectedstatus: {}
    }
  },
  mounted() {
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
  },
  methods: {
    async getEmail() {
      try {
        const response = await axios.get(
          `/api/admin/contact/allContact`
        );
        return {
          data: response.data,
          // pagination: {
          //   totalPages: response.data.last_page,
          //   currentPage: page,
          //   count: response.data.count
          // }
        };
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },

    async statusConfirm (id) {
      try {
        let response  = await axios.put(`/api/admin/contact/changeStatus/${id}`, {status : 1})
         window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
         this.$refs.allEmails.refresh();
      }catch(error) {
         window.toastr["error"]("There was an error", "Error");
      }
    },
    async openComment (message) {
      this.message = message
      this.$refs.message.open(message)
    },
  }
};
</script>
