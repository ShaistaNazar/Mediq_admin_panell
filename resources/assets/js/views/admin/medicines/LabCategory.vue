<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Lab Test Categories</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Lab Test Category</li>
      </ol>
    </div>
    <div class="row">

       <div v-if="Read == 1" class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputUserName">Add New Category *</label>
                  <input
                    id="inputUserName"
                    v-model.trim="form.category_name"
                    :class="{ 'is-invalid': $v.form.category_name.$error }"
                    type="text"
                    class="form-control"
                    placeholder="Category Name"
                    @input="$v.form.category_name.$touch()"
                  >
                  <div v-if="$v.form.category_name.$error">
                    <span v-if="!$v.form.category_name.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.category_name.minLength" class="help-block help-block-error">
                      Category Name must have at least {{ $v.form.category_name.$params.minLength.min }} letters.
                    </span>
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <label >Add to In-Demand</label>
                  <toggle-button :value="form.in_demand"
                                 :sync="true"
                                 :labels="{checked: 'Yes', unchecked: 'No'}"
                                 v-model.trim="form.in_demand"
                                 color="lightseagreen"
                                 class="toggleStyle"
                  />
                </div>
              </div>

              <button
                type="submit"
                :disabled="$v.form.$invalid"
                class="btn btn-primary"
              >{{ form.submitBtn }}</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
      </div>
      <div v-else class="alert alert-info" role="alert">
        Sorry! you dont have permission
      </div>

      <div class="col-sm-12 hide">
        <div class="card">

          <div v-if="Read == 1" class="card-body">
            <table-component
              ref="allUsers"
              :data="getMedicines"
              sort-by="id"
              sort-order="desc"
              table-class="table"
            >

              <table-column show="category_name" label="category name"/>

              <table-column
                :formatter="formatter"
                show="created_at"
                label="Registered On"
                data-type="date:YYYY-MM-DD"
              />

              <table-column
                :sortable="false"
                :filterable="false"
                label="Actions"
              >
                <template v-if="Write == 1 || Delete == 1" slot-scope="row">
                  <div class="table__actions"><div/>

                    <div v-if="Delete == 1">
                      <a
                      v-b-popover.hover="'Select Service Provider'"
                      @click="rentalEquipmentPrice(row.category_name,row.id,row.in_demand)"
                    ><i class="icon-fa icon-fa-pencil"/>
                    </a>
                       <a
                     v-b-popover.hover ="'DELETE'"
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="destroyUser(row.id)"
                    >
                      <i class="icon-fa icon-fa-trash"/> 
                    </a>    
                    </div>  
                    <div v-if="row.in_demand == 1"
                          style="color:white !important" class="btn btn-success btn-sm">Already In-Demand</div>   
                    <div  v-else class="float-right">
                        <a
                          v-b-popover.hover="'Add to In-demand'"
                          class="btn btn-warning btn-sm"
                          style="color:white !important"
                          data-delete
                          data-confirmation="notie"
                          @click="AddInDemand(row.id , type = 'test_category')"
                        >Add to In-Demand
                        </a>
                      </div>                                  
                  </div>
                </template>
              </table-column>
            </table-component>
          </div>
            <div v-else class="alert alert-info" role="alert">
                  Sorry! you dont have permission
                          </div>
        </div>
      </div>
       <sweet-modal
      ref="popup"
      modal-theme="dark"
      overlay-theme="dark"
    >
      <div class="card-header hide">
        <div class="card-actions hide" />
      </div>
      <div class="card-body hide">
        <template>
         <div class="form-group col-md-12">
                        
                      </div>
                      <div class="form-group col-md-12">
                        <label for="inputAmount">Category Name</label>
                        <input
                          id="inputAmount"
                          type="text"
                           min="0"
                          class="form-control"
                          placeholder="Total Amount"
                          v-model.trim="cat_form.cat_name"                          
                        />
                      </div>
                      <div class="form-group col-md-12">
                  <label >Add to In-Demand</label>
                  <toggle-button :value="cat_form.in_demand"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    class="toggleStyle"
                    v-model.trim="cat_form.in_demand"
                    />
                </div>
                       <button
                type="submit"
                class="btn btn-primary"
                 @click.prevent="submitCat"
              >submit</button>
        </template>       
      </div>
    </sweet-modal>

       <!-- <div class="col-sm-6" v-if="Read == 1">
        <div class="card">
          <div class="card-body">
            <form v-on:submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputUserName">Add New Category</label>
                  <input
                    id="inputUserName"
                    type="text"
                    class="form-control"
                    placeholder="User Name"
                    v-model.trim="form.category_name"
                  />
                </div>
                <div class="form-group col-md-12">
                  <label >Add to In-Demand</label>
                  <toggle-button :value="form.in_demand"
                    color="#1a1a44"
                    :sync="true"
                    :labels="{checked: 'Yes', unchecked: 'No'}"
                    class="toggleStyle"
                    v-model.trim="form.in_demand"
                    />
                </div>
              </div>           

              <button
                type="submit"
                class="btn btn-primary"
              >{{form.submitBtn}}</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
      </div> -->
      <!-- <sweet-modal
        ref="popup"
        modal-theme="dark"
        overlay-theme="dark"
      >
        <div class="card-header hide">
          <div class="card-actions hide" />
        </div>
        <div class="card-body hide">
          <template>
            <div class="form-group col-md-12"/>
            <div class="form-group col-md-12">
              <label for="inputAmount">Category Name</label>
              <input
                id="inputAmount"
                v-model.trim="cat_form.cat_name"
                type="text"
                min="0"
                class="form-control"
                placeholder="Total Amount"
              >
            </div>
            <div class="form-group col-md-12">
              <label >Add to In-Demand</label>
              <toggle-button :value="cat_form.in_demand"
                             :sync="true"
                             :labels="{checked: 'Yes', unchecked: 'No'}"
                             v-model.trim="cat_form.in_demand"
                             color="lightseagreen"
                             class="toggleStyle"
              />
            </div>
            <button
              type="submit"
              class="btn btn-primary"
              @click.prevent="submitCat"
            >submit</button>
          </template>
        </div>
      </sweet-modal> -->
    </div>
  </div>
</template>

<script type="text/babel">
import Ls from '../../../services/ls'
import { TableComponent, TableColumn } from 'vue-table-component'
import { imageLink } from '../../../helpers/constants'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import moment from 'moment'
import { required, sameAs, minLength, between } from 'vuelidate/lib/validators'
import { SweetModal, SweetModalTab } from 'sweet-modal-vue'

export default {
  components: {
    TableComponent,
    TableColumn,
    SweetModal,
    SweetModalTab
  },
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      form: {
        UID: '',
        selectedstatus: '',
        packages: [],
        submitBtn: 'Add',
        category_name: '',
        in_demand: false
      },
      cat_form: {
        id: '',
        cat_name: '',
        in_demand: false,
        submitBtn: 'update'
      }
    }
  },
  validations: {
    form: {
      category_name: {
        required,
        minLength: minLength(4)
      }
    }
  },
  mounted () {
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },

  methods: {
    async submit () {
      try {
        // alert(this.form.UID);
        let response = await window.axios.post('/api/admin/TestsCategory/add', {
          data: this.form
        })
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.$refs.allUsers.refresh()
        this.form.category_name = ''
        this.form.in_demand = false
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response.data.ResponseHeader.ResponseMessage,
            'Error'
          )
        }
      }
    },
    formatter (value, rowProperties) {
      return moment(value).format('Do MMM YYYY')
    },
    // async getAuthUser() {
    //       try {
    //       let response = await window.axios.get('/api/admin/employees/authuser');
    //       this.auth_user=response.data;
    //       // console.log(this.auth_user.);
    //       } catch (error) {
    //       if (error) {
    //         window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
    //       }
    //     }
    //     },
    async getMedicines ({ page, filter, sort }) {
      try {
        const response = await axios.get(`/api/admin/TestsCategory/paginate/get?page=${page}&filter=${filter}`)

        return {
          data: response.data.data,
          pagination: {
            totalPages: response.data.last_page,
            currentPage: page,
            count: response.data.count
          }
        }
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    onImageLoadFailure (event) {
      event.target.src = this.imageLink + 'users/no-photo.jpg'
    },

    // Block User

    destroyUser (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {

        },
        submitCallback: function () {
          self.destroyUserData(id)
        }
      })
    },

    async destroyUserData (id) {
      try {
        let response = await window.axios.delete('/api/admin/TestsCategory/' + id)
        this.users = response.data
        window.toastr['success']('Medicine Deleted', 'Success')
        this.$refs.allUsers.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    AddInDemand (id, type) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {},
        submitCallback: function () {
          self.AddInDemandData(id, type)
        }
      })
    },
    async AddInDemandData (id, type) {
      try {
        let response = await window.axios.post('/api/admin/orders/inDemandAdd', {id, type})
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.$refs.allUsers.refresh()
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    refreshRow () {
      this.form.category_name = ''
    },
    async rentalEquipmentPrice (name, id, in_demand) {
      this.cat_form.cat_name = name
      this.cat_form.id = id
      this.cat_form.in_demand = Boolean(in_demand)

      this.$refs.popup.open(name, id, in_demand)
    },
    async submitCat () {
      try {
        // alert(this.form.UID);
        let response = await window.axios.post('/api/admin/Tests/cat/update', {
          data: this.cat_form
        })
        window.toastr['success'](
          response.data.ResponseHeader.ResponseMessage,
          'Success'
        )
        this.$refs.allUsers.refresh()
        this.form.category_name = ''
        this.form.in_demand = false
      } catch (error) {
        if (error) {
          window.toastr['error'](
            response.data.ResponseHeader.ResponseMessage,
            'Error'
          )
        }
      }
    },
    async cancel () {
      this.$router.push('/Laboratories')
    },
    //  openprmodel(id) {

    //    this.form.UID = id;
    //       this.$refs.dark_html_modal_statuscomm.open();
    //     },

  }

}
</script>
