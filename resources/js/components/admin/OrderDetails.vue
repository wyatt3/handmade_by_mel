<template>
  <div class="container my-4">
    <h1>Order #{{ order ? order.id : "" }}</h1>
    <div v-if="order == null">
      <hollow-dots-spinner
        class="m-auto"
        :animation-duration="1000"
        :dot-size="20"
        :dots-num="3"
        color="#222E50"
      />
    </div>
    <div v-else class="row">
      <div class="col-12 col-md-4">
        <span>General Information</span>
        <label>Name</label>
        <p>{{ order.customer.name }}</p>
        <label>Email</label>
        <p>{{ order.customer.email }}</p>
        <label>Phone</label>
        <p>{{ order.customer.phone }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    order: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {};
  },
};
</script>
