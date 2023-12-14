<template>
  <filters :options="options"></filters>
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
  <div v-if="loading" class="col-12 text-center">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</template>

<script>
import Filters from "./Filters.vue";
import Listing from "./Listing.vue";
export default {
  components: { Filters, Listing },
  data() {
    return {
      loading: false,
      complete: false,
      listings: [],
      options: {
        offset: 0,
        limit: 8,
        category_id: null,
        search: "",
        sort: null,
        sort_desc: 0,
      },
    };
  },
  methods: {
    getListings() {
      this.loading = true;
      axios
        .get("/api/listings", { params: this.options })
        .then((response) => {
          if (response.data.length == 0) {
            this.complete = true;
          }
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

