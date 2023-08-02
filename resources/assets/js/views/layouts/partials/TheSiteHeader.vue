<template>
  <header class="site-header">
    <a href="#" class="brand-main">
      <img
        id="logo-desk"
        src="/assets/img/logo-internal.png"
        alt="Laraspace Logo"
        class="d-none d-md-inline"
      >

       <img
        id="logo-desk"
        src="/assets/img/textLogo.png"
        alt="Laraspace Logo"
        class="d-none d-md-inline textLogo"
        title="Home Medics"
      >
      
      <img
        id="logo-mobile"
        src="/assets/img/logo-internal.png"
        alt="Laraspace Logo"
        class="d-md-none"
      >
    </a>
    <a
      href="#"
      class="nav-toggle"
      @click="onNavToggle"
    >
      <div class="hamburger hamburger--arrowturn">
        <div class="hamburger-box">
          <div class="hamburger-inner"/>
        </div>
      </div>
    </a>
    <ul class="action-list">

      <!-- <li class="background_color">
        <v-dropdown :show-arrow="false">
          <a
            slot="activator"
            href="#"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="icon-fa icon-fa-bell"/>
          </a>
          <div class="notification-dropdown">
            <h6 class="dropdown-header">
              Notifications
            </h6>
            <v-dropdown-item>
              <a class="dropdown-item" href="#">
                <i class="icon-fa icon-fa-user"/> Abusive Chat Reports
              </a>
            </v-dropdown-item>
            <v-dropdown-item>
              <a class="dropdown-item" href="#">
                <i class="icon-fa icon-fa-comment"/> A Comment has been posted.
              </a>
            </v-dropdown-item>
          </div>
        </v-dropdown>
      </li> -->
      <li>
        <v-dropdown :show-arrow="false">
          <!-- <div class="img-size"> -->
          <a
            slot="activator"
            href="#"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            class="avatar"
          >
            <img  @error="onImageLoadFailure($event)"   :src="imagelink + profilepicture" class="img-size"/>

          </a>
          <!-- </div> -->
          <v-dropdown-item>
            <router-link class="dropdown-item" to="/settings">
              <i class="icon-fa icon-fa-cogs"/> Settings
            </router-link>
          </v-dropdown-item>
          <v-dropdown-item>
            <a
              href="#"
              class="dropdown-item"
              @click.prevent="logout"
            >
              <i class="icon-fa icon-fa-sign-out"/> Logout 
            </a>
          </v-dropdown-item>
          
        </v-dropdown>
      </li>
    </ul>
  </header>
</template>
<script type="text/babel">
import Auth from '../../../services/auth'
import {imageLink} from '../../../helpers/constants'
import Ls from '../../../services/ls'
import { serverBus } from '../../../app';
export default {
 data () {
  return {
    imagelink :imageLink,
    profilepicture : ''
  }
  },
  mounted: function() {
    this.profilepicture  = Ls.get('auth.avatar')
    this.adminId  = Ls.get('auth.admin_id')
  },
  created() {
  // Using the server bus
  serverBus.$on('serverSelected', (server) => {
   this.profilepicture = server;
  });
 },
  methods: {
    onNavToggle () {
      this.$utils.toggleSidebar()
    },
    onImageLoadFailure (event) {
        event.target.src = this.imagelink + 'users/no-photo.jpg';
    },
    logout () {
      Auth.logout().then(() => {
        this.$router.replace('/login')
      })
    }
  }
}
</script>
