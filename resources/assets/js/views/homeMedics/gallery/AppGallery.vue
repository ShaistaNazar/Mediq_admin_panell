<template>
  <div>
    <slider/>
    <view-gallery/>
    <!-- <gallery-image/> -->
    <gallery/>
    <blog/>
    <contact-us/>
  </div>
</template>

<script>
import Slider from '../../layouts/partials/Slider'
import ViewGallery from './ViewGallery'
// import GalleryImage from './GalleryImage'
import Gallery from '../home/Gallery'
import Blog from '../home/Blog'
import ContactUs from '../home/ContactUs'
export default {
  components: {
    Slider, ViewGallery, Gallery, Blog, ContactUs
  }
}
</script>
