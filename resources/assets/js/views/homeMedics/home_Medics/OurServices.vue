<template>
  <div>
    <div class="container services-section">
      <div class="row">
        <div class="col-md-6 header-section hidden-section">
          <h1 class="headings-color">
            <b class="main-service-heading">Our Services</b>
          </h1>
          <br>
          <h4 class="headings-color">Home Healthcare</h4>
          <p
            class="services-text"
          >Home based health care includes care given by skilled medical and para- medical professionals, including doctors, skilled nursing care, physiotherapy, chronic and post-surgical patient care. It also includes skilled, non-medical care, such as assistance with daily living from a qualified home health aide.</p>
          <inquiry-button />
        </div>
        <div class="col-md-6">
          <h1 class="headings-color visible-section">
            <b>Our Services</b>
          </h1>
          <img src="images/slide5.png" alt="header image" class="img-fluid pt-5">
        </div>
        <div class="col-md-6 header-section visible-section">
          <h4 class="headings-color">Home Healthcare</h4>
          <p
            class="services-text"
          >Home based health care includes care given by skilled medical and para- medical professionals, including doctors, skilled nursing care, physiotherapy, chronic and post-surgical patient care. It also includes skilled, non-medical care, such as assistance with daily living from a qualified home health aide.</p>
          <inquiry-button />
        </div>
      </div>
    </div>

    <div class="container services-section">
      <div class="row">
        <div class="col-md-6 header-section">
          <h4 class="headings-color">Online Laboratory Services</h4>
          <p
            class="services-text"
          >Trained technologists collect samples for diagnostic tests at patient’s doorstep. With the application of leading-edge technology, our partner laboratories provide rapid turnaround time, affordable testing and superior quality care.</p>
          <inquiry-button />
        </div>
        <div class="col-md-6">
          <img
            src="images/Online-Laboratory-Services.png"
            alt="header image"
            class="img-fluid pt-5"
          >
        </div>
      </div>
    </div>

    <div class="container services-section">
      <div class="row">
        <div class="col-md-6 header-section hidden-section">
          <h4 class="headings-color">Online Pharmacy</h4>
          <p
            class="services-text"
          >Buy authentic medicines from Home Medics online pharmacy with the surety that all logistics, supply and temperature requirements have been taken care of. You order your medicines from the comfort of your home and have your medicines delivered to your doorstep.</p>
          <inquiry-button />
        </div>
        <div class="col-md-6">
          <img src="images/Online-Pharmacy.png" alt="header image" class="img-fluid pt-5">
        </div>
        <div class="col-md-6 header-section visible-section">
          <h4 class="headings-color">Online Pharmacy</h4>
          <p
            class="services-text"
          >Buy authentic medicines from mediQ online pharmacy with the surety that all logistics, supply and temperature requirements have been taken care of. You order your medicines from the comfort of your home and have your medicines delivered to your doorstep.</p>
          <inquiry-button />
        </div>
      </div>
    </div>

    <div class="container services-section">
      <div class="row">
        <div class="col-md-6 header-section">
          <h4 class="headings-color">Home Medical Supplies & Equipment</h4>
          <p
            class="services-text"
          >We offer a wide range of medical equipment for rent or purchase delivered to consumer’s doorstep. These include assistive furniture, mobility aids, medical testing devices and supplies. We also provide on rental basis expensive medical equipment such as cardiac monitors, oxygenators, photo-therapy units, physiotherapy machines etc.</p>
          <inquiry-button />
        </div>
        <div class="col-md-6">
          <img
            src="images/Home-Medical-Supplies-&-Equipment.png"
            alt="header image"
            class="img-fluid pt-5"
          >
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
