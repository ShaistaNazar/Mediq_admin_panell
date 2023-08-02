<template>
  <div class="container-fluid contact-us">
    <div class="container">
      <div class="row contact-us-section">
        <div class="col-md-12  text-center">
          <h1 class="headings-color"><b>Let's Work Together</b></h1>
          <p class="services-text">
            If You're Doctor or own a Hospital, we love to hear from you
          </p>
        </div>
        <div class="col-md-12" style="padding-top: 40px">
          <div class="row">
            <div class="col-md-6">
              <form @submit.prevent="submit">
                <div class="form-group">
                  <label class="form-label formLabel">Email Address*</label>
                  <input type="email" class="form-control formInput" required>
                </div>
                <div class="form-group">
                  <label class="form-label formLabel">Subject*</label>
                  <input type="text" class="form-control formInput" required>
                </div>
                <div class="form-group">
                  <label class="form-label formLabel">Your Message*</label>
                  <textarea class="form-control formInput" rows="3" required/>
                </div>
                <button type="submit" class="message-btn">Send Message</button>
              </form>
            </div>
            <div class="col-md-5 offset-md-1 contact-us-text">
              <p class="contact-text">CONTACT US</p>
              <h1 class="headings-color"><b>Get in Touch.</b></h1>
              <p class="quality-paragraph"><span class="contact-text">PHONE NO :</span><br> 0800-111-22</p>
              <p class="quality-paragraph"><span class="contact-text">ADDRESS :</span><br> Islamabad</p>
              <p class="quality-paragraph"><span class="contact-text">EMAIL :</span><br> noreply@yourcompany.com</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
