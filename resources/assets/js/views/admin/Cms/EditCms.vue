<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit CMS Page</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/Cms"><a>CMS</a></router-link></li>
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
                  v-model.trim="form.title_english"
                  type="text"
                  class="form-control"
                  placeholder="Title"
                  required
                  @input="$v.form.title_english.$touch()"
                >
              </div>
              <div class="form-group">
                <label for="inputTitle">Page Content</label>
                <template>
                  <div id="app">
                    <vue-editor v-model.trim="form.page_html_content"
                                @input="$v.form.page_html_content.$touch()" />
                  </div>
                </template>
              </div>

              <div class="form-row">
                <div class="col form-group">
                  <label for="inputSlug">Slug*</label>
                  <input
                    id="inputSlug"
                    v-model.trim="form.slug"
                    type="text"
                    class="form-control"
                    placeholder="Slug"
                    required
                    readonly @input="$v.form.slug.$touch()"
                  >
                </div>
              </div>
              <div class="form-row">
                <div class="col form-group">
                  <label for="inputKeywords">Keywords</label>
                  <vue-tags-input
                    :tags="form.keywords"
                    v-model.trim="form.tag"
                    @tags-changed="newTags => form.keywords = newTags"
                  />

                </div>

              </div>
              <div class="form-row">
                <div class="col form-group">
                  <label for="inputDescription">Description</label>
                  <input
                    id="inputDescription"
                    v-model.trim="form.description"
                    type="message"
                    class="form-control"
                    placeholder="Description"
                    @input="$v.form.description"
                  >
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col">
                  <b-form-group label="Select Status">
                    <b-form-radio-group id="radios1" v-model.trim="form.selected" :options="options" name="radioOpenions"/>
                  </b-form-group>

                  <b-form-group label="">
                    <b-form-radio-group id="radios2" v-model.trim="form.selected" name="radioSubComponent">
                      <b-form-radio value="1">Active</b-form-radio>
                      <b-form-radio value="2">Inactive</b-form-radio>
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
    this.getCms();
  },
    components: {
      VueEditor,
      VueTagsInput
   },

  data() {
    return {
      ar_keywords:'',
      form: {
         Id : '',
        page_html_content:"",
        description: "",
        title_english: "",
        slug: "",
        keywords: [],
        status:"",
        submitBtn: "Update",
        selected:"",
      options: [
        { text: 'Active', value: '1' },
        { text: 'Inactive', value: '2' },
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
      async submit() {
        this.$v.form.$touch();

        if(this.$v.form.$error) return;
          try {
          this.form.Id = this.$route.params.cmsId;
          let response = await window.axios.post('/api/auth/update', {
            data: this.form,
            status: this.form.value
             });
          window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')

          this.$router.push('/Cms')
        } catch (error) {

        if (error) {
            window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
          }
        }
      },
      async getCms () {

      try {
        let pageId = this.$route.params.cmsId;
        const response = await axios.get(`/api/auth/edit/${pageId}`)
        this.form.title_english =  response.data.title_english;
        this.form.page_html_content =  response.data.page_html_content;
        this.form.description =  response.data.description;
        this.form.slug =  response.data.slug;

        console.log(response.data);

        this.form.selected =  response.data.status;

        if(response.data.keywords !== ''){
        this.ar_keywords =  response.data.keywords.split(",");
        }
        let arrayfortag= [];
        this.ar_keywords.forEach(function(entry) {
        var obj = {
            text : entry ,
            tiClasses : ['valid']
        }
        arrayfortag.push(obj);
        });
        this.form.keywords = arrayfortag;
        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

       async cancel()
      {
           this.$router.push('/Cms')
      },
    }
};
</script>
