<template>
  <div class="product-images">
    <div class="product-image">
      <img :src="activeImage" alt="Product Image" />
    </div>
    <div class="row row-wrap">
      <div
        class="col-3 col-md-2"
        v-for="(image, index) in images"
        :key="index"
        @click="activeImage = image"
      >
        <img class="w-100" :src="image.path" alt="Product Thumbnail" />
      </div>
    </div>
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
};
</script>
