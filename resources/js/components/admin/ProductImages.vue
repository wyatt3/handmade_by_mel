<template>
  <h4>Product Images</h4>
  <draggable
    class="row"
    v-model="product.sortedImages"
    handle=".handle"
    :options="dragOptions"
    @start="drag = true"
    @end="endDrag()"
  >
    <div
      v-for="image in product.sortedImages"
      :key="image.id"
      class="col-12 col-md-6 col-lg-3 position-relative mb-3"
    >
      <button class="btn btn-danger circle" @click="deleteImage(image.id)">
        <i class="bi bi-x"></i>
      </button>
      <img
        class="w-100 handle"
        :src="image.path"
        :alt="'Product Image ' + image.id"
      />
    </div>
    <div
      class="col-12 col-md-6 col-lg-3 d-flex justify-content-center align-items-center py-4"
    >
      <button class="btn btn-primary" @click="openImageUpload">
        <i class="bi bi-plus"></i>
      </button>
      <input
        type="file"
        multiple
        ref="imageUpload"
        @change="uploadImage"
        hidden
      />
    </div>
  </draggable>
</template>

<script>
import { VueDraggableNext } from "vue-draggable-next";
export default {
  props: {
    product: {
      type: Object,
      required: false,
    },
  },
  components: {
    draggable: VueDraggableNext,
  },
  data() {
    return {
      drag: false,
    };
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
  methods: {
    endDrag() {
      this.drag = false;
      this.product.sortedImages.forEach((image, index) => {
        axios
          .put(`/api/products/images/${image.id}`, {
            order: index + 1,
          })
          .catch((error) => {
            console.log(error);
            this.$toast.error("Unable to update image order", {
              position: "top-right",
            });
          });
      });
    },
    openImageUpload() {
      this.$refs.imageUpload.click();
    },
    uploadImage(event) {
      const files = event.target.files;
      const formData = new FormData();
      for (let i = 0; i < files.length; i++) {
        formData.append("images[]", files[i]);
      }
      formData.append("product_id", this.product.id);
      axios
        .post(`/api/products/images`, formData)
        .then((response) => {
          this.product.sortedImages = [
            ...this.product.sortedImages,
            ...response.data,
          ];
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Unable to upload images", {
            position: "top-right",
          });
        });
    },
    deleteImage(imageId) {
      axios
        .delete(`/api/products/images/${imageId}`)
        .then((response) => {
          this.product.sortedImages = this.product.sortedImages.filter(
            (image) => image.id !== imageId
          );
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Unable to delete image", {
            position: "top-right",
          });
        });
    },
  },
};
</script>

<style scoped>
.circle {
  border-radius: 100px;
  width: 25px;
  height: 25px;
  padding: 0;
  position: absolute;
  top: -12px;
  left: 0;
  z-index: 1;
}
</style>
