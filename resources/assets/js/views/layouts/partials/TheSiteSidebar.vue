<template>
  <div v-if="Read == 1" class="sidebar-left">
    <div class="sidebar-body scroll-pane">
      <div class="side-nav">
        <v-collapse accordion>

          <v-collapse-item active-url="/dashboard">
            <router-link
              slot="item-title"
              to="/dashboard">
              <i class="icon-fa icon-fa-dashboard"/>Dashboard
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/users">
            <router-link
              slot="item-title"
              to="/users">
              <i class="icon-fa icon-fa-users"/>Users
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/employees">
            <router-link
              slot="item-title"
              to="/employees">
              <i class="icon-fa icon-fa-briefcase"/>Employees
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/providers">
            <router-link
              slot="item-title"
              to="/providers">
              <i class="icon-fa icon-fa-address-card"/>Service Providers
            </router-link>
          </v-collapse-item>

          <!-- <v-collapse-item active-url="/medicines">
            <router-link
              slot="item-title"
              to="/medicines">
              <i class="icon-fa icon-fa-plus-square"></i>Medicines
            </router-link>
          </v-collapse-item> -->

          <v-collapse-item active-url="/medicines">
            <a slot="item-title" href="#"
            >
              <i class="icon-fa icon-fa-plus-square"/>Medicines
              <span class="icon-fa arrow"/>
            </a>

            <router-link to="/medicines">
              Medicines
            </router-link>

            <router-link to="/MiscellaneousMedicines">
              Miscellaneous Medicines
            </router-link>

          </v-collapse-item>

          <v-collapse-item active-url="/prescriptions">
            <router-link
              slot="item-title"
              to="/prescriptions">
              <i class="icon-fa icon-fa-file-powerpoint-o"/>Prescriptions
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/equipments">
            <router-link
              slot="item-title"
              to="/equipments">
              <i class="icon-fa icon-fa-stethoscope"/>Equipments
            </router-link>
          </v-collapse-item>

          <!--
          <v-collapse-item active-url="/Laboratories">
            <router-link
              slot="item-title"
              to="/Laboratories">
              <i class="icon-fa icon-fa-medkit"/>Laboratories
            </router-link>
          </v-collapse-item> -->

          <!-- <v-collapse-item active-url="/Tests">
            <router-link
              slot="item-title"
              to="/Tests">
              <i class="icon-fa icon-fa-sticky-note-o">
                 <span class="icon-fa arrow icon-fa-fw"/>
                </i>Laboratory Tests
            </router-link>
          </v-collapse-item> -->

          <v-collapse-item active-url="/Tests">
            <a slot="item-title" href="#"
            >
              <i class="icon-fa icon-fa-sticky-note-o"/>Lab-Test Management
              <span class="icon-fa arrow"/>
            </a>

            <router-link to="/Laboratories">
              Laboratories
            </router-link>

            <router-link to="/Tests">
              Lab Tests
            </router-link>

            <router-link to="/UserTestReports">
              User Test Reports
            </router-link>

            <!-- <router-link to="/reports/BlockedReports">
                Blocked User's
              </router-link> -->

            <!-- <router-link to="/reports/SubscriptionReports">
                Subscription's Report
              </router-link> -->

          </v-collapse-item>

          <v-collapse-item active-url="/Services">
            <router-link
              slot="item-title"
              to="/Services">
              <i class="icon-fa icon-fa-th-large"/>H-M Services
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/orders">
            <a slot="item-title" href="#"
            >
              <i class="icon-fa icon-fa-sticky-note-o"/>Orders
              <span class="icon-fa arrow"/>
            </a>
            <router-link to="/Orders">
              Medicine, Equipment & Tests Orders
            </router-link>
            <router-link to="/hmServiceOrders">
              H-M Services Orders
            </router-link>
            <router-link
              to="/rentalEquipments">
              Rental Equipments Orders
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/Reports">
            <a slot="item-title" href="#"
            >
              <i class="icon-fa icon-fa-file"/>Reports
              <span class="icon-fa arrow"/>
            </a>

            <router-link to="/ProductOrderReport">
              Products Order Report
            </router-link>

            <router-link to="/ServiceOrderReport">
              Service Order Report
            </router-link>
            <router-link to="/rentalEquipmentsReport">
              Rental Equipments Report
            </router-link>
            <router-link to="/HighestGrossingProductReport">
              Highest Grossing Product Report
            </router-link>

            <!-- <router-link to="/Tests">
                Lab Tests
              </router-link>

               <router-link to="/UserTestReports">
                User Test Reports
              </router-link> -->

          </v-collapse-item>

          <v-collapse-item active-url="/cities">
            <router-link
              slot="item-title"
              to="/cities">
              <i class="icon-fa icon-fa-road"/>Cities
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/MakePromotion">
            <router-link
              slot="item-title"
              to="/MakePromotion">
              <i class="icon-fa icon-fa-bolt"/>Promotion
            </router-link>
          </v-collapse-item>

          <!-- <v-collapse-item active-url="/roleslist">
            <router-link
              slot="item-title"
              to="/roleslist">
              <i class="icon-fa icon-fa-lock"></i>Portal Access Control
            </router-link>
          </v-collapse-item> -->

          <!-- <router-link to="/reports/SubscriptionReports">
                Subscription's Report
              </router-link> -->

          <!-- </v-collapse-item>

            <v-collapse-item active-url="/ranking">
              <router-link
                slot="item-title"
                to="/ranking">
                <i class="icon-fa icon-fa-percent"/>Rankings
              </router-link>
            </v-collapse-item>

            <v-collapse-item active-url="/users/abuse">
              <router-link
                slot="item-title"
                to="/users/abuse">
                <i class="icon-fa icon-fa-envelope"/>User Reports/Abuse
              </router-link>
            </v-collapse-item>
          -->

          <!-- <v-collapse-item active-url="/rentalEquipments">
            <router-link
              slot="item-title"
              to="/rentalEquipments">
              <i class="icon-fa icon-fa-cog"/>Rental Equipments
            </router-link>
          </v-collapse-item>  -->

          <v-collapse-item active-url="/inDemand">
            <router-link
              slot="item-title"
              to="/inDemand">
              <i class="icon-fa icon-fa-stethoscope"/>In-Demand
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/cms">
            <router-link
              slot="item-title"
              to="/cms">
              <i class="icon-fa icon-fa-clipboard"/>CMS
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/blogs">
            <router-link
              slot="item-title"
              to="/blogs">
              <i class="icon-fa icon-fa-file"/>Blogs
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/contactUs">
            <router-link
              slot="item-title"
              to="/contactUs">
              <i class="icon-fa icon-fa-envelope"/>Emails
            </router-link>
          </v-collapse-item>
          <!-- <v-collapse-item active-url="/Complaint">
            <router-link
              slot="item-title"
              to="/Complaint">
              <i class="icon-fa icon-fa-comments"/>Complaints
            </router-link>
          </v-collapse-item>  -->


        </v-collapse>
      </div>
    </div>
  </div>
  <div v-else class="alert alert-info" role="alert">
    Sorry! you dont have permission
  </div>
</template>
<script type="text/javascript">
import Ls from '../../../services/ls'
import { TableComponent, TableColumn } from 'vue-table-component'
import {imageLink} from '../../../helpers/constants'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
// import moment from 'moment';

export default {
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      users: [],
      imagelink: imageLink,
      auth_user: []
    }
  },

  mounted () {
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
  },
  methods: {
  }
}
</script>
