<template>
  <div class="container px-3 my-4">
    <h1>Order #{{ order ? order.id : "" }}</h1>
    <div v-if="order == null">
      <hollow-dots-spinner class="m-auto" :animation-duration="1000" :dot-size="20" :dots-num="3" color="#222E50" />
    </div>
    <div v-else class="row">
      <div class="col-12 col-md-4 mb-3">
        <div class="section-title">General Information</div>
        <label>Name:</label>
        <div class="ms-2 mb-3">{{ order.customer.name }}</div>
        <label>Email:</label>
        <div class="ms-2 mb-3">{{ order.customer.email }}</div>
        <label>Creation Date:</label>
        <div class="ms-2 mb-3">{{ formatDate(order.created_at) }}</div>
        <label>Order Total:</label>
        <div class="ms-2 mb-3">${{ formatPrice(order.total) }}</div>
      </div>
      <div class="col-12 col-md-4 mb-3">
        <div class="section-title">Shipping Address</div>
        <label>Line 1:</label>
        <div class="ms-2 mb-2">{{ order.customer.shipping_address.line_1 }}</div>
        <div v-if="order.customer.shipping_address.line_2">
          <label>Line 2:</label>
          <div class="ms-2 mb-2">{{ order.customer.shipping_address.line_2 }}</div>
        </div>
        <label>City:</label>
        <div class="ms-2 mb-2">{{ order.customer.shipping_address.city }}</div>
        <label>State:</label>
        <div class="ms-2 mb-2">{{ order.customer.shipping_address.state }}</div>
        <label>Zip Code:</label>
        <div class="ms-2 mb-2">{{ order.customer.shipping_address.postal_code }}</div>
      </div>
      <div class="col-12 col-md-4 mb-3">
        <div class="section-title">Billing Address</div>
        <label>Line 1:</label>
        <div class="ms-2 mb-2">{{ order.customer.billing_address.line_1 }}</div>
        <div v-if="order.customer.billing_address.line_2">
          <label>Line 2:</label>
          <div class="ms-2 mb-2">{{ order.customer.billing_address.line_2 }}</div>
        </div>
        <label>City:</label>
        <div class="ms-2 mb-2">{{ order.customer.billing_address.city }}</div>
        <label>State:</label>
        <div class="ms-2 mb-2">{{ order.customer.billing_address.state }}</div>
        <label>Zip Code:</label>
        <div class="ms-2 mb-2">{{ order.customer.billing_address.postal_code }}</div>
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
