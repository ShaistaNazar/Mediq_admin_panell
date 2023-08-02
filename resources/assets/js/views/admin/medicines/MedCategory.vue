<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Medicine Categories</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item active">Medicines</li>
      </ol>
    </div>
    <div class="row">

      <div v-if="Read == 1" class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputUserName">Add New Category*</label>
                  <input
                    id="inputUserName"
                    v-model.trim="form.category_name"
                    type="text"
                    class="form-control"
                    required
                    placeholder="User Name"
                  >

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
                        @click="rentalEquipmentPrice(row.category_name,row.id,row.image)"
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
                    <div v-if="row.in_demand == 1" class="btn btn-success btn-sm">Already In-Demand</div>
                    <div v-else class="float-right">
                      <a
                        v-b-popover.hover="'Add to In-demand'"
                        class="btn btn-warning btn-sm"
                        style="color:white !important"
                        data-delete
                        data-confirmation="notie"
                        @click="AddInDemand(row.id , type = 'med_category')"
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
            <button
              type="submit"
              class="btn btn-primary"
              @click.prevent="submitCat"
            >submit</button>
          </template>
        </div>
      </sweet-modal>

      <div v-if="Read == 1" class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputUserName">Add New Category</label>
                  <input
                    id="inputUserName"
                    v-model.trim="form.category_name"
                    type="text"
                    class="form-control"
                    placeholder="User Name"
                  >

                </div>
                <div class="form-group col-md-12">
                  <label >Add to In-Demand</label>
                  <toggle-button :value="form.in_demand"
                                 :sync="true"
                                 :labels="{checked: 'Yes', unchecked: 'No'}"
                                 v-model.trim="form.in_demand"
                                 color="#1a1a44"
                                 class="toggleStyle"
                  />
                </div>
              </div>

              <button
                type="submit"
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
        in_demand: false,
        category_name: ''
      },
      cat_form: {
        id: '',
        cat_name: '',
        image: '',
        submitBtn: 'update'
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
        let response = await window.axios.post('/api/admin/medicines/cat/add', {
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
    async submitCat () {
      try {
        // alert(this.form.UID);
        let response = await window.axios.post('/api/admin/medicines/cat/update', {
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
    async rentalEquipmentPrice (name, id, image) {
      this.cat_form.cat_name = name
      this.cat_form.id = id
      this.cat_form.image = image

      this.$refs.popup.open(name, id, image)
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
        const response = await axios.get(`/api/admin/medicines/catGet/get?page=${page}&filter=${filter}`)

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
        let response = await window.axios.delete('/api/admin/medicines/delCate/' + id)
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
    }
    //  openprmodel(id) {

    //    this.form.UID = id;
    //       this.$refs.dark_html_modal_statuscomm.open();
    //     },

  }
}
</script>
