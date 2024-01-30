<template>
  <div class="container my-4">
    <h1>Order #{{ order ? order.id : "" }}</h1>
    <div v-if="order == null">
      <hollow-dots-spinner class="m-auto" :animation-duration="1000" :dot-size="20" :dots-num="3" color="#222E50" />
    </div>
    <div v-else class="row">
      <div class="col-12 col-md-4">
        <div class="section-title">General Information</div>
        <label>Name:</label>
        <div class="ms-2 mb-3">{{ order.customer.name }}</div>
        <label>Email:</label>
        <div class="ms-2 mb-3">{{ order.customer.email }}</div>
        <label>Creation Date:</label>
        <div class="ms-2 mb-3">{{ order.created_at }}</div>
        <label>Order Total:</label>
        <div class="ms-2 mb-3">${{ formatPrice(order.total) }}</div>
      </div>
      <div class="col-12 col-md-4">
        <div class="section-title">Shipping Information</div>
        <label>Address:</label>
        <div class="ms-2 mb-3">{{ order.shipping_address }}</div>
      </div>
    </div>
  </div>
</template>

<script>
import { HollowDotsSpinner } from "epic-spinners";
export default {
  props: {
    order: {
      type: Object,
      required: false,
    },
  },
  components: {
    HollowDotsSpinner,
  },
  data() {
    return {};
  },
};
</script>

<style scoped>
.row {
  font-size: 1rem;
}
.section-title {
  font-size: 1.25rem;
  font-weight: 600;
}
</style>
