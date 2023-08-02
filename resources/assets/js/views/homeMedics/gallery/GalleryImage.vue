<template>
  <div class="container" style="margin-top: 80px">
    <b-tabs
      active-nav-item-class="font-weight-bold text-uppercase"
      class=""
    >
      <b-tab title="IMAGES" active>
        <div class="row">
          <div class="column">
            <img src="images/rocks.jpg" style="width:100%">
            <img src="images/wedding.jpg" style="width:100%">
            <img src="images/falls2.jpg" style="width:100%">
            <img src="images/paris.jpg" style="width:100%">
            <img src="images/nature.jpg" style="width:100%">
            <img src="images/mist.jpg" style="width:100%">
            <img src="images/paris.jpg" style="width:100%">
          </div>
          <div class="column">
            <img src="images/underwater.jpg" style="width:100%">
            <img src="images/ocean.jpg" style="width:100%">
            <img src="images/wedding.jpg" style="width:100%">
            <img src="images/mountainskies.jpg" style="width:100%">
            <img src="images/rocks.jpg" style="width:100%">
            <img src="images/underwater.jpg" style="width:100%">
          </div>
          <div class="column">
            <img src="images/wedding.jpg" style="width:100%">
            <img src="images/rocks.jpg" style="width:100%">
            <img src="images/falls2.jpg" style="width:100%">
            <img src="images/paris.jpg" style="width:100%">
            <img src="images/nature.jpg" style="width:100%">
            <img src="images/mist.jpg" style="width:100%">
            <img src="images/paris.jpg" style="width:100%">
          </div>

        </div>

        <!-- <div class="gallery">
          <figure class="gallery__item gallery__item--1">
            <img src="images/rocks.jpg" alt="Gallery image 1" class="gallery__img">
          </figure>
          <figure class="gallery__item gallery__item--5">
            <img src="images/nature.jpg" alt="Gallery image 5" class="gallery__img">
          </figure>
          <figure class="gallery__item gallery__item--2">
            <img src="images/wedding.jpg" alt="Gallery image 2" class="gallery__img">
          </figure>
          <figure class="gallery__item gallery__item--3">
            <img src="images/falls2.jpg" alt="Gallery image 3" class="gallery__img">
          </figure>
          <figure class="gallery__item gallery__item--4">
            <img src="images/paris.jpg" alt="Gallery image 4" class="gallery__img">
          </figure>

          <figure class="gallery__item gallery__item--6">
            <img src="images/mist.jpg" alt="Gallery image 6" class="gallery__img">
          </figure>
          <figure class="gallery__item gallery__item--4">
            <img src="images/paris.jpg" alt="Gallery image 4" class="gallery__img">
          </figure>
          <figure class="gallery__item gallery__item--5">
            <img src="images/nature.jpg" alt="Gallery image 5" class="gallery__img">
          </figure>
        </div> -->
      </b-tab>
      <b-tab title="VIDEOS"><p>I'm the second tab</p></b-tab>
    </b-tabs>
  </div>
</template>

<style scoped>
.row {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  padding: 0 4px;
}

.column {
  -ms-flex: 25%;
  flex: 33%;
  max-width: 33%;
  padding: 0 4px;
}

.column img {
  margin-top: 8px;
  vertical-align: middle;
  width: 100%;
}

@media screen and (max-width: 800px) {
  .column {
    -ms-flex: 50%;
    flex: 50%;
    max-width: 50%;
  }
}

@media screen and (max-width: 600px) {
  .column {
    -ms-flex: 100%;
    flex: 100%;
    max-width: 100%;
  }
}
</style>
