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

  </header>
</template>
<script type="text/babel">
import Auth from '../../../services/auth'
import {imageLink} from '../../../helpers/constants'
import Ls from '../../../services/ls'
export default {
  data () {
    return {
      imagelink: imageLink,
      profilepicture: ''
    }
  },
  mounted: function () {
    this.profilepicture = Ls.get('auth.profile_picture')
    this.adminId = Ls.get('auth.admin_id')
  },
  methods: {
    onNavToggle () {
      this.$utils.toggleSidebar()
    },
    onImageLoadFailure (event) {
      event.target.src = this.imagelink + 'users/no-photo.jpg'
    },
    logout () {
      Auth.logout().then(() => {
        this.$router.replace('/login')
      })
    }
  }
}
</script>
