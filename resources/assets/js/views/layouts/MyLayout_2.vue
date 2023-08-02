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
import SiteHeader from './partials/TheAppHeader.vue'

export default {
  components: {
    SiteHeader
  },
  mounted () {
    this.$utils.setLayout('default')
  }
}
</script>
