<template>
  <div>
    <div class="row">
      <div class="row col-12 col-md-8">
        <div class="col-12 col-md-4 mb-2 text-md-center">
          <a class="btn btn-primary" href="/products/create"
            ><i class="bi bi-plus"></i>New Product</a
          >
        </div>
        <div class="col-12 col-md-4 mb-2 text-md-center">
          <button class="btn btn-primary" @click="fetchProducts">
            Categories
          </button>
        </div>
        <div class="col-12 col-md-4 mb-2 text-md-center">
          <button class="btn btn-primary">Variation Types</button>
        </div>
      </div>
      <div class="col-12 col-md-4">
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
          <th class="d-none d-md-table-cell">On Sale</th>
          <th>Active</th>
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

        <tr v-else v-for="product in filteredProducts" :key="product.id">
          <td>
            <button class="fake-link" @click="openEditModal(product.id)">
              {{ product.name }}
            </button>
          </td>
          <td>{{ product.sku }}</td>
          <td>{{ product.category.name }}</td>
          <td class="d-none d-md-table-cell">
            {{ product.sale_price ? "Yes" : "No" }}
          </td>
          <td>
            <toggle-switch
              v-model="product.active"
              @change="updateProductActive(product.id, product.active)"
            ></toggle-switch>
          </td>
        </tr>
      </tbody>
    </table>
    <modal :open="showEditModal" @toggle="showEditModal = !showEditModal">
      <edit-product
        :product="selectedProduct"
        @product-updated="fetchProducts"
      />
    </modal>
  </div>
</template>

<script>
import axios from "axios";
import { HollowDotsSpinner } from "epic-spinners";
import Modal from "../Modal.vue";
import ToggleSwitch from "../ToggleSwitch.vue";
import EditProduct from "./EditProduct.vue";

export default {
  name: "ProductList",
  components: {
    HollowDotsSpinner,
    Modal,
    ToggleSwitch,
    EditProduct,
  },
  data() {
    return {
      products: [],
      categories: [],
      variationTypes: [],
      search: "",
      loading: false,
      showEditModal: false,
      selectedProduct: null,
    };
  },
  created() {
    this.fetchProducts();
    this.fetchCategories();
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
    fetchCategories() {
      axios.get("/api/products/categories").then((response) => {
        this.categories = response.data;
      });
    },
    openEditModal(id) {
      this.selectedProduct = null;
      this.showEditModal = true;
      axios.get(`/api/products/${id}`).then((response) => {
        this.selectedProduct = response.data;
      });
    },
    updateProductActive(id, active) {
      axios
        .put(`/api/products/${id}/active`, {
          active: active,
        })
        .catch((error) => {
          console.log(error);
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
