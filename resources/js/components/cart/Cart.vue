<template>
  <h1 class="mb-1 mt-4 ms-4">My Cart</h1>
  <div class="row mx-2">
    <div class="col-12 col-lg-8">
      <div class="card p-3">
        <div class="d-flex" v-for="item in $store.state.cart" :key="item.id">
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
              @click="decreaseQuantity(item)"
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
              @click="increaseQuantity(item)"
            >
              +
            </button>
          </div>

          <div class="cart-item-price">
            <div v-if="item.product.sale_price">
              <span
                class="text-muted text-decoration-line-through me-1"
                v-text="'$' + item.product.price"
              ></span>
              <span v-text="'$' + item.product.sale_price"></span>
            </div>
            <div v-else v-text="'$' + item.product.price"></div>
          </div>

          <button
            class="btn btn-sm btn-outline-secondary"
            @click="removeFromCart(item)"
          >
            Remove
          </button>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="card"></div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
};
</script>

<style scoped>
</style>
