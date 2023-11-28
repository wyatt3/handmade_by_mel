<template>
  <div
    class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center"
    id="infinite-list"
  >
    <div class="col mb-5" v-for="product in listings" :key="product.id">
      <div class="card h-100">
        <!-- Product image-->
        <a :href="'/listings/' + product.name">
          <img
            class="card-img-top"
            src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg"
            alt="..."
          />
        </a>
        <!-- Product details-->
        <div class="card-body p-4">
          <div class="text-center">
            <!-- Product name-->
            <a :href="'/listings/' + product.name">
              <h5 class="fw-bolder">{{ product.name }}</h5>
            </a>
            <!-- Product price-->
            ${{ product.price }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
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

