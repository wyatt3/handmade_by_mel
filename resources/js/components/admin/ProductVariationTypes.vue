<template>
  <div class="container my-4">
    <h1>Product Variation Types</h1>
    <div v-if="variationTypes <= 0">
      <hollow-dots-spinner
        class="m-auto"
        :animation-duration="1000"
        :dot-size="20"
        :dots-num="3"
        color="#222E50"
      />
    </div>
    <div v-else>
      {{ variationTypes }}
    </div>
  </div>
</template>

<script>
import { HollowDotsSpinner } from "epic-spinners";
export default {
  props: {
    variationTypes: {
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
