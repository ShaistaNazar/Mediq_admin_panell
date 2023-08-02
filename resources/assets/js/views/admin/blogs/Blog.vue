<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Blogs Pages</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Blogs</li>
      </ol>
      <div v-if="Write == 1" class="page-actions">
        <router-link to="/Blogs/add">
          <a href="/Blogs/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus"/> New BLOG Page
          </a>
        </router-link>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <div class="card-body">
            <table-component v-if="Read == 1" ref="allUsers" :data="getBlog" sort-by="row.id" sort-order="desc" table-class="table">
              <table-column show="title" label="Title"/>
              <table-column show="author" label="Author"/>
              <table-column label="Status">
                <template slot-scope="row">
                  <div v-if="row.is_show == 1">Active</div>
                  <div v-else>In-Active</div>
                </template>
              </table-column>
              <table-column v-if="Write == 1 || Delete == 1" :sortable="false" :filterable="false" label="Actions">
                <template slot-scope="row">
                  <div class="table__actions">
                    <router-link :to="{ name: 'editblog', params: { blogId: row.id }}"><a v-b-popover.hover="'EDIT'"
                                                                                          class="btn btn-default btn-sm">
                      <i class="icon-fa icon-fa-pencil"
                      />
                    </a>
                    </router-link>
                    <a v-b-popover.hover="'DELETE'"
                       v-if="Delete == 1"
                       class="btn btn-default btn-sm"
                       data-delete
                       data-confirmation="notie"
                       @click="destroyBlog(row.id)"
                    >
                      <i class="icon-fa icon-fa-trash"/>
                    </a>
                  </div>
                </template>
              </table-column>
            </table-component>

          </div>
        </div>
      </div>
    </div>
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
      title: "",
      author: "",
      is_show: null,
      file: "",
      description: ""
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
    async getBlog() {
      try {
        const response = await axios.get(
          `/api/admin/blogs/getBlogs`
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

    onImageLoadFailure(event) {
      event.target.src = this.imagelink + "no_uploaded.png";
    },
    destroyBlog(id) {
      let self = this;
      window.notie.confirm({
        text: "Are you sure?",
        cancelCallback: function() {},
        submitCallback: function() {
          self.destroyBlogData(id);
        }
      });
    },
    async destroyBlogData(id) {
      try {
        let response = await window.axios.delete("/api/admin/blogs/deleteBlog/" + id);
        this.blog = response.data;
        window.toastr["success"]("Blog Page Deleted", "Success");
        this.$refs.allUsers.refresh();
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    openprmodel(id) {
      this.propertyupdateid = id;
      this.$refs.dark_html_modal_status.open();
    }
  }
};
</script>
