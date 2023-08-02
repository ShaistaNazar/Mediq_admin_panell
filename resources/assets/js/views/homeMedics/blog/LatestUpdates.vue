<template>
  <div class="container blog-section">
    <div class="row">
      <div class="col-md-7">
        <h1 class="headings-color">Blogs</h1>
        <p class="services-text">latest updates from us to you</p>
        <router-link :to="{name: 'read-blog', params: { blog_id: firstBlog.id }}">
          <img :src="imagelink + firstBlog.image" alt="Blog Updates" class="img-fluid">
          <div class="bottom-left post-1-bottom">
            <h3 class="blog-heading">
              {{ firstBlog.title }}
            </h3>
            <p class="quality-paragraph" v-html="firstBlog.description && firstBlog.description.length > 70 ? firstBlog.description.substring(0, 70) + '...' : firstBlog.description"/>
            <p class="extra-date"><font-awesome-icon class="blog-icon" icon="calendar-alt"/> {{ moment(firstBlog.created_at ).format('MMMM Do YYYY') }} &nbsp;&nbsp;&nbsp;<font-awesome-icon class="blog-icon" icon="clock"/> {{ moment(firstBlog.created_at).format('h:mm a') }} </p>
          </div>
          <div class="bottom-right post-1-bottom">
            <p class="quality-paragraph"><font-awesome-icon class="blog-icon" icon="calendar-alt"/> {{ moment(firstBlog.created_at ).format('MMMM Do YYYY') }} &nbsp;&nbsp;&nbsp;<font-awesome-icon class="blog-icon" icon="clock"/> {{ moment(firstBlog.created_at).format('h:mm a') }} </p>
          </div>
        </router-link>
      </div>
      <div class="col-md-5">
        <h1 class="headings-color">Latest Posts</h1>
        <p class="services-text">latest updates from us to you</p>
        <div v-for="(blog, index) in blogs.slice(1,3)" :key="index" class="row latest-post-img">
          <div class="col-md-12">
            <router-link :to="{name: 'read-blog', params: { blog_id: blog.id }}">
              <img :src="imagelink + blog.image" alt="Cofee" class="img-fluid">
              <div class="bottom-left">
                <h5 class="blog-heading-2">
                  {{ blog.title }}
                </h5>
                <p class="blog-post-text"><font-awesome-icon class="blog-icon" icon="calendar-alt"/> <span class="blog-date">{{ moment(blog.created_at).format('MMMM Do YYYY') }}</span> &nbsp;&nbsp;&nbsp;<font-awesome-icon class="blog-icon" icon="clock"/> <span class="blog-date">{{ moment(blog.created_at).format('h:mm a') }}</span></p>
              </div>
              <div class="bottom-right-arrow">
                <font-awesome-icon icon="arrow-right" class="blog-date"/>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="col-lg-12 col-md-12"> -->
    <div class="row post-section">
      <div v-for="(blog, index) in blogs.slice(3,6)" :key="index" class="col-md-4 single-post">
        <router-link :to="{name: 'read-blog', params: { blog_id: blog.id }}">
          <img :src="imagelink + blog.image" alt="Doctor concerige" class="img-fluid" width="100% !important">
          <div class="bottom-left">
            <h5 class="blog-heading-2">
              {{ blog.title }}
            </h5>
            <p class="blog-post-text"><font-awesome-icon class="blog-icon" icon="calendar-alt"/> <span class="blog-date">{{ moment(blog.created_at).format('MMMM Do YYYY') }}</span> &nbsp;&nbsp;&nbsp;<font-awesome-icon class="blog-icon" icon="clock"/> <span class="blog-date">{{ moment(blog.created_at).format('h:mm a') }}</span></p>
          </div>
          <div class="bottom-right-arrow">
            <font-awesome-icon icon="arrow-right" class="blog-date"/>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import {imageLink} from '../../../helpers/constants'
export default {
  data () {
    return {
      blogs: [],
      imagelink: imageLink
    }
  },
  computed: {
    firstBlog () {
      return this.blogs[0] ? this.blogs[0] : {}
    }
  },
  mounted () {
    this.allBlogs()
  },
  methods: {
    async  allBlogs () {
      let response = await window.axios.get('/api/allBlogs')
      this.blogs = response.data
    }
  }
}
</script>
