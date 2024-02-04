<template>
  <modal :open="open" @toggle="open = !open">
    <div class="container px-5 my-4">
      <h1>Ship Order</h1>
      <label for="carrier">Carrier</label>
      <input type="text" v-model="carrier" class="form-control" id="carrier" />

      <label for="tracking_number">Tracking Number</label>
      <input type="text" v-model="tracking_number" class="form-control" id="tracking_number" />

      <div class="row">
        <div class="col-12 col-md-6">
          <button class="btn btn-danger w-100 mt-3" @click="open = false">
            <i class="bi bi-x-lg"></i>
            Cancel
          </button>
        </div>
        <div class="col-12 col-md-6">
          <button class="btn btn-primary w-100 mt-3" @click="shipOrder" :disabled="loading">
            <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span v-else>
              <i class="bi bi-truck me-2"></i>
              Mark Shipped
            </span>
          </button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import Modal from "../Modal.vue";

export default {
  components: { Modal },
  props: {
    order: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      open: false,
      tracking_number: "",
      carrier: "",
      loading: false,
    };
  },
};
</script>

<style scoped>
</style>
