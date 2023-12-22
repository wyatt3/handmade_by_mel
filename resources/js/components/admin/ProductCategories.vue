<template>
  <div class="container my-4">
    <h1>Product Categories</h1>
    <div v-if="categories.length <= 0">
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
            @deleted="$emit('deleted')"
          />
        </tbody>
      </table>
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
};
</script>

<style scoped>
</style>
