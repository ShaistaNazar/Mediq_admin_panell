<template>
  <div>
    <div class="container section-pt">
      <div class="row">
        <div class="col-md-6 header-section">
          <img
            src="images/mediq-pay.png"
            alt="mediq-pay"
            class="img-fluid"
          >
          <p class="services-text text-padding">Save on your medical spending by paying digitally through mobile wallets. Pay at mediQ's partner health service provider and get instant discount on every transaction.
          </p>
        </div>
        <div class="col-md-6">
          <img
            src="images/save.png"
            alt="header image"
            class="img-fluid pt-5"
          >
        </div>
      </div>
    </div>
    <div class="container-fluid bg-img">
      <div class="container quality-section">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1 class="quality-heading-one">Find Quality</h1>
            <h1 class="quality-heading-two">Healthcare Providers across Pakistan</h1>
            <p class="quality-paragraph">
              With hunderds of healthcare providers on-boarded, we have the
              <br>right one for you.
            </p>
            <div class="input-group form-group has-search">
              <!-- <font-awesome-icon
                icon="search"
                class="form-control-feedback"
              /> -->
              <div class="input-group-append">

                <select
                  id="inputRole"
                  v-model="selectedcity"
                  v-model.trim="form.selectedcity"
                  required
                  class="custome-dropdown"
                  placeholder="Select Category"
                >
                  <option value>Select City</option>
                  <option
                    v-for="(city, idX) in cities"
                    :key="idX"
                    :value="city.id"
                  >{{ city.city_name }}</option>
                </select>
              </div>
              <!-- <input type="text" class="form-search" placeholder="Click to find a Medical Provider" > -->
              <select
                id="inputRole"
                required
                class="form-search"
                placeholder="Click to find a Medical Provider"
              >
                <option value>Click to find a Medical Provider</option>
                <option
                  v-for="(service, idX) in services"
                  :key="idX"
                  :value="service.service_id"
                >{{ service.city_service.service_name }}</option>
              </select>
            </div>
            <!-- <div class="categories-section"/> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      cities: {},
      services: {},
      selectedcity: '',
      form: {
        selectedcity: '',
        selectedService: ''

      }

    }
  },
  watch: {
    selectedcity: function (val) {
      this.loadMedicineCategory()
    }
  },
  mounted () {
    this.getCities()
  },
  methods: {
    async getCities () {
      try {
        const response = await window.axios.get(`/api/getCitiesToShow`)
        this.cities = response.data
        // console.log(this.cities)
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async loadMedicineCategory () {
      try {
        const response = await window.axios.get(`/api/getCityServices?city_id=${this.form.selectedcity}`)
        // console.log(response)
        this.services = response.data
        // console.log(this.services)
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    }
  }
}
</script>
