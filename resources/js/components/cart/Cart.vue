<template>
  <div>
    <div class="header">Cart</div>
    <div class="cart">
      <div class="cart-item" v-for="item in $store.state.cart" :key="item.id">
        <div class="cart-item-image">
          <img
            :src="'/storage/' + item.product.image"
            :alt="item.product.name"
          />
        </div>
        <div class="cart-item-details">
          <div class="cart-item-name">
            <a :href="'/' + item.product.name" v-text="item.product.name"></a>
          </div>
          <div class="cart-item-quantity">
            <div class="quantity">
              <button
                class="btn btn-sm btn-outline-secondary"
                @click="updateQuantity(item, 'decrease')"
              >
                -
              </button>
              <input
                type="text"
                class="form-control form-control-sm"
                :value="item.quantity"
                @change="updateQuantity(item, 'change')"
              />
              <button
                class="btn btn-sm btn-outline-secondary"
                @click="updateQuantity(item, 'increase')"
              >
                +
              </button>
            </div>
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
          <div class="cart-item-remove">
            <button
              class="btn btn-sm btn-outline-secondary"
              @click="removeFromCart(item)"
            >
              Remove
            </button>
          </div>
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
};
</script>

<style scoped>
</style>
