<template>
  <button class="inquiry-btn" @click="scrollToDiv('inquiry')">Inquire now</button>
</template>

<script>
export default {
  methods: {
    scrollToDiv (divName) {
      window.scrollTo(0, document.getElementById(divName).offsetTop)
    }
  }
}
</script>
