<template>
  <div>
    <div class="row">
      <div class="btn-group col-12 col-md-8">
        <button
          @click="setSelectedStatus(null)"
          class="btn btn-outline-primary col-3 mb-2"
          :class="{ active: selectedStatus == null }"
        >
          <i class=""></i>
          All
        </button>
        <button
          @click="setSelectedStatus(1)"
          class="btn btn-outline-primary col-3 mb-2"
          :class="{ active: selectedStatus == 1 }"
        >
          <i class=""></i>
          New
        </button>
        <button
          @click="setSelectedStatus(2)"
          class="btn btn-outline-primary col-3 mb-2"
          :class="{ active: selectedStatus == 2 }"
        >
          <i class=""></i>
          Shipped
        </button>
        <button
          @click="setSelectedStatus(4)"
          class="btn btn-outline-primary col-3 mb-2"
          :class="{ active: selectedStatus == 4 }"
        >
          <i class=""></i>
          Cancelled
        </button>
      </div>
      <div class="col-12 col-md-4">
        <input type="text" class="form-control" placeholder="Search..." v-model="search" />
      </div>
    </div>
    <div class="overflow-x-scroll">
      <table class="table">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Order Total</th>
            <th>Creation Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="loading">
            <td colspan="5">
              <hollow-dots-spinner
                class="m-auto"
                :animation-duration="1000"
                :dot-size="20"
                :dots-num="3"
                color="#222E50"
              />
            </td>
          </tr>

          <tr v-else v-for="order in filteredOrders" :key="order.id">
            <td>
              <button class="fake-link" @click="openOrderModal(order.id)">
                {{ order.id }}
              </button>
            </td>
            <td>{{ order.customer.name }}</td>
            <td>{{ order.customer.email }}</td>
            <td>${{ formatPrice(order.total) }}</td>
            <td>{{ formatDate(order.created_at) }}</td>
            <td>{{ order.status.name }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <modal :open="showOrderModal" size="full" @toggle="showOrderModal = !showOrderModal">
      <order-details :order="selectedOrder" />
    </modal>
  </div>
</template>

<script>
import { HollowDotsSpinner } from "epic-spinners";
import Modal from "../Modal.vue";
import OrderDetails from "./OrderDetails.vue";
export default {
  components: {
    HollowDotsSpinner,
    Modal,
    OrderDetails,
  },
  data() {
    return {
      orders: [],
      loading: true,
      search: "",
      selectedStatus: null,
      selectedOrder: null,
      showOrderModal: false,
    };
  },
  computed: {
    filteredOrders() {
      return this.orders.filter((order) => {
        return (
          order.id.toString().includes(this.search) ||
          order.customer.name.toLowerCase().includes(this.search.toLowerCase()) ||
          order.customer.email.toLowerCase().includes(this.search.toLowerCase())
        );
      });
    },
  },
  methods: {
    fetchOrders() {
      this.loading = true;
      let params = {
        status: this.selectedStatus,
        offset: null,
        limit: null,
      };
      axios
        .get("/api/orders", { params })
        .then((response) => {
          this.orders = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error fetching the orders", {
            position: "top-right",
          });
        })
        .finally(() => {
          this.loading = false;
        });
    },
    setSelectedStatus(status) {
      this.selectedStatus = status;
      this.fetchOrders();
    },
    openOrderModal(orderId) {
      this.selectedOrder = null;
      this.showOrderModal = true;
      axios
        .get(`/api/orders/${orderId}`)
        .then((response) => {
          this.selectedOrder = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error fetching the order", {
            position: "top-right",
          });
        });
    },
  },
  created() {
    this.fetchOrders();
  },
};
</script>

<style scoped>
.btn-group .btn.active {
  z-index: 0;
}
</style>
