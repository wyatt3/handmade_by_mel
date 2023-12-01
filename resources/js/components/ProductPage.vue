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
        <div v-if="salePrice">
          <span
            class="text-muted text-decoration-line-through me-1"
            v-text="'$' + price"
          ></span>
          <span v-text="'$' + salePrice"></span>
        </div>
        <div v-else v-text="'$' + price"></div>
      </div>
      <p class="lead" v-text="product.description"></p>
      <div
        v-for="(variations, variationType) in product.groupedVariations"
        :key="variationType"
      >
        <label class="form-label mb-0 ps-2" v-text="variationType"></label>
        <select
          class="form-select mb-3"
          v-model="selectedVariations[variationType]"
          @change="variationSelected(selectedVariations[variationType])"
        >
          <option value="0" selected disabled hidden>
            -- Select a {{ variationType }} --
          </option>
          <option
            v-for="variation in variations"
            :key="variation.id"
            v-text="variation.name"
            :value="variation.id"
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
      price: this.product.price,
      salePrice: this.product.sale_price,
      selectedVariations: {},
    };
  },
  created() {
    this.product.variations.forEach((variation) => {
      this.selectedVariations[variation.type.name] = 0;
    });
  },
  methods: {
    addToCart() {
      this.$store.commit("addToCart", {
        product: this.product,
        variations: this.selectedVariations,
        quantity: 1,
      });
    },
    variationSelected(variationId) {
      this.calculatePrice();
      let variation = this.product.variations.find(
        (variation) => variation.id === variationId
      );
      if (variation.image) {
        console.log(variation.image);
      }
    },
    calculatePrice() {
      this.price = this.product.price;
      this.salePrice = this.product.sale_price ?? null;
      for (let variationId of Object.values(this.selectedVariations)) {
        if (variationId !== 0) {
          let variation = this.product.variations.find(
            (variation) => variation.id === variationId
          );
          if (variation.price_modifier) {
            this.price =
              parseFloat(this.price) + parseFloat(variation.price_modifier);
            if (this.salePrice) {
              this.salePrice =
                parseFloat(this.salePrice) +
                parseFloat(variation.price_modifier);
            }
          }
        }
      }
      this.price = this.price.toFixed(2);
      if (this.salePrice) {
        this.salePrice = this.salePrice.toFixed(2);
      }
    },
  },
};
</script>

<style scoped>
</style>
