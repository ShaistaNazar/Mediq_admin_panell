<template>
  <div class="container-fluid gallery">
    <div class="container">
      <div class="row gallery-section">
        <div class="col-md-12 text-center">
          <h1 class="headings-color">
            <b>Our Partners & Supporters</b>
          </h1>
          <p class="services-text">An integral part of our journey</p>
        </div>
        <div class="col-md-12" style="margin-top: 30px">
          <div class="container">
            <div class="row text-center">
              <hooper :settings="hooperSettings" style="height: auto">
                <slide
                  v-for="(slide, index) in images"
                  :key="index"
                  :index="index"
                  class="slider-img-style"
                >
                  <img :src="slide.imageUrl" alt="slider image">
                </slide>
              </hooper>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Hooper, Slide } from 'hooper'
import 'hooper/dist/hooper.css'

export default {
  name: 'App',
  components: {
    Hooper,
    Slide
  },
  data () {
    return {
      hooperSettings: {
        itemsToShow: 5,
        centerMode: true,
        infiniteScroll: true,
        autoPlay: true,
        playSpeed: 2000,
        breakpoints: {
          320: {
            centerMode: false,
            itemsToShow: 1
          },
          500: {
            centerMode: false,
            itemsToShow: 2
          },
          768: {
            centerMode: false,
            itemsToShow: 3
          },
          800: {
            centerMode: false,
            itemsToShow: 3
          },
          991: {
            itemsToShow: 3
          },
          1200: {
            itemsToShow: 5
          }
        }
      },
      images: [
        {
          imageUrl: 'images/support1.jpg'
        },
        {
          imageUrl: 'images/support2.jpg'
        },
        {
          imageUrl: 'images/support3.jpg'
        },
        {
          imageUrl: 'images/support4.jpg'
        },
        {
          imageUrl: 'images/support5.jpg'
        },
        {
          imageUrl: 'images/support6.jpg'
        },
        {
          imageUrl: 'images/support7.jpg'
        },
        {
          imageUrl: 'images/support8.jpg'
        },
        {
          imageUrl: 'images/support9.jpg'
        },
        {
          imageUrl: 'images/support10.jpg'
        },
        {
          imageUrl: 'images/support11.jpg'
        },
        {
          imageUrl: 'images/support12.jpg'
        },
        {
          imageUrl: 'images/support13.jpg'
        },
        {
          imageUrl: 'images/support14.jpg'
        }
      ]
    }
  }
}
</script>
