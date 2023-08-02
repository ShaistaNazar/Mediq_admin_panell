<template>
  <div id="inquiry" class="container-fluid contact-us">

    <div class="container">
      <div class="row contact-us-section">
        <div class="col-md-12 text-center">
          <h1 class="headings-color">
            <b>Let's Work Together</b>
          </h1>
          <p class="services-text">If You're a Doctor or own a Hospital, we love to hear from you</p>
        </div>
        <div class="col-md-12" style="padding-top: 40px">
          <div class="row">
            <div class="col-md-6">
              <form @submit.prevent="submit">
                <div class="form-group">
                  <label class="form-label formLabel">Email Address*</label>
                  <input v-model.trim="form.email" type="email" class="form-control formInput" required>
                </div>
                <div class="form-group">
                  <label class="form-label formLabel">Subject*</label>
                  <input v-model.trim="form.subject" maxlength="20" type="text" class="form-control formInput" required >
                </div>
                <div class="form-group">
                  <label class="form-label formLabel">Your Message*</label>
                  <textarea v-model.trim="form.message" maxlength="250" class="form-control formInput" rows="3" required/>
                </div>
                <b-alert
                  :show="dismissCountDown"
                  dismissible
                  variant="success"
                  @dismissed="dismissCountDown=0"
                  @dismiss-count-down="countDownChanged"
                >
                  <p class="message-alert">Thank you for Contact Us.
                  We have received your Inquiry and will respond to you within 24 hours.</p>

                </b-alert>
                <button type="submit" class="message-btn">Send Message <b-spinner v-if="isLoading" small label="Spinning"/></button>
              </form>
            </div>
            <div class="col-md-5 offset-md-1 contact-us-text">
              <p class="contact-text">CONTACT US</p>
              <h1 class="headings-color">
                <b>Get in Touch.</b>
              </h1>
              <p class="quality-paragraph">
                <span class="contact-text">PHONE NO :</span>
                <br >051-8773333
              </p>
              <p class="quality-paragraph">
                <span class="contact-text">ADDRESS :</span>
                <br >Office No 3 & 4 Pak Land Plaza, G8 Markaz, Islamabad
              </p>
              <p class="quality-paragraph">
                <span class="contact-text">EMAIL :</span>
                <br >info@mediq.com.pk
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      form: {
        email: '',
        subject: '',
        message: ''
      },
      isLoading: false,
      dismissSecs: 4,
      dismissCountDown: 0,
      showDismissibleAlert: false
    }
  },
  methods: {
    async submit () {
      this.isLoading = true
      try {
        await window.axios.post('/api/formSubmit', this.form)
        this.form.email = ''
        this.form.subject = ''
        this.form.message = ''
        this.showAlert()
      } catch (error) {
        if (error) {
          console.log(error)
        }
      }
      this.isLoading = false
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    }
  }
}
</script>
