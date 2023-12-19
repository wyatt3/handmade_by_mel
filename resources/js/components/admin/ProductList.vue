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
          <th>Active</th>
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
          <td>{{ product.active ? "Yes" : "No" }}</td>
        </tr>
      </tbody>
    </table>
    <modal :open="showEditModal" @toggle="showEditModal = !showEditModal">
      <div class="container my-4 edit-modal-body">
        <h1>Edit Product</h1>
        <div class="edit-modal-loading" v-if="!selectedProduct">
          <hollow-dots-spinner
            class="m-auto"
            :animation-duration="1000"
            :dot-size="20"
            :dots-num="3"
            color="#222E50"
          />
        </div>
        <div v-else>
          <div class="row">
            <div class="col-12 mb-2">
              <label class="d-block">Active</label>
              <toggle-switch v-model="selectedProduct.active"></toggle-switch>
            </div>
            <div class="col-12 col-md-6 mb-2">
              <label for="productName">Name</label>
              <input
                type="text"
                class="form-control"
                id="productName"
                v-model="selectedProduct.name"
              />
            </div>
            <div class="col-12 col-md-6 mb-2">
              <label for="productSku">SKU</label>
              <input
                type="text"
                class="form-control"
                id="productSku"
                v-model="selectedProduct.sku"
              />
            </div>
            <div class="col-12 col-md-6 mb-2">
              <label for="productPrice">Price</label>
              <input
                type="number"
                class="form-control"
                id="productPrice"
                v-model="selectedProduct.price"
              />
            </div>
            <div class="col-12 col-md-6 mb-2">
              <label for="productSalePrice"
                >Sale Price (Leave blank for no sale price)</label
              >
              <input
                type="number"
                class="form-control"
                id="productSalePrice"
                v-model="selectedProduct.sale_price"
              />
            </div>
            <div class="col-12 mb-2">
              <label for="productDescription">Description</label>
              <textarea
                class="form-control"
                id="productDescription"
                v-model="selectedProduct.description"
              ></textarea>
            </div>
            <div class="col-12 mb-2">
              <label for="productCategory">Category</label>
              <select
                class="form-control"
                id="productCategory"
                v-model="selectedProduct.category_id"
              ></select>
            </div>
          </div>
          {{ selectedProduct.variations }}
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import axios from "axios";
import { HollowDotsSpinner } from "epic-spinners";
import Modal from "../Modal.vue";
import ToggleSwitch from "../ToggleSwitch.vue";

export default {
  name: "ProductList",
  components: {
    HollowDotsSpinner,
    Modal,
    ToggleSwitch,
  },
  data() {
    return {
      products: [],
      search: "",
      loading: false,
      showEditModal: false,
      selectedProduct: null,
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
      this.selectedProduct = null;
      this.showEditModal = true;
      axios.get(`/api/products/${id}`).then((response) => {
        this.selectedProduct = response.data;
      });
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

<style scoped>
.edit-modal-body {
  min-height: 88vh;
}

.edit-modal-loading {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
