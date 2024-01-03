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
        <product-images :product="product" />
        <h4 class="mb-3">Product Variations</h4>
        <div
          class="col-12 mb-4"
          v-for="(variations, typeName) in product.groupedVariations"
          :key="typeName"
        >
          <h5 class="mb-0">{{ typeName }}</h5>

          <div class="variation-table">
            <div class="variation-table-header d-flex">
              <span class="full">Name</span>
              <span class="full">Price Modifier</span>
              <span class="full">Image (Click to Replace)</span>
              <span class="half">Active</span>
              <span class="half">Edit</span>
              <span class="half">Delete</span>
              <span class="half"></span>
            </div>
            <div>
              <draggable
                v-model="product.groupedVariations[typeName]"
                handle=".variation-handle"
                :options="dragOptions"
                @start="drag = true"
                @end="endDrag(product.groupedVariations[typeName])"
              >
                <product-variation-row
                  v-for="variation in variations"
                  :key="variation.id"
                  :variation="variation"
                  @variation-deleted="removeVariation(variation.id, typeName)"
                ></product-variation-row>
              </draggable>
            </div>
          </div>
        </div>
        <div class="col-12 mb-4">
          <h3>Add a New Variation</h3>
          <div class="row">
            <div class="col-12 col-md-4 mb-2">
              <label>Type</label>
              <select class="form-control" v-model="newVariationTypeId">
                <option value="0" selected disabled hidden>
                  -- Select a type --
                </option>
                <option
                  v-for="type in variationTypes"
                  :key="type.id"
                  :value="type.id"
                >
                  {{ type.name }}
                </option>
              </select>
            </div>
            <div class="col-12 col-md-4 mb-2">
              <label>Name</label>
              <input
                type="text"
                class="form-control"
                v-model="newName"
                placeholder="Name"
              />
            </div>
            <div class="col-12 col-md-3 mb-2">
              <label>Price Modifier</label>
              <div class="input-group">
                <div class="input-group-text">$</div>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Price Modifier"
                  v-model="newPriceModifier"
                />
              </div>
            </div>
            <div class="col-12 col-md-1 mb-2 d-flex flex-column-reverse">
              <button
                class="btn btn-primary"
                :disabled="
                  newVariationTypeId == null ||
                  newPriceModifier.length <= 0 ||
                  newName <= 0
                "
                @click="addVariation"
              >
                <i class="bi bi-plus"></i>
              </button>
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
import ProductVariationRow from "./ProductVariationRow.vue";
import ProductImages from "./ProductImages.vue";
export default {
  components: {
    draggable: VueDraggableNext,
    HollowDotsSpinner,
    ProductVariationRow,
    ProductImages,
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
      newVariationTypeId: 0,
      newName: "",
      newPriceModifier: "",
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
    addVariation() {
      axios
        .post(`/api/products/variations`, {
          name: this.newName,
          price_modifier: this.newPriceModifier,
          product_id: this.product.id,
          product_variation_type_id: this.newVariationTypeId,
        })
        .then((response) => {
          this.$toast.success("Variation added successfully", {
            position: "top-right",
          });
          this.product.groupedVariations[
            this.variationTypes.find(
              (type) => type.id === this.newVariationTypeId
            ).name
          ].push(response.data);
          this.newVariationTypeId = 0;
          this.newName = "";
          this.newPriceModifier = "";
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error adding the variation", {
            position: "top-right",
          });
        });
    },
    removeVariation(variationId, typeName) {
      this.product.groupedVariations[typeName] = this.product.groupedVariations[
        typeName
      ].filter((variation) => variation.id !== variationId);
      if (this.product.groupedVariations[typeName].length === 0) {
        delete this.product.groupedVariations[typeName];
      }
    },
    endDrag(variations) {
      this.drag = false;
      variations.forEach((variation, index) => {
        axios
          .put(`/api/products/variations/${variation.id}/order`, {
            order: index,
          })
          .catch((error) => {
            console.log(error);
            this.$toast.error("There was an error updating the variation", {
              position: "top-right",
            });
          });
      });
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
</style>
