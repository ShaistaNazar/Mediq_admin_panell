<template>
  <div>
    <slider/>
    <latest-updates/>
    <gallery/>
    <blog/>
    <contact-us/>
  </div>
</template>

<script>
import Slider from '../../layouts/partials/Slider'
import LatestUpdates from './LatestUpdates'
import Gallery from '../home/Gallery'
import Blog from '../home/Blog'
import ContactUs from '../home/ContactUs'
export default {
  components: {
    Slider, LatestUpdates, Gallery, Blog, ContactUs
  }
}
</script>
