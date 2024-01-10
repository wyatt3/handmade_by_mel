<template>
  <div class="col mb-5">
    <div class="card h-100">
      <!-- Product image-->
      <div
        v-if="product.sale_price"
        class="badge bg-dark text-tertiary position-absolute"
        style="top: 0.5rem; right: 0.5rem"
      >
        Sale
      </div>
      <a :href="'/' + product.name">
        <img
          class="card-img-top"
          :src="
            product.images.length > 0
              ? product.images[0]?.path
              : '/storage/products/no-image.jpg'
          "
          alt="..."
        />
      </a>
      <!-- Product details-->
      <div class="card-body p-4">
        <div class="text-center">
          <!-- Product name-->
          <a class="product-name" :href="'/' + product.name">
            <h5 class="fw-bolder" v-text="product.name"></h5>
          </a>
          <!-- Product price-->
          <div v-if="product.sale_price">
            <span
              class="text-muted text-decoration-line-through me-1"
              v-text="'$' + product.price"
            ></span>
            <span v-text="'$' + product.sale_price"></span>
          </div>
          <div v-else v-text="'$' + product.price"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {};
  },
};
</script>

<style scoped>
.product-name {
  text-decoration: none;
  color: #212529;
}
</style>
