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
      <div class="category-table">
        <div class="variation-table-header d-flex">
          <span class="full">Name</span>
          <span class="half">Edit</span>
          <span class="half">Delete</span>
        </div>
        <div v-for="category in categories" :key="category.id">
          <div class="category-name">{{ category.name }}</div>
          <div class="category-actions">
            <button class="btn btn-sm btn-primary">Edit</button>
            <button class="btn btn-sm btn-danger">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { HollowDotsSpinner } from "epic-spinners";
export default {
  props: {
    categories: {
      type: Array,
      required: true,
    },
  },
  components: {
    HollowDotsSpinner,
  },
  data() {
    return {};
  },
};
</script>

<style scoped>
</style>
