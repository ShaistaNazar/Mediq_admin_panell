<template>
  <div>
    <b-navbar toggleable="lg" type="light" fixed="top" class="tembus web-nav">
      <b-navbar-brand href="/home">
        <web-logo class="web-logo"/>
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"/>

      <b-collapse id="nav-collapse" is-nav>
        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-item :to="{ name: 'homeMedics'}" class="hvrcenter">Home</b-nav-item>
          <b-nav-item :to="{ name: 'home-services'}" class="hvrcenter">mediQ Home</b-nav-item>
          <b-nav-item :to="{ name: 'medi-pass'}" class="hvrcenter">mediQ Pay</b-nav-item>
          <b-nav-item :to="{ name: 'med-edu'}" class="hvrcenter">mediQ Edu</b-nav-item>
          <b-nav-item :to="{name: 'gallery'}" class="hvrcenter">Gallery</b-nav-item>
          <b-nav-item :to="{ name: 'blog'}" class="hvrcenter">Blog</b-nav-item>
          <b-nav-item :to="{ name: 'about-us'}" class="hvrcenter">About Us</b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
import WebLogo from './WebLogo'

export default {
  components: {
    WebLogo
  }
}
</script>
