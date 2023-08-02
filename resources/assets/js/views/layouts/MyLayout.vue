<template>
  <div class="template-container">
    <site-header/>
    <transition name="fade" mode="out-in">
      <router-view/>
    </transition>
    <site-footer/>
  </div>
</template>
<script type="text/babel">
import SiteHeader from './partials/MyHeader.vue'
import SiteFooter from './partials/TheSiteFooter.vue'
import SiteSidebar from './partials/TheSiteSidebar.vue'

export default {
  components: {
    SiteHeader, SiteFooter
  },
  mounted () {
    this.$utils.setLayout('default')
  }
}
</script>
