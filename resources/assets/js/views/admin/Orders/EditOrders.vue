<template>
  <div  class="main-content">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-4 float-left">
          <div class="card">
            <div class="card-header cardClr">
              <span class="text-center  order-d">
                Total Amount :
                <b class="text-white bg-dark">{{allData.total_amount}}</b>
              </span>
            </div>
          </div>
        </div>

        <div class="col-md-4 float-left">
          <div class="card">
            <div class="card-header cardClr">
              <span class="text-center order-d">
                Order Status :
                <b v-if="allData.status">{{allData.status.status}}</b>
                <b v-else>{{"No status"}}</b>
              </span>
            </div>
          </div>
        </div>

        <div class="col-md-4 float-left">
          <div class="card">
            <div class="card-header cardClr">
              <span class="text-center order-d">
                Date & Time :
                <b>{{allData.created_at}}</b>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 order-d">
        <div class="col-md-6 float-left">
          <div class="card">
            <div class="card-header cardClr">
              <span class="text-center order-d">
                Payment Method Details :
                <b v-if="allData.payment_methods">{{allData.payment_methods.name}}</b>
                <b v-else>Not selected</b>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-6 float-left">
          <div class="card" ref="card">
            <div class="card-header cardClr">
              <span class="text-center order-d">
                Selected Delivery Type :
                <b v-if="allData.deliv_products">{{allData.deliv_products.delivery_types}}</b>
                <b v-else>{{"Home Delivery"}}</b>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 order-d">
          <div class="card">
            <div class="card-header cardClr sizeFix text-center">
              <a
                v-b-popover.hover="'Order Confirmed?'"
                class="btn btn-info btn-md col-sm-3"
                data-delete
                data-confirmation="notie"
                @click="ChnageStatus(1,allData.order_number)"
              >Order Confirmed?</a>
              <a
                v-b-popover.hover="'Mark Complete'"
                class="btn btn-success btn-md col-sm-3"
                data-delete
                data-confirmation="notie"
                @click="ChnageStatus(4,allData.order_number)"
              >Mark Complete</a>
              <a
                v-b-popover.hover="'DELETE'"
                class="btn btn-secondary btn-md col-sm-3"
                data-delete
                data-confirmation="notie"
                @click="ChnageStatus(1,allData.order_number)"
              >Mark Cancel</a>
            </div>
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <div class="card-header cardClr">
            <h6  class="order-d">Medicines Order</h6>
            <div class="card-actions" />
          </div>
          <div class="card-body">
            <table-component
              :data="getMedicsordersDetail"
              sort-by="row.id"
              sort-order="desc"
              table-class="table"
            >
            <table-column :sortable="false" :filterable="false" label="Medicine Image">
                <template slot-scope="row">
                  
                      <img
                        @error="onImageLoadFailure($event)"
                        height="50"
                        :src=" imageLink + row.med_products.medicine_image"
                      />
                    
                </template>
              </table-column>
              <table-column 
                :sortable="false"
                :filterable="false" label="Medicine Name">
                <template slot-scope="row">
                    {{row.med_products.medicine_name}}                
                </template>
              </table-column>

              <table-column 
                :sortable="false"
                :filterable="false" label="Price">
                <template slot-scope="row">{{row.med_products.price}}
                </template>
              </table-column>

              <table-column 
                :sortable="false"
                :filterable="false" label="Expiry Date">
                <template slot-scope="row">
                  {{row.med_products.expairy_date}}
                </template>
              </table-column>

              <table-column 
                :sortable="false"
                :filterable="false" label="Quantity Ordered">
                <template slot-scope="row">{{row.quantity}}
                </template>
              </table-column>

              <!-- <table-column 
                :sortable="false"
                :filterable="false" label="Brand">
                <template slot-scope="row">{{row.med_products.brand}}
                </template>
              </table-column> -->

              <table-column 
                :sortable="false"
                :filterable="false" label="Prescription Required ?">
                <template slot-scope="row">
                  
                      <div v-if="row.med_products.is_prescription_req == 1">Yes</div>
                      <div v-else>No</div>
                    
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label>
                <template slot-scope="row">
                  <div class="table__actions popup">
                    
                      <div v-if="row.med_products.is_prescription_req == 1">
                        <a
                          v-b-popover.hover="'Prescription'"
                          class="btn btn-default btn-sm"
                          @click="popupOpen(row.id, allData.prescription.prescription_path)"
                        >
                          <i class="icon-fa icon-fa-file-powerpoint-o" />
                        </a>
                       
                      </div>
                      <div v-else>~~~</div>
                  
                  </div>
                </template>
              </table-column>
              <!-- Popup 1 Modal bidding listing end  -->
            </table-component>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <div class="card-header cardClr">
            <h6 class="order-d">Equipments Order</h6>
            <div class="card-actions" />
          </div>
          <div class="card-body">
            <table-component
              :data="getEquipordersDetail"
              sort-by="row.id"
              sort-order="desc"
              table-class="table"
            >
              <table-column :sortable="false" :filterable="false" label="Equipment Image">
                <template slot-scope="row">
                  
                      <img
                        @error="onImageLoadFailure($event)"
                        height="50"
                        :src=" imageLink + row.equ_products.image"
                      />
                    
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="Equipment Name">
                <template slot-scope="row">
                    <div class="heightCustom"
                    >{{row.equ_products.equipment_name}}</div>
               
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="Price">
                <template slot-scope="row">
                  <div class="heightCustom">
                    {{row.equ_products.price}}</div>
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="Quantity Ordered">
                <template slot-scope="row">
                  <div class="heightCustom">
                    {{row.quantity}}
                  </div>
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="Brand">
                <template slot-scope="row">
                  <div class="heightCustom">
                    {{row.equ_products.brand}}
                  </div>
                </template>
              </table-column>
            </table-component>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <div class="card-header cardClr">
            <h6 class="order-d">Tests Order</h6>
            <div class="card-actions" />
          </div>
          <div class="card-body">
            <table-component
              :data="getLabTestordersDetail"
              sort-by="row.id"
              sort-order="desc"
              table-class="table"
            >
              <table-column :sortable="false" :filterable="false" label="Test Name">
                <template slot-scope="row">
                  {{row.test_products.test_name}}
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="Test Price">
                <template slot-scope="row">
                  {{row.test_products.price}}
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="Quantity Ordered">
                <template slot-scope="row">
                  {{row.quantity}}
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="Selected Lab">
                <template slot-scope="row">
                  {{row.test_products.labs.lab_name}}
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="Prescription Required ?">
                <template slot-scope="row">
                      <div v-if="row.test_products.is_prescription_req == 1">Yes</div>
                      <div v-else>No</div>
                </template>
              </table-column>

            </table-component>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <div class="card-header cardClr">
            <h6 class="order-d">Other Medicine Order</h6>
            <div class="card-actions" />
          </div>
          <div class="card-body">
            <table-component
              :data="getOtherMedDetail"
              sort-by="row.id"
              sort-order="desc"
              table-class="table"
            >
             

              <table-column :sortable="false" :filterable="false" label="Medicine Name">
                <template slot-scope="row">
                    <div class="heightCustom"
                    >{{row.other_medicines.medicine_name}}</div>
               
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="Price">
                <template slot-scope="row">
                  <div class="heightCustom">
                    {{row.other_medicines.price}}</div>
                </template>
              </table-column>

              <table-column :sortable="false" :filterable="false" label="Quantity Ordered">
                <template slot-scope="row">
                  <div class="heightCustom">
                    {{row.quantity}}
                  </div>
                </template>
              </table-column>
               <table-column :sortable="false" :filterable="false" label>
                <template slot-scope="row">
                  <div class="table__actions popup">
                    
                      <div v-if="row.other_medicines.is_prescription_req == 1">
                        <a
                          v-b-popover.hover="'Prescription'"
                          class="btn btn-default btn-sm"
                          @click="popupOpen(row.id, allData.prescription.prescription_path)"
                        >
                          <i class="icon-fa icon-fa-file-powerpoint-o" />
                        </a>
                       
                      </div>
                      <div v-else>~~~</div>
                  
                  </div>
                </template>
              </table-column>
            </table-component>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- <div class="col-sm-12"> -->
        <div class="col-lg-4 col-md-6  col-sm-12">
          <div class="card">
            <div class="card-header cardClr">
              <h6 class="order-d">Ordered By</h6>
              <div class="card-actions" />
            </div>
            <div class="card-body ">
              <!-- <div id class="container-fluid col-sm-12" align="center"> -->
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-address-book" />
                        <b>Name:</b>

                </div>
                <div class="detail col-md-8">
                  <span v-if="allData.users && allData.users.full_name"> {{allData.users.full_name}}</span>
                  <span v-else>{{NotAvailabe}}</span>
                </div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-envelope" />
                        <b>Email:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.users && allData.users.email">{{allData.users.email}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-road" />
                        <b>City:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.users && allData.users.city">{{allData.users.city}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-mobile-phone" />
                        <b>Phone:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.users && allData.users.phone">{{allData.users.phone}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-mars-stroke" />
                        <b>Gender:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.users && allData.users.gender">{{allData.users.gender}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                
                
                <!-- -----------------left table ends here--------------------- -->
              <!-- </div> -->
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6  col-sm-12">
          <div class="card">
            <div class="card-header cardClr">
              <h6 class="order-d">Shipping Details</h6>
              <div class="card-actions" />
            </div>
            <div class="card-body ">
              <!-- <div id class="container-fluid col-sm-12" align="center"> -->
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-address-book" />
                        <b>Name:</b>

                </div>
                <div class="detail col-md-8">
                  <span v-if="allData.shipping && allData.shipping.first_name">{{allData.shipping.first_name}}</span>
                  <span v-else>{{NotAvailabe}}</span>

                </div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-envelope" />
                        <b>Email:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.shipping && allData.shipping.email">{{allData.shipping.email}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-road" />
                        <b>City:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.shipping && allData.shipping.city">{{allData.shipping.city}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-mobile-phone" />
                        <b>Phone:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.shipping && allData.shipping.phone">{{allData.shipping.phone}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-street-view" />
                        <b>Address:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.shipping && allData.shipping.home_address">{{allData.shipping.home_address}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                
                
                <!-- -----------------left table ends here--------------------- -->
              <!-- </div> -->
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6  col-sm-12">
          <div class="card">
            <div class="card-header cardClr">
              <h6 class="order-d">Billing Details</h6>
              <div class="card-actions" />
            </div>
            <div class="card-body ">
              <!-- <div id class="container-fluid col-sm-12" align="center"> -->
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-address-book" />
                        <b>Name:</b>

                </div>
                <div class="detail col-md-8">
