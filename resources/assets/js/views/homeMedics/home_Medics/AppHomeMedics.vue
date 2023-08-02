<template>
  <div>
    <slider/>
    <home-service />
    <our-services />
    <download-app />
    <gallery />
    <blog />
    <contact-us />
  </div>
</template>

<script>
import Slider from '../../layouts/partials/Slider'
import HomeService from './HomeService'
import OurServices from './OurServices'
import DownloadApp from './DownloadApp'
import Gallery from '../home/Gallery'
import Blog from '../home/Blog'
import ContactUs from '../home/ContactUs'
export default {
  components: {
    Slider,
    HomeService,
    OurServices,
    DownloadApp,
    Gallery,
    Blog,
    ContactUs
  }
}
</script>
