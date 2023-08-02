<template>
  <div>
    <slider/>
    <find-quality/>
    <payment-method/>
    <payment-solution/>
    <gallery/>
    <blog/>
    <contact-us/>
  </div>
</template>

<script>
import Slider from '../../layouts/partials/Slider'
import FindQuality from './FindQuality'
import PaymentMethod from './PaymentMethod'
import PaymentSolution from './PaymentSolution'
import Gallery from '../home/Gallery'
import Blog from '../home/Blog'
import ContactUs from '../home/ContactUs'
export default {
  components: {
    Slider, FindQuality, PaymentMethod, PaymentSolution, Gallery, Blog, ContactUs
  }
}
</script>