<span v-if="allData.billing && allData.billing.first_name">{{allData.billing.first_name}}</span>
                  <span v-else>{{NotAvailabe}}</span>
                </div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-envelope" />
                        <b>Email:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.billing && allData.billing.email">{{allData.billing.email}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-road" />
                        <b>City:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.billing && allData.billing.city">{{allData.billing.city}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-mobile-phone" />
                        <b>Phone:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.billing && allData.billing.phone">{{allData.billing.phone}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                <hr>
                <div class="infor-detail row">
                  <div class="heading col-md-4">
                  <i class="icon-fa icon-fa-street-view" />
                        <b>Address:</b>

                </div>
                     <div class="detail col-md-8" v-if="allData.billing && allData.billing.home_address">{{allData.billing.home_address}}</div>
                     <div class="detail col-md-8" v-else>{{NotAvailabe}}</div>
                </div>
                
                
                <!-- -----------------left table ends here--------------------- -->
              <!-- </div> -->
            </div>
          </div>
        </div>

         <sweet-modal ref="popup" modal-theme="dark" overlay-theme="dark">
                          <div class="card-header">
                            <div class="card-actions" />
                          </div>
                          <div class="card-body">
                            <template slot-scope>
                              <div>
                                <img
                                  @error="onImageLoadFailure($event)"
                                  height="400"
                                  :src=" mobileImageLink + imgIndex"
                                />
                              </div>
                            </template>
                          </div>
                        </sweet-modal>
                        <sweet-modal ref="popupTest" modal-theme="dark" overlay-theme="dark">
                          <div class="card-header">
                            <div class="card-actions" />
                          </div>
                          <div class="card-body">
                            <template slot-scope>
                              <div>
                                <img
                                  @error="onImageLoadFailure($event)"
                                  height="400"
                                  :src=" imageLink + testImg"
                                />
                              </div>
                            </template>
                          </div>
                        </sweet-modal>
      <!-- </div> -->
    </div>
  </div>
