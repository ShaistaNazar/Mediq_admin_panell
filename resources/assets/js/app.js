/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
import router from './router.js'
import utils from './helpers/utilities'
import ThemeSwitcher from './components/ThemeSwitcher'
import moment from 'moment'
import ToggleButton from 'vue-js-toggle-button'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faSearch, faCalendarAlt, faClock, faArrowRight } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import VueMomentLib from 'vue-moment-lib'
import SocialSharing from 'vue-social-sharing'
// import VueMoment from 'vue-moment'
// require dynamic dropdown
import Vue from 'vue'

library.add(faSearch, faCalendarAlt, faClock, faArrowRight)

Vue.component('font-awesome-icon', FontAwesomeIcon)

export const serverBus = new Vue()
Vue.prototype.moment = moment

// Install this library
// Vue.use(VueMoment)
Vue.use(VueMomentLib)
require('./bootstrap')
Vue.prototype.$utils = utils
Vue.use(ToggleButton)
Vue.use(SocialSharing)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    // el: "#app",
    // components: { App },
    // template: "<App/>",
    router,

    // Theme Swiching Demo Component (You can remove it if not required)
    components: {
        ThemeSwitcher
    }
}).$mount('#app')