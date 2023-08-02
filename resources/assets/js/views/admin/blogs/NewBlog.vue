<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Add New Blog Page</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/blogs"><a>Blog</a></router-link></li>
        <li class="breadcrumb-item active">New Blog Page</li>
      </ol>
    </div>
    <div class="card">
      <div class="card-body">
        <form autocomplete="off" @submit.prevent="submit">
          <div class="form-row">
            <div class="form-group col-md-12">
              <div class="form-group">
                <label for="inputTitle">Title*</label>
                <input
                  id="inputTitle"
                  :class="{ 'is-invalid' : $v.form.title.$error }"
                  v-model.trim="form.title"
                  type="text"
                  class="form-control"
                  placeholder="Blog Title"
                  required
                  @input="$v.form.title.$touch()"
                >
                <div v-if="$v.form.title.$error">
                  <span v-if="!$v.form.title.required" class="help-block help-block-error">
                    Field is required
                  </span>
                  <span v-if="!$v.form.title.minLength" class="help-block help-block-error">
                    <p class="text-danger">title must have at least {{ $v.form.title.$params.minLength.min }} letters.</p>
                  </span>
                  <span v-if="!$v.form.title.maxLength" class="help-block help-block-error">
                    <p class="text-danger">title then have at least {{ $v.form.title.$params.maxLength.max }} letters.</p>
                  </span>
                </div>
              </div>
              <div class="form-row">
                <div class="col form-group">
                  <label for="inputDescription">Author*</label>
                  <input
                    id="inputDescription"
                    :class="{ 'is-invalid' : $v.form.author.$error }"
                    v-model.trim="form.author"
                    type="message"
                    class="form-control"
                    required
                    placeholder="Author"
                    @input="$v.form.author.$touch()"
                  >
                  <div v-if="$v.form.author.$error">
                    <span v-if="!$v.form.author.required" class="help-block help-block-error">
                      <p class="text-danger"> author is required.</p>
                    </span>
                    <span v-if="!$v.form.author.minLength" class="help-block help-block-error">
                      <p class="text-danger">author must have at least {{ $v.form.author.$params.minLength.min }} letters.</p>
                    </span>
                    <span v-if="!$v.form.author.maxLength" class="help-block help-block-error">
                      <p class="text-danger">author then have at least {{ $v.form.author.$params.maxLength.max }} letters.</p>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col form-group">
                  <label for="inputDescription">Image*</label>
                  <input
                    id="file"
                    ref="file"
                    type="file"
                    accept="image/*"
                    class="form-control"
                    required
                    name="image"
                  >
                </div>
              </div>
              <div class="form-group">
                <label for="inputTitle">Blog Description</label>
                <template>
                  <div id="app">
                    <vue-editor :class="{ 'is-invalid' : $v.form.description.$error}" v-model.trim="form.description"
                                @input="$v.form.description.$touch()"
                    />
                    <div v-if="$v.form.description.$error">
                      <span v-if="!$v.form.description.required" class="help-block help-block-error">
                        <p class="text-danger"> description is required.</p>
                      </span>
                    </div>
                  </div>
                </template>
              </div>
              <div class="col form-group"/>
              <div class="form-row">
                <div class="form-group col">
                  <b-form-group label="Select Status*">
                    <b-form-radio-group id="radios2" name="radio-validation">
                      <input v-model="form.is_show" type="radio" value="1" name="status" required> <label>Active</label>
                      <input v-model="form.is_show" type="radio" value="0" name="status" required>  <label>InActive</label>
                      <!-- <b-form-radio v-model="form.is_show" value="0">Inactive</b-form-radio> -->
                    </b-form-radio-group>
                  </b-form-group>
                </div>
              </div>
            </div>
          </div>
          <button :disabled="$v.$invalid" type="submit" class="btn btn-primary" >{{ form.submitBtn }}</button>
          <b-button type="button" @click.prevent="cancel" >Cancel</b-button>
        </form>
      </div>
    </div> <!--card-->
  </div>
</template>
<script src="https://unpkg.com/@johmun/vue-tags-input/dist/vue-tags-input.js"></script>
<script type="text/babel">
import { required, sameAs, minLength, maxLength, between } from "vuelidate/lib/validators";
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
        title: "",
        author: "",
        description: "",
        file: "",
        submitBtn: "Submit",
        is_show: null,
      options: [
        { text: 'Active', value: '1' },
        { text: 'Inactive', value: '0' },
        ],

      }
    };
  },
  validations: {
  form: {
    title : {
      required,
      minLength: minLength(10),
      maxLength: maxLength(100)
    },
    author: {
      required,
      minLength: minLength(4),
      maxLength: maxLength(20)
    },
    description: {
      required
    }
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
          window.toastr['error']('Something went wrong', 'Error')
        }
      }
      },
      async submit() {
        this.$v.form.$touch()
        if (this.$v.form.$error) return
        try {
        let response = await window.axios.post('/api/admin/blogs/add', this.form);
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
      async cancel()
      {
          this.$router.push('/Blogs')
      }

    }
};
</script>
