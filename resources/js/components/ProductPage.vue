<template>
  <div class="row gx-4 gx-lg-5 align-items-center">
    <div class="col-md-6">
      <img
        class="card-img-top mb-5 mb-md-0"
        src="https://dummyimage.com/600x700/dee2e6/6c757d.jpg"
      />
    </div>
    <div class="col-md-6">
      <h1 class="display-5 fw-bolder mb-0" v-text="product.name"></h1>
      <div class="small mb-2" v-text="'SKU:' + product.sku"></div>
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
      <div
        v-for="(variations, variationType) in product.groupedVariations"
        :key="variationType"
      >
        <label class="form-label" v-text="variationType"></label>
        <select class="form-select" v-model="variations[variationType]">
          <option
            v-for="variation in variations"
            :key="variation.id"
            v-text="variation.name"
            :value="variation"
          ></option>
        </select>
      </div>
      <div class="d-flex">
        <button
          class="btn btn-outline-dark flex-shrink-0"
          type="button"
          @click="addToCart"
        >
          <i class="bi-cart-fill me-1"></i>
          Add to cart
        </button>
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
    return {
      variations: [],
    };
  },
  methods: {
    addToCart() {
      this.$store.commit("addToCart", this.product);
    },
  },
};
</script>

<style scoped>
</style>
