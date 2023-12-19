<template>
  <div class="container my-4 edit-modal-body">
    <h1>Edit Product</h1>
    <div class="edit-modal-loading" v-if="!product">
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
        <div class="col-12 col-md-6 mb-2">
          <label for="productName">Name</label>
          <input
            type="text"
            class="form-control"
            id="productName"
            v-model="product.name"
          />
        </div>
        <div class="col-12 col-md-6 mb-2">
          <label for="productSku">SKU</label>
          <input
            type="text"
            class="form-control"
            id="productSku"
            v-model="product.sku"
          />
        </div>
        <div class="col-12 col-md-6 mb-2">
          <label for="productPrice">Price</label>
          <input
            type="number"
            class="form-control"
            id="productPrice"
            v-model="product.price"
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
            v-model="product.sale_price"
          />
        </div>
        <div class="col-12 mb-2">
          <label for="productDescription">Description</label>
          <textarea
            class="form-control"
            id="productDescription"
            v-model="product.description"
          ></textarea>
        </div>
        <div class="col-12 mb-3">
          <label for="productCategory">Category</label>
          <select
            class="form-control"
            id="productCategory"
            v-model="product.product_category_id"
          >
            <option
              v-for="category in categories"
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </div>
        <h4>Product Variations</h4>
        <div
          class="col-12 mb-2"
          v-for="(variations, typeName) in product.groupedVariations"
          :key="typeName"
        >
          <label>{{ typeName }}</label>
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Price Modifier</th>
                <th>Image</th>
                <th>Active</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Reorder</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { HollowDotsSpinner } from "epic-spinners";
export default {
  components: {
    HollowDotsSpinner,
  },
  props: {
    product: {
      type: Object,
      required: false,
    },
  },
  methods: {
    saveProduct() {
      axios
        .put(`/api/admin/products/${this.product.id}`, this.product)
        .then((response) => {
          this.$emit("product-updated");
        });
    },
  },
};
</script>

<style scoped>
</style>
