<template>
  <div class="container">
    <div class="row section-pt">
      <div class="col-md-6 header-section">
        <h1 class="headings-color">
          <b>
            Holistic Digital
            <br>Healthcare Platform
          </b>
        </h1>
        <p
          class="services-text"
        >mediQ is Pakistan’s first ‘Holistic Digital Health Platform’, where healthcare is not taken in the narrow perspective of therapeutic care. For mediQ, health is a state of complete physical, mental and social well being achieved through multiple sectors brought together digitally. mediQ provides smart healthcare solutions to health service providers as well as consumers.</p>
        <inquiry-button />
      </div>
      <div class="col-md-6">
        <img src="images/2.png" alt="header image" class="img-fluid pt-5">
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
