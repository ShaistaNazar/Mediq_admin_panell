<template>
  <div class="container">
    <div class="row section2-pt">
      <div class="col-md-6 header-section">
        <img src="images/Logo2.png" alt class="img-fluid">
        <p
          style="padding-top: 10px;"
          class="services-text"
        >mediQ Home is on demand availability of quality healthcare services at your door step with the ease of payment. You are provided with ‘smart healthcare’ at home on click of a button.</p>
        <inquiry-button />
      </div>
      <div class="col-md-6">
        <img src="images/7.png" alt="header image" class="img-fluid pt-5">
      </div>
    </div>
  </div>
</template>

<script>
import inquiryButton from '../../layouts/partials/InquiryButton'
export default {
  components: {
    inquiryButton
  }
}
</script>
