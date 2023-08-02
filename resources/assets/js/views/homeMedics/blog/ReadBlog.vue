<template>
  <div class="container-fluid read-blog-css">
    <img src="/images/11.png" alt="blog image" class="img-fluid">
    <!-- <img :src="'/storage/'+ blog.image" alt="blog image" class="img-fluid"> -->
    <div class="container" style="padding-top: 50px">
      <div class="row">
        <div class="col-md-12">
          <div><p class="blog-author">{{ blog.author }}</p> <h2 class="headings-color">{{ blog.title }}</h2></div>
          <p class="quality-paragraph" v-html="blog.description"/>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <social-sharing :url="socialLink" inline-template>
            <p class="social-style">
              <network network="whatsapp">
                <i class="icon-fa icon-fa-whatsapp"/>
              </network>
              <!-- <network network="linkedin">
                <i class="icon-fa icon-fa-linkedin"/>
              </network> -->
              <network network="twitter">
                <i class="icon-fa icon-fa-twitter"
              /></network>
              <network network="facebook"><i class="icon-fa icon-fa-facebook"
              /></network>
            </p>
          </social-sharing>
        </div>
        <div class="col-md-8 link-border"/>
        <div class="col-md-2">
          <span>{{ moment(blog.created_at).format('MMMM Do YYYY') }}</span>
        </div>
      </div>
    </div>
    <div class="container" style="margin-top: 40px;">
      <h2 class="headings-color">Related Posts</h2>
      <div class="row post-section">
        <div v-for="(blog, index) in blogs.slice(3,6)" :key="index" class="col-md-4 single-post">
          <router-link :to="{name: 'read-blog', params: { blog_id: blog.id }}">
            <div @click="singleBlog(blog.id)">
              <img :src="imagelink + blog.image" alt="Doctor concerige" class="img-fluid" width="100% !important">
              <div class="bottom-left">
                <h5 class="blog-heading-2">
                  {{ blog.title }}
                </h5>
                <p class="blog-post-text"><font-awesome-icon class="blog-icon" icon="calendar-alt"/> <span class="blog-date">{{ moment(blog.created_at).format('MMMM Do YYYY') }}</span> &nbsp;&nbsp;&nbsp;<font-awesome-icon class="blog-icon" icon="clock"/> <span class="blog-date">{{ moment(blog.created_at).format('h:mm a') }}</span></p>
              </div>
              <div class="bottom-right-arrow">
                <font-awesome-icon icon="arrow-right" class="blog-date arrow1"/>
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {imageLink, webLink} from '../../../helpers/constants'
export default {
  data () {
    return {
      blog: {},
      blogs: [],
      imagelink: imageLink,
      webLink: webLink
    }
  },
  computed: {
    socialLink: function () {
      return this.webLink + this.blog.id
    }
  },
  mounted () {
    this.showBlog()
    this.allBlogs()
  },
  methods: {
    async allBlogs () {
      let response = await window.axios.get('/api/allBlogs')
      this.blogs = response.data
    },
    async showBlog () {
      let id = this.$route.params.blog_id
      let response = await window.axios.get(`/api/showBlog/${id}`)
      this.blog = response.data
    },
    async singleBlog (id) {
      let response = await window.axios.get(`/api/showBlog/${id}`)
      this.blog = response.data
    }
  }
}

</script>
