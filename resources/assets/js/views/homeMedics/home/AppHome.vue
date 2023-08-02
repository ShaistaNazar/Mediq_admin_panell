<template>
  <div>
    <slider/>
    <holistic-digital/>
    <health-care/>
    <proposition/>
    <products-offer/>
    <gallery/>
    <blog/>
    <contact-us/>
  </div>
</template>

<script>
import Slider from '../../layouts/partials/Slider'
import HolisticDigital from './HolisticDigital'
import HealthCare from './HealthCare'
import Proposition from './Proposition'
import ProductsOffer from './ProductsOffer'
import Gallery from './Gallery'
import Blog from './Blog'
import ContactUs from './ContactUs'
export default {
  components: {
    Slider, HolisticDigital, HealthCare, Proposition, ProductsOffer, Gallery, Blog, ContactUs
  }
}
</script>
