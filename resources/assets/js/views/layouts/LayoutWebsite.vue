<template>
  <div class="template-container">
    <web-navbar/>
    <router-view/>
    <web-footer/>
  </div>
</template>

<script>

import WebNavbar from './partials/TheWebNavbar.vue';
import WebFooter from './partials/TheWebFooter.vue';

export default {
  components: {
    WebNavbar, WebFooter
  }
}
</script>
