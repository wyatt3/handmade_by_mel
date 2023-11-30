<template>
  <div
    class="row gx-4 gx-lg-5 row-cols-2 row-cols-lg-4 justify-content-center"
    id="infinite-list"
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
      axios.get("/api/listings", { params: this.options }).then((response) => {
        this.listings.push(...response.data);
      });
    },
  },
  created() {
    this.getListings();
  },
  mounted() {
    const listElm = document.querySelector("#infinite-list");
    console.log(listElm.scrollTop + listElm.clientHeight);
    listElm.addEventListener("scroll", (e) => {
      if (listElm.scrollTop + listElm.clientHeight >= listElm.scrollHeight) {
        // this.loadMore();
      }
    });
  },
};
</script>

