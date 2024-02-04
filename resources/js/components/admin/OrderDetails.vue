<template>
  <div class="container px-5 my-4">
    <h1>Order #{{ order ? order.id : "" }}</h1>
    <div v-if="order == null">
      <hollow-dots-spinner class="m-auto" :animation-duration="1000" :dot-size="20" :dots-num="3" color="#222E50" />
    </div>
    <div v-else>
      <div class="row">
        <div class="col-12 col-md-4 mb-3">
          <div class="section-title">General Information</div>
          <label>Name:</label>
          <div class="ms-2 mb-3">{{ order.customer.name }}</div>
          <label>Email:</label>
          <div class="ms-2 mb-3">{{ order.customer.email }}</div>
          <label>Status:</label>
          <div class="ms-2 mb-3">{{ order.status.name }}</div>
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
      <div class="section-title">Order Items</div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Item Total</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="item in order.items" :key="item.id">
            <tr>
              <td>#{{ item.id }}</td>
              <td>{{ item.product.name }}</td>
              <td>{{ item.quantity }}</td>
              <td>
                ${{
                  formatPrice(
                    parseFloat(item.base_price) +
                      item.variations.reduce((prev, variation) => prev + parseFloat(variation.price_modifier), 0)
                  )
                }}
              </td>
              <td>${{ formatPrice(item.total) }}</td>
            </tr>
            <tr v-for="variation in item.variations" :key="variation.id">
              <td colspan="2" class="text-end">{{ variation.type.name }}:</td>
              <td colspan="3">{{ variation.name }}</td>
            </tr>
          </template>
          <tr class="subtotal">
            <td colspan="4" class="text-end">Subtotal</td>
            <td>${{ formatPrice(order.subtotal) }}</td>
          </tr>
          <tr v-if="order.shipping_cost > 0">
            <td colspan="4" class="text-end">Shipping</td>
            <td>${{ formatPrice(order.shipping_cost) }}</td>
          </tr>
          <tr>
            <td colspan="4" class="text-end">Tax</td>
            <td>${{ formatPrice(order.tax) }}</td>
          </tr>
          <tr class="total">
            <td colspan="4" class="text-end">Total</td>
            <td>${{ formatPrice(order.total) }}</td>
          </tr>
        </tbody>
      </table>
      <div class="d-flex justify-content-end mb-2">
        <button class="btn btn-secondary me-2" @click="openShipModal">
          <i class="bi bi-truck me-2"></i>
          Mark Order Shipped
        </button>
        <button class="btn btn-danger me-2" @click="cancelOrder">
          <i class="bi bi-trash me-2"></i>
          Cancel Order
        </button>
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

  methods: {
    openShipModal() {
      this.$parent.$parent.$parent.$refs.shipModal.open = true;
    },
    cancelOrder() {
      this.$root.$refs.confirm
        .show({
          title: "Confirm Cancel",
          message: `Are you sure you want to cancel this order?`,
          okButton: "Cancel Order",
        })
        .then(() => {
          axios
            .post(`/api/orders/${this.order.id}/cancel`)
            .then((response) => {
              this.$toast.success("Order cancelled.", {
                position: "top-right",
              });
              this.$emit("order-status-changed", this.order.id);
            })
            .catch((error) => {
              console.log(error);
              this.$toast.error("Error cancelling order.", {
                position: "top-right",
              });
            });
        });
    },
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

.subtotal,
.total {
  border-top: 2px solid #b6babe;
}
</style>
