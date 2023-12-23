<template>
  <div>
    <div class="row">
      <div class="row col-12 col-md-8">
        <div class="col-12 col-md-4 mb-2 text-md-center">
          <a class="btn btn-primary" href="/products/create">
            <i class="bi bi-plus"></i>
            New Product
          </a>
        </div>
        <div class="col-12 col-md-4 mb-2 text-md-center">
          <button class="btn btn-primary" @click="openCategoryModal">
            <i class="bi bi-collection"></i>
            Categories
          </button>
        </div>
        <div class="col-12 col-md-4 mb-2 text-md-center">
          <button class="btn btn-primary" @click="openVariationModal">
            <i class="bi bi-diagram-2"></i>
            Variation Types
          </button>
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
          <td>
            {{ product.category ? product.category.name : "(No Category)" }}
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
        :categories="categories"
        :variation-types="variationTypes"
        @product-updated="fetchProducts"
      />
    </modal>
    <modal
      :open="showCategoryModal"
      @toggle="showCategoryModal = !showCategoryModal"
    >
      <product-categories
        :categories="categories"
        @created="addCagetory($event)"
        @updated="fetchProducts"
        @deleted="deleteCategory($event)"
      />
    </modal>
    <modal
      :open="showVariationModal"
      @toggle="showVariationModal = !showVariationModal"
    >
      <product-variation-types
        :variation-types="variationTypes"
        @variation-types-updated="fetchVariationTypes"
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
import ProductCategories from "./ProductCategories.vue";
import ProductVariationTypes from "./ProductVariationTypes.vue";

export default {
  name: "ProductList",
  components: {
    HollowDotsSpinner,
    Modal,
    ToggleSwitch,
    EditProduct,
    ProductCategories,
    ProductVariationTypes,
  },
  data() {
    return {
      products: [],
      categories: null,
      variationTypes: null,
      search: "",
      loading: false,
      showEditModal: false,
      showCategoryModal: false,
      showVariationModal: false,
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
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error fetching the products", {
            position: "top-right",
          });
        })
        .finally(() => {
          this.loading = false;
        });
    },
    fetchCategories() {
      axios
        .get("/api/products/categories")
        .then((response) => {
          this.categories = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error fetching the categories", {
            position: "top-right",
          });
        });
    },
    fetchVariationTypes() {
      axios
        .get("/api/products/variation-types")
        .then((response) => {
          this.variationTypes = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error fetching the variation types", {
            position: "top-right",
          });
        });
    },
    openEditModal(id) {
      this.selectedProduct = null;
      this.showEditModal = true;
      axios
        .get(`/api/products/${id}`)
        .then((response) => {
          this.selectedProduct = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error fetching the product", {
            position: "top-right",
          });
        });
    },
    openCategoryModal() {
      this.showCategoryModal = true;
    },
    openVariationModal() {
      this.showVariationModal = true;
    },
    updateProductActive(id, active) {
      axios
        .put(`/api/products/${id}/active`, {
          active: active,
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error updating the product", {
            position: "top-right",
          });
        });
    },
    addCagetory(category) {
      console.log(category);
      this.categories.push(category);
      this.fetchProducts();
    },
    deleteCategory(id) {
      this.categories = this.categories.filter((category) => {
        return category.id !== id;
      });
      this.fetchProducts();
    },
  },
  computed: {
    filteredProducts() {
      return this.products.filter((product) => {
        return (
          product.name.toLowerCase().includes(this.search.toLowerCase()) ||
          product.sku.toLowerCase().includes(this.search.toLowerCase()) ||
          product.category?.name
            .toLowerCase()
            .includes(this.search.toLowerCase())
        );
      });
    },
  },
};
</script>
