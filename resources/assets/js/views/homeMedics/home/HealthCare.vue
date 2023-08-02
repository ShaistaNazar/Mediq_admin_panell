<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6 header-section hidden-section">
        <h1 class="headings-color">
          <b>
            We Change the Way
            <br>Healthcare is Delivered
          </b>
        </h1>
        <p
          class="services-text"
        >We focus on providing consumer centric healthcare services through a digital health platform reaching from providers to the consumers rather than the traditional reverse model. We make healthcare more personalized and precise. We reduce disparities (geographical, social, cultural and financial) in availability of health and healthcare services.</p>
        <inquiry-button />
      </div>
      <div class="col-md-6">
        <img src="images/3.png" alt="header image" class="img-fluid pt-5">
      </div>
      <div class="col-md-6 header-section visible-section">
        <h1 class="headings-color">
          <b>
            We Change the Way
            <br>Healthcare is Delivered
          </b>
        </h1>
        <p
          class="services-text"
        >We focus on providing consumer centric healthcare services through a digital health platform reaching from providers to the consumers rather than the traditional reverse model. We make healthcare more personalized and precise. We reduce disparities (geographical, social, cultural and financial) in availability of health and healthcare services.</p>
        <inquiry-button />
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
