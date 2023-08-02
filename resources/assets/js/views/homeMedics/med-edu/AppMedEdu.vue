<template>
  <div>
    <slider/>
    <health-education/>
    <gallery/>
    <blog/>
    <contact-us/>
  </div>
</template>

<script>
import Slider from '../../layouts/partials/Slider'
import HealthEducation from './HealthEducation'
import Gallery from '../home/Gallery'
import Blog from '../home/Blog'
import ContactUs from '../home/ContactUs'
export default {
  components: {
    Slider, HealthEducation, Gallery, Blog, ContactUs
  }
}
</script>
