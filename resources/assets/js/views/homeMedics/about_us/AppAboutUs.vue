<template>
  <div>
    <slider/>
    <about-us/>
    <gallery/>
    <blog/>
    <contact-us/>
  </div>
</template>

<script>
import Slider from '../../layouts/partials/Slider'
import AboutUs from './AboutUs'
import Gallery from '../home/Gallery'
import Blog from '../home/Blog'
import ContactUs from '../home/ContactUs'
export default {
  components: {
    Slider, AboutUs, Gallery, Blog, ContactUs
  }
}
</script>
