<template>
  <div class="row gx-4 gx-lg-5 align-items-center">
    <div class="col-md-6">
      <img
        class="card-img-top mb-5 mb-md-0"
        src="https://dummyimage.com/600x700/dee2e6/6c757d.jpg"
      />
    </div>
    <div class="col-md-6">
      <div class="small mb-1" v-text="'SKU:' + product.sku"></div>
      <h1 class="display-5 fw-bolder" v-text="product.name"></h1>
      <div class="fs-5 mb-3">
        <div v-if="product.sale_price">
          <span
            class="text-muted text-decoration-line-through me-1"
            v-text="'$' + product.price"
          ></span>
          <span v-text="'$' + product.sale_price"></span>
        </div>
        <div v-else v-text="'$' + product.price"></div>
      </div>
      <p class="lead" v-text="product.description"></p>
      <div class="d-flex">
        <button class="btn btn-outline-dark flex-shrink-0" type="button">
          <i class="bi-cart-fill me-1"></i>
          Add to cart
        </button>
      </div>
      <div v-for="variationType in product.variations"></div>
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
</style>