</template>


<script type="text/babel">
import { TableComponent, TableColumn } from "vue-table-component";
import {  imageLink, mobileImageLink } from "../../../helpers/constants";
import { SweetModal, SweetModalTab } from "sweet-modal-vue";
import Vue from "vue";
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import Ls from "../../../services/ls";
import moment from "moment";

Vue.use(BootstrapVue);

export default {
  components: {
    TableComponent,
    TableColumn,
    SweetModal,
    SweetModalTab
  },
  data() {
    return {
      testIndex: "",
      testImg: "",
       imageLink: imageLink,
       mobileImageLink: mobileImageLink,
      imgIndex: "",
      idIndex: "",
      form: {},
      allData: "",
      User: "",
      Services: "",
      Medicines: "",
      tests: "",
      Equipments: "",
      Details: "",
      Shipping: "",
      Billing: "",
      Status: "",
      Delivery: "",
      payment_methods: "",
      NotAvailabe: "Not Given",

      Read: "",
      Write: "",
      Delete: "",
      orders: []
    };
  },
  install(Vue, options) {
    Vue.component("SweetModal", SweetModal);
    Vue.component("SweetModalTab", SweetModalTab);
  },
  mounted() {
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
    this.getorders();
    // this.getordersDetail();
  },
  methods: {
    async getorders() {
      try {
        let ID = this.$route.params.OrdersId;
        const response = await axios.get(`/api/admin/orders/singleOrder/${ID}`);
        this.allData = response.data[0];
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },

    async getordersDetail({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/orders/get?page=${page}&filter=${filter}`
        );
        return {
          data: response.data.data,
          pagination: {
            totalPages: response.data.last_page,
            currentPage: page,
            count: response.data.count
          }
        };
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },

    async getMedicsordersDetail() {
      try {
        let ID = this.$route.params.OrdersId;
        const response = await axios.get(
          `/api/admin/orders/medicOrder/${ID}`
        );
        return {
          data: response.data[0].med_details,

        };
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async getEquipordersDetail() {
      try {
        let ID = this.$route.params.OrdersId;
        const response = await axios.get(
          `/api/admin/orders/equipOrder/${ID}`
        );
        return {
          data: response.data[0].equip_details,
        };
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async getOtherMedDetail() {
      try {
        let ID = this.$route.params.OrdersId;
        const response = await axios.get(
          `/api/admin/orders/otherMedOrder/${ID}`
        );
        return {
          data: response.data[0].other_medicine_details,
        };
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async getLabTestordersDetail() {
      try {
        let ID = this.$route.params.OrdersId;
        const response = await axios.get(
          `/api/admin/orders/labtestOrder/${ID}`
        ); 
        // console.log(response.data[0].labs_test_details)
        return {
          data: response.data[0].labs_test_details,
        };
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },

    ChnageStatus(val,order) {
      let self = this;
      window.notie.confirm({
        text: "Are you sure?",
        cancelCallback: function() {},
        submitCallback: function() {
          self.ChnageStatusFun(val,order);
        }
      });
    },
    async ChnageStatusFun(val,order) {
      try {
        let id = this.$route.params.OrdersId;
        let response = await window.axios.post("/api/admin/orders/status/", {
          data: id,
          order: order,
          val
        });
        // this.orders = response.data;
        window.toastr["success"]("Status Changed", "Success");
        this.getorders();
        // this.$refs.card.refresh();
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    formatter(value, rowProperties) {
      return moment(value).format("Do MMM YYYY, hh : mm a");
    },
    timeFormatter(value, rowProperties) {
      return moment(value).format("HH : mm");
    },
    onImageLoadFailure(event) {
      event.target.src = this.imageLink + "users/no-photo.jpg";
    },
    popupOpen(id, img) {
      this.idIndex = id;
      this.imgIndex = img;

      this.$refs.popup.open(this.imgIndex);
    },
    popupOpenTest(id, img) {
      this.testIndex = id;
      this.testImg = img;
      this.$refs.popupTest.open(this.imgIndex);
    }
  }
};
</script>
