<template>
  <h1 class="mb-1 mt-4 ms-4">My Cart</h1>
  <div class="row mx-2">
    <div class="col-12 col-lg-8">
      <div
        class="card p-3 mb-3 d-flex"
        v-for="(item, index) in $store.state.cart"
        :key="item.id"
      >
        <a :href="'/' + item.product.name" class="cart-item-image">
          <img
            :src="'/storage/' + item.product.image"
            :alt="item.product.name"
          />
        </a>
        <a :href="'/' + item.product.name" v-text="item.product.name"></a>
        <div class="cart-item-quantity d-flex">
          <button
            class="btn btn-sm btn-outline-secondary"
            :disabled="item.quantity <= 1"
            @click="decreaseQuantity(item, index)"
          >
            -
          </button>
          <input
            type="text"
            class="form-control form-control-sm text-center quantity"
            disabled
            :value="item.quantity"
          />
          <button
            class="btn btn-sm btn-outline-secondary"
            :disabled="item.quantity >= 10"
            @click="increaseQuantity(item, index)"
          >
            +
          </button>
        </div>

        <div
          class="cart-item-price"
          v-text="'$' + item.subTotal.toFixed(2)"
        ></div>

        <button
          class="btn btn-sm btn-outline-secondary"
          @click="removeFromCart(index)"
        >
          Remove
        </button>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="card p-3">
        <div class="d-flex justify-content-between">
          <span class="fw-bold">Subtotal:</span
          ><span>${{ $store.state.subTotal.toFixed(2) }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span class="fw-bold">Shipping:</span
          ><span>(Calculated at Checkout)</span>
        </div>
        <div class="d-flex justify-content-between">
          <span class="fw-bold">Tax:</span>
          <span>(Calculated at Checkout)</span>
        </div>
        <div>
          <button @click="submit" class="btn btn-primary btn-block mt-3">
            Proceed to Checkout
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  methods: {
    removeFromCart(index) {
      this.$store.commit("removeFromCart", index);
    },
    increaseQuantity(item, index) {
      this.$store.commit("updateQuantity", {
        index: index,
        quantity: item.quantity + 1,
      });
    },
    decreaseQuantity(item, index) {
      this.$store.commit("updateQuantity", {
        index: index,
        quantity: item.quantity - 1,
      });
    },
    submit() {
    },
  },
};
</script>

<style scoped>
</style>
