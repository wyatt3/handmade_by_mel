<template>
  <img class="w-100 mb-2" :src="activeImage" alt="Product Image" />
  <div class="d-flex flex-wrap">
    <img
      class="thumbnail-image mx-1 mb-1"
      :class="{ active: activeImage === image.path }"
      v-for="(image, index) in images"
      :key="index"
      @click="changeImage(image.path)"
      :src="image.path"
      alt="Product Thumbnail"
    />
  </div>
</template>

<script>
export default {
  props: {
    images: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      activeImage: null,
    };
  },
  methods: {
    changeImage(path) {
      this.activeImage = path;
    },
  },
  mounted() {
    this.activeImage = this.images[0].path;
  },
};
</script>

<style scoped>
.thumbnail-image {
  width: 50px;
  height: 50px;
  cursor: pointer;
  object-fit: cover;
  border: 2px solid #555;
  border-radius: 3px;
}

@media screen and (min-width: 768px) {
  .thumbnail-image {
    width: 65px;
    height: 65px;
  }
}
</style>
