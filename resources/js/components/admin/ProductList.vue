<template>
  <div>
    <div class="d-flex justify-content-between">
      <a class="btn btn-primary" href="/products/create"
        ><i class="bi bi-plus"></i>New Product</a
      >
      <div>
        <input
          type="text"
          class="form-control"
          placeholder="Search..."
          v-model="search"
        />
      </div>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>SKU</th>
          <th>Category</th>
          <th>On Sale</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="loading">
          <td colspan="4">
            <hollow-dots-spinner
              class="m-auto"
              :animation-duration="1000"
              :dot-size="20"
              :dots-num="3"
              color="#222E50"
            />
          </td>
        </tr>

        <tr v-else v-for="product in filteredProducts" :key="product.id">
          <td>
            <button class="fake-link" @click="openEditModal(product.id)">
              {{ product.name }}
            </button>
          </td>
          <td>{{ product.sku }}</td>
          <td>{{ product.category.name }}</td>
          <td>{{ product.sale_price ? "Yes" : "No" }}</td>
        </tr>
      </tbody>
    </table>
    <modal :open="showEditModal" @toggle="showEditModal = !showEditModal">
      <h1>Modal</h1>
    </modal>
  </div>
</template>

<script>
import axios from "axios";
import { HollowDotsSpinner } from "epic-spinners";
import Modal from "../Modal.vue";

export default {
  name: "ProductList",
  components: {
    HollowDotsSpinner,
    Modal,
  },
  data() {
    return {
      products: [],
      search: "",
      loading: false,
      showEditModal: false,
    };
  },
  created() {
    this.fetchProducts();
  },
  methods: {
    fetchProducts() {
      this.loading = true;
      axios
        .get("/api/products")
        .then((response) => {
          this.products = response.data;
        })
        .finally(() => {
          this.loading = false;
        });
    },
    openEditModal(id) {
      this.showEditModal = true;
    },
  },
  computed: {
    filteredProducts() {
      return this.products.filter((product) => {
        return (
          product.name.toLowerCase().includes(this.search.toLowerCase()) ||
          product.sku.toLowerCase().includes(this.search.toLowerCase()) ||
          product.category.name
            .toLowerCase()
            .includes(this.search.toLowerCase())
        );
      });
    },
  },
};
</script>
