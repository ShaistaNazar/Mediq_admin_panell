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
        id="logo-mobile"
        src="/assets/img/logo-internal.png"
        alt="Laraspace Logo"
        class="d-md-none"
      >
    </a>
    

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
