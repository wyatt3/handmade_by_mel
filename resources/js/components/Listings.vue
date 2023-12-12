<template>
  <div
    class="row gx-4 gx-lg-5 row-cols-2 row-cols-lg-4 justify-content-center"
    ref="scrollComponent"
  >
    <listing
      v-for="product in listings"
      :key="product.id"
      :product="product"
    ></listing>
  </div>
</template>

<script>
import Listing from "./Listing.vue";
export default {
  components: { Listing },
  data() {
    return {
      loading: false,
      listings: [],
      options: {
        offset: 0,
        limit: 10,
        category_id: null,
        search: "",
      },
    };
  },
  methods: {
    getListings() {
      this.loading = true;
      axios
        .get("/api/listings", { params: this.options })
        .then((response) => {
          this.listings.push(...response.data);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    handleScroll(e) {
      let element = this.$refs.scrollComponent;

      if (element.getBoundingClientRect().bottom + 150 < window.innerHeight) {
        if (!this.loading && !this.complete) {
          this.options.offset += this.options.limit;
          this.getListings();
        }
      }
    },
  },
  created() {
    this.getListings();
  },
  mounted() {
    window.addEventListener("scroll", this.handleScroll);
  },
};
</script>

