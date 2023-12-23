<template>
  <div class="container my-4">
    <h1>Product Categories</h1>
    <div v-if="categories == null">
      <hollow-dots-spinner
        class="m-auto"
        :animation-duration="1000"
        :dot-size="20"
        :dots-num="3"
        color="#222E50"
      />
    </div>
    <div v-else>
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <product-category-row
            v-for="category in categories"
            :key="category.id"
            :category="category"
            @updated="$emit('updated')"
            @deleted="$emit('deleted', $event)"
          />
          <tr v-if="adding">
            <td class="w-75">
              <input
                type="text"
                class="form-control"
                v-model="newCategory"
                placeholder="Category Name"
              />
            </td>
            <td>
              <button
                class="btn btn-primary"
                @click="createCategory"
                :disabled="newCategory.length <= 0"
              >
                <i class="bi bi-check"></i>
              </button>
            </td>
            <td>
              <button class="btn btn-danger" @click="toggleAdd">
                <i class="bi bi-x"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="!adding">
        <button class="fake-link" @click="toggleAdd">
          <i class="bi bi-plus"></i>Add New Category
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { HollowDotsSpinner } from "epic-spinners";
import ProductCategoryRow from "./ProductCategoryRow.vue";
export default {
  props: {
    categories: {
      type: Array,
      required: true,
    },
  },
  components: {
    HollowDotsSpinner,
    ProductCategoryRow,
  },
  data() {
    return {
      adding: false,
      newCategory: "",
    };
  },
  methods: {
    toggleAdd() {
      this.adding = !this.adding;
      this.newCategory = "";
    },
    createCategory() {
      axios
        .post("/api/products/categories", {
          name: this.newCategory,
        })
        .then((response) => {
          this.$emit("created", response.data);
          this.$toast.success("Category created.", {
            position: "top-right",
          });
          this.toggleAdd();
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Error creating category.", {
            position: "top-right",
          });
        });
    },
  },
};
</script>

<style scoped>
</style>
