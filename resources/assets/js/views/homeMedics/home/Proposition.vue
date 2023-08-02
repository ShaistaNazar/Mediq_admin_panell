<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6 header-section">
        <h1 class="headings-color">
          <b>Our Value Proposition</b>
        </h1>
        <p class="services-text">We offer five primary value propositions:</p>
        <p class="medipass-para">
          Accessibility
          <span>,</span> Convenience
          <span>,</span> Customization
          <span>,</span>
          <br class="about-break-line">Cost reduction and Quality.
        </p>
        <inquiry-button />
      </div>
      <div class="col-md-6">
        <img src="images/1.png" alt="header image" class="img-fluid pt-5">
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
