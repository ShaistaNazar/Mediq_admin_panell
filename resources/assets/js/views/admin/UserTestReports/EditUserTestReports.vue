<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Upload User Test Report</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/UserTestReports">
            <a>User Test Report</a>
          </router-link>
        </li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-6 hide">
        <div class="card">
          <!-- <div class="card-header">
            <h6>Edit the file of City </h6>
          </div>-->
          <div class="card-body">
            <form @submit.prevent="submit">
              <div>
                <div class="custom-file">
                  <input
                    id="customFile"
                    ref="file"
                    :class="{ 'is-invalid': $v.form.file.$error }"
                    type="file"
                    class="custom-file-input"
                    name="customFile"
                    accept=".pdf"
                    @change="processFile($event)"

                    @input="$v.form.file.$touch()"
                  >
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                <span class="upload-test">(.pdf only)</span>
                <!-- <a>
                                    <img
                                      @error="onImageLoadFailure($event)"
                                      class="image-admin"
                                      :src="imagelink + form.abcd"
                                    >
                                  </a> -->
                <div v-if="$v.form.file.$error">
                  <span v-if="!$v.form.file.required" class="help-block help-block-error">
                    <p class="text-danger">File is required.</p>
                  </span>
                  <span v-if="!$v.form.file.isPdf" class="help-block help-block-error">
                  <p class="text-danger"> Only support pdf files.</p></span>
                </div>
              </div>

              <!-- <button
                type="submit"
                class="btn btn-primary"
                :disabled="$v.form.$invalid"
              >{{form.submitBtn}}</button> -->
              <b-button :disabled="$v.form.$invalid || isLoading" type="submit">Submit <b-spinner v-if="isLoading" small label="Spinning"/></b-button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from 'vuelidate/lib/validators'
import Ls from '../../../services/ls'

export default {
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      form: {
        file: ''
      },
      isLoading: false
    }
  },
  mounted: function () {
    this.getUserTestReports()
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },
  validations: {
    form: {
      file: {
        required,
        async isPdf (value) {
          if (this.$refs.file.files[0].type === 'application/pdf') {
            return true
          } else {
            return false
          }
        }
      }
    }
  },
  methods: {
    processFile (event) {
      this.form.file = event.target.files[0]
    },
    async submit () {
      this.isLoading = true
      this.selectedFile = this.$refs.file.files[0]
      let formData = new FormData()
      formData.append('name', this.selectedFile.name)
      formData.append('file', this.selectedFile)
      try {
        let Id = this.$route.params.UserTestReportsId
        let response = await window.axios.post(
          `/api/admin/UserTestReports/updatepimage/${Id}`,
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }

        )
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.$router.push('/UserTestReports')
      } catch (error) {
        if (error) {
          // window.toastr["error"]("Something went wrong", "Error");
        }
      }
      this.isLoading = false
    },
    async getUserTestReports () {
      try {
        let Id = this.$route.params.UserTestReportsId
        const response = await axios.get(
          `/api/admin/UserTestReports/edit/${Id}`
        )
        this.form.file = response.data.file
      } catch (error) {
        if (error) {
          // window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async cancel () {
      this.$router.push('/UserTestReports')
    }
  }
}
</script>
