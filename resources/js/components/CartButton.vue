<template>
  <a href="/cart" class="btn btn-outline-dark">
    <i class="bi-cart-fill me-1"></i>
    Cart
    <span
      class="badge bg-dark text-white ms-1 rounded-pill"
      v-text="$store.state.count"
    ></span>
  </a>
</template>

<script>
export default {};
</script>
