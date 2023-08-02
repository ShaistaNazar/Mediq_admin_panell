<template>
  <div>
    <div class="container med-edu-section">
      <div class="row">
        <div class="col-md-6  header-section hidden-section">
          <img src="images/Logo-Med-Edu.png" alt="" class="img-fluid">
        </div>
        <div class="col-md-6">
          <img src="images/Med-EDu.png" alt="header image" class="img-fluid pt-5">
        </div>
        <div class="col-md-6  header-section visible-section">
          <img src="images/Logo-Med-Edu.png" alt="" class="img-fluid">
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-6 header-section">
          <h4 class="headings-color"><b>Health Awareness Campaigns</b></h4>
          <p class="services-text">
            With the mission to help improve health and prevent disease, mediQ Edu teams up with partners from around the country. We collaborate and conduct health education and awareness  programs especially for women, adolescence and school going children.
          </p>
          <inquiry-button/>
        </div>
        <div class="col-md-6">
          <img src="images/Mass-Screening-Programs.png" alt="header image" class="img-fluid pt-5">
        </div>
      </div>
    </div>

    <div class="container" style="padding-bottom: 80px;">
      <div class="row">
        <div class="col-md-6 header-section hidden-section">
          <h4 class="headings-color"><b>Mass Screening Programs</b></h4>
          <p class="services-text">
            Pakistan has a double burden of communicable and non-communicable diseases. mediQ Edu conducts mass screening programs with the support of bilateral donors and social impact organizations especially for vulnerable and high risk population.
          </p>
          <inquiry-button/>
        </div>
        <div class="col-md-6">
          <img src="images/Health.png" alt="header image" class="img-fluid pt-5">
        </div>
        <div class="col-md-6 header-section visible-section">
          <h4 class="headings-color"><b>Mass Screening Programs</b></h4>
          <p class="services-text">
            Pakistan has a double burden of communicable and non-communicable diseases. mediQ Edu conducts mass screening programs with the support of bilateral donors and social impact organizations especially for vulnerable and high risk population.
          </p>
          <inquiry-button/>
        </div>

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
