<template>
  <div class="row gx-4 gx-lg-5 align-items-center">
    <div class="col-md-6">
      <product-images ref="productImages" :images="productImages" />
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
        <variation-select
          class="mb-3"
          :options="variations"
          :default="`-- Select a ${variationType} --`"
          @change="variationSelected($event, variationType)"
        ></variation-select>
      </div>
      <button
        class="btn btn-outline-dark add-to-cart position-relative"
        type="button"
        :disabled="adding"
        @click="addToCart"
      >
        <transition-group name="fade">
          <span v-if="adding" class="position-absolute">
            <i class="bi-check2 me-1"></i> Added!
          </span>
          <span v-else class="position-absolute">
            <i class="bi-cart-fill me-1"></i> Add to cart
          </span>
        </transition-group>
      </button>
    </div>
  </div>
</template>

<script>
import ProductImages from "./ProductImages.vue";
import VariationSelect from "./VariationSelect.vue";
export default {
  components: { ProductImages, VariationSelect },
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
      adding: false,
    };
  },
  created() {
    this.product.variations.forEach((variation) => {
      this.selectedVariations[variation.type.name] = 0;
    });
  },
  methods: {
    addToCart() {
      let complete = true;
      for (let name in this.selectedVariations) {
        if (this.selectedVariations[name] === 0) {
          complete = false;
          let startsWithVowel = name.match("^[aieouAIEOU].*");
          if (startsWithVowel) {
            this.$toast.warning(`- Please select an ${name}`, {
              duration: 5000,
              position: "top-right",
            });
          } else {
            this.$toast.warning(`- Please select a ${name}`, {
              duration: 5000,
              position: "top-right",
            });
          }
        }
      }
      if (!complete) {
        return;
      }
      this.$store.commit("addToCart", {
        product: this.product,
        variations: this.selectedVariations,
        quantity: 1,
        unit_price: this.salePrice
          ? parseFloat(this.salePrice)
          : parseFloat(this.price),
      });
      this.adding = true;
      setTimeout(() => {
        this.adding = false;
      }, 2000);
    },
    variationSelected(variation, variationType) {
      this.selectedVariations[variationType] = variation;
      this.calculatePrice();
      if (variation.image) {
        this.$refs.productImages.changeImage(variation.image);
      }
    },
    calculatePrice() {
      this.price = this.product.price;
      this.salePrice = this.product.sale_price ?? null;
      for (let variation of Object.values(this.selectedVariations)) {
        if (variation !== 0) {
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
  computed: {
    productImages() {
      return [
        ...this.product.images,
        ...this.product.variations.map((variation) => {
          return {
            variation_id: variation.id,
            order: variation.order,
            path: variation.image,
          };
        }),
      ];
    },
  },
};
</script>

<style scoped>
.add-to-cart {
  width: 145px;
  height: 45px;
}

.add-to-cart span {
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 145px;
}
</style>
