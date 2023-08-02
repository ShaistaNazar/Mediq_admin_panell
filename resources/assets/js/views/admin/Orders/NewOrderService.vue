<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">New Order For Home-Medical Service</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/hmServiceOrders"><a>Orders</a></router-link></li>
        <li class="breadcrumb-item active">New Order</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-8 hide">
        <div class="card">
          <!-- <div class="card-header">
            <h6>Enter Name of City</h6>
          </div> -->
          <div class="card-body">
            <form ref="city" @submit.prevent="submit">
              <div class="form-row">

                <div class="form-group col-md-6">
                  <label for="inputFirstName">Requester Name*</label>
                  <input
                    id="inputFirstName"
                    :class="{ 'is-invalid': $v.form.name.$error }"
                    v-model.trim="form.name"
                    type="text"
                    class="form-control"
                    minlength="4"
                    maxlength="15"
                    placeholder="First Name"
                    @input="$v.form.name.$touch()"
                  >
                  <div v-if="$v.form.name.$error">
                    <span v-if="!$v.form.name.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.name.minLength" class="help-block help-block-error">
                      Name must have at least {{ $v.form.name.$params.minLength.min }} letters.
                    </span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputFirstName">Requester Phone* <small>Format : 923001234567</small></label>
                  <input
                    id="inputFirstName"
                    :class="{ 'is-invalid': $v.form.phone.$error }"
                    v-model.trim="form.phone"
                    type="tel"
                    pattern="[0-9]{2}[0-9]{3}[0-9]{7}"
                    class="form-control"
                    placeholder="Enter Phone"
                    @input="$v.form.phone.$touch()"
                  >
                  <div v-if="$v.form.phone.$error">
                    <span v-if="!$v.form.phone.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.phone.minLength" class="help-block help-block-error">
                      phone must have at least {{ $v.form.phone.$params.minLength.min }} letters.
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-row">

                <div class="form-group col-md-12">
                  <label for="inputEmail">Select Service Provider*</label>
                  <select
                    id="inputRole"
                    v-model.trim="form.selectedSer"
                    required
                    class="form-control"
                    placeholder="Select City"
                  >
                    <option disabled value>Service Providers*</option>
                    <option
                      v-for="(OneCat, OneCatIndex) in services"
                      :key="OneCatIndex"
                      :value="OneCat"
                    >{{ OneCat.providers_data.service_name }} | {{ OneCat.full_name }} | {{ OneCat.phone }}</option>
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <label for="inputAmount">Total Amount*</label>
                  <input
                    id="inputAmount"
                    v-model.trim="form.TotalAmount"
                    type="number"
                    min="0"
                    class="form-control"
                    placeholder="Total Amount"
                  >
                  <div v-if="$v.form.TotalAmount.$error">
                    <span v-if="!$v.form.TotalAmount.required" class="help-block help-block-error">
                      Field is required
                    </span>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="inputFirstName">Comments From Requester*</label>
                  <b-form-textarea
                    id="inputFirstName"
                    :class="{ 'is-invalid': $v.form.comments.$error }"
                    v-model.trim="form.comments"
                    type="text"
                    class="form-control"
                    rows="3"
                    max-rows="6"
                    placeholder="Enter Comments"
                    @input="$v.form.comments.$touch()"
                  />
                  <div v-if="$v.form.comments.$error">
                    <span v-if="!$v.form.comments.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.comments.minLength" class="help-block help-block-error">
                      comments must have at least {{ $v.form.comments.$params.minLength.min }} letters.
                    </span>
                  </div>
                </div>
              </div>

              <button :disabled="$v.form.$invalid" type="submit" class="btn btn-primary" >{{ form.submitBtn }}</button>
              <b-button type="button" @click.prevent="cancel" >Cancel</b-button>
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
      services: '',
      form: {
        name: '',
        orderFrom: '',
        phone: '',
        TotalAmount: '',
        selectedSer: '',
        comments: '',
        submitBtn: 'Submit'
      }
    }
  },
  validations: {
    form: {
      name: {
        required,
        minLength: minLength(4)
      },
      phone: {
        required,
        minLength: minLength(11)
      },
      selectedSer: {
        required
      },
      comments: {
        required,
        minLength: minLength(20)
      },
      TotalAmount: {
        required
      }

    }
  },
  mounted () {
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
    // alert(Ls.get("auth.admin_id"))
    this.LoadAllServices()
  },
  methods: {
    async submit () {
      this.$v.form.$touch()
      if (this.$v.form.$error) return
      try {
        this.orderFrom = Ls.get('auth.admin_id')
        let response = await window.axios.post('/api/admin/orders/serviceOrder/add', {
          data: this.form
        })
        window.toastr['success']('New Order Added', 'Success')
        this.$router.push('/hmServiceOrders')
      } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
        }
      }
    },
    async cancel () {
      this.$router.push('/hmServiceOrders')
    },
    async LoadAllServices () {
      try {
        const response = await axios.get(
          `/api/admin/providers/dropdownOfProv/get`)
        this.services = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    }
  }
}
</script>
