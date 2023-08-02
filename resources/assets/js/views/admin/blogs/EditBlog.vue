<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit Blog Page</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/Blogs"><a>Blogs</a></router-link></li>
        <li class="breadcrumb-item active">Edit Page</li>
      </ol>
    </div>
    <div class="card">
      <div class="card-body">
        <form autocomplete="off" @submit.prevent="submit">
          <div class="form-row">
            <div class="form-group col-md-8">
              <div class="form-group">
                <label for="inputTitle">Title*</label>
                <input
                  id="inputTitle"
                  v-model.trim="form.title"
                  type="text"
                  class="form-control"
                  required
                  placeholder="Title"
                >
              </div>
              <div class="form-group">
                <label for="inputTitle">Author*</label>
                <input
                  id="inputTitle"
                  v-model.trim="form.author"
                  type="text"
                  class="form-control"
                  required
                  placeholder="Author"
                >
              </div>
              <div class="form-row">
                <div class="col form-group">
                  <label for="inputDescription">Image</label>
                  <input
                    id="file"
                    ref="file"
                    type="file"
                    accept="image/*"
                    class="form-control"
                    name="image"
                  >
                </div>
              </div>
              <div class="form-group">
                <label for="inputTitle">Blog Description</label>
                <template>
                  <div id="app">
                    <vue-editor v-model.trim="form.description" />
                  </div>
                </template>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <b-form-group label="Select Status">
                    <b-form-radio-group id="radios2" v-model.trim="form.is_show" name="radioSubComponent">
                      <b-form-radio value="1">Active</b-form-radio>
                      <b-form-radio value="0">Inactive</b-form-radio>
                    </b-form-radio-group>
                  </b-form-group>
                </div>
              </div>
            </div>
          </div>
          <button :disabled="$v.form.$invalid" type="submit" class="btn btn-primary" >{{ form.submitBtn }}</button>
          <b-button type="button" @click.prevent="cancel" >Cancel</b-button>
        </form>
      </div>
    </div>
  </div>
</template>

<script src="https://unpkg.com/@johmun/vue-tags-input/dist/vue-tags-input.js"></script>
<script type="text/babel">

import { required, sameAs, minLength, between } from "vuelidate/lib/validators";
import Multiselect from 'vue-multiselect';
import { VueEditor } from "vue2-editor";
import VueTagsInput from '@johmun/vue-tags-input';

export default {
   mounted: function() {
    this.getBlog();
  },
    components: {
      VueEditor,
      VueTagsInput
   },

  data() {
    return {
      form: {
        id : '',
        description: "",
        title: "",
        file: "",
        status:"",
        author: "",
        submitBtn: "Update",
        is_show:"",
      options: [
        { text: 'Active', value: '1' },
        { text: 'Inactive', value: '0' },
        ],

      }
    };
  },
  validations: {
   form: {
      slug: {}
    }
  },
  methods: {

    async imageUpload(id)
      {
      let formData = new FormData()
      this.selectedFile = this.$refs.file.files[0]
      formData.append('file', this.selectedFile)
      formData.append('id', this.admin_id)
      try {
        let userId = this.id
        let response = await window.axios.post(`/api/admin/blogs/addBlogImage/${userId}`,
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        )
        this.icon = response.data.trim()
      } catch (error) {
        if (error) {
          // window.toastr['error']('Something went wrong', 'Error')
        }
      }
      },
      async submit() {
          try {
          let pageId = this.$route.params.blogId;
          let response = await window.axios.put(`/api/admin/blogs/updateBlog/${pageId}`, this.form);
          window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
          this.id = response.data.ResponseHeader.id
          this.imageUpload(this.id)
          this.$router.push('/Blogs')
        } catch (error) {

        if (error) {
            window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
          }
        }
      },
      async getBlog () {
      try {
        let pageId = this.$route.params.blogId;
        const response = await axios.get(`/api/admin/blogs/editBlog/${pageId}`)
        this.form.title =  response.data.title;
        this.form.author =  response.data.author;
        this.form.description =  response.data.description;
        this.form.is_show =  response.data.is_show;
        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
      async cancel()
      {
        this.$router.push('/Blogs')
      },
    }
};
</script>
