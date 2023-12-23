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

          <div class="variation-table">
            <div class="variation-table-header d-flex">
              <span class="full">Name</span>
              <span class="full">Price Modifier</span>
              <span class="full">Image</span>
              <span class="half">Active</span>
              <span class="half">Edit</span>
              <span class="half">Delete</span>
              <span class="half"></span>
            </div>
            <div>
              <draggable
                v-model="product.groupedVariations[typeName]"
                :options="dragOptions"
                @start="drag = true"
                @end="endDrag"
              >
                <div
                  class="variation-table-row d-flex align-items-center"
                  v-for="variation in variations"
                  :key="variation.id"
                >
                  <span class="full">{{ variation.name }}</span>
                  <span class="full">${{ variation.price_modifier }}</span>
                  <span class="full">
                    <img
                      :src="variation.image"
                      alt="variation image"
                      style="max-width: 100px"
                    />
                  </span>
                  <span class="half">
                    <toggle-switch v-model="variation.active" />
                  </span>
                  <span class="half">
                    <button class="btn btn-tertiary">
                      <i class="bi bi-pencil"></i>
                    </button>
                  </span>
                  <span class="half">
                    <button class="btn btn-danger">
                      <i class="bi bi-trash"></i>
                    </button>
                  </span>
                  <span class="variation-handle half">
                    <i class="bi bi-grip-vertical"></i>
                  </span>
                </div>
              </draggable>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { VueDraggableNext } from "vue-draggable-next";
import { HollowDotsSpinner } from "epic-spinners";
import ToggleSwitch from "../ToggleSwitch.vue";
export default {
  components: {
    draggable: VueDraggableNext,
    HollowDotsSpinner,
    ToggleSwitch,
  },
  props: {
    product: {
      type: Object,
      required: false,
    },
    categories: {
      type: Array,
      required: false,
    },
    variationTypes: {
      type: Array,
      required: false,
    },
  },
  data() {
    return {
      drag: false,
    };
  },
  methods: {
    saveProduct() {
      axios
        .put(`/api/admin/products/${this.product.id}`, this.product)
        .then((response) => {
          this.$toast.success("Product updated successfully", {
            position: "top-right",
          });
          this.$emit("product-updated");
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error updating the product", {
            position: "top-right",
          });
        });
    },
    endDrag() {
      this.drag = false;
    },
  },
  computed: {
    dragOptions() {
      return {
        animation: 200,
        group: "description",
        disabled: false,
        ghostClass: "ghost",
      };
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

.variation-handle {
  cursor: ns-resize;
}

.variation-handle i {
  font-size: 1.3rem;
}

.variation-table-header {
  font-weight: bold;
  border-bottom: 1px solid #ccc;
  padding: 0.5rem 0;
}

.variation-table-row {
  border-bottom: 1px solid #ccc;
  padding: 0.25rem 0;
}

.variation-table-header span.full,
.variation-table-row span.full {
  flex: 1;
}

.variation-table-header span.half,
.variation-table-row span.half {
  flex: 0.5;
}

.variation-table-header span.half:last-child,
.variation-table-row span.half:last-child {
  text-align: right;
}
</style>
