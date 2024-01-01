<template>
  <div>
    <input
      type="file"
      ref="image"
      style="display: none"
      @change="uploadImage"
    />
    <div v-if="editing" class="variation-table-row d-flex align-items-center">
      <span class="full input">
        <input class="form-control" v-model="variation.name" />
      </span>
      <span class="full input">
        <input class="form-control" v-model="variation.price_modifier" />
      </span>
      <span class="full">
        <div class="position-relative" v-if="variation.image">
          <img
            :src="variation.image"
            alt="variation image"
            style="max-width: 100px"
            @click="clickUploadButton"
            class="upload-button"
          />
          <button class="btn btn-danger circle" @click="removeImage">
            <i class="bi bi-x"></i>
          </button>
        </div>
        <button v-else class="btn btn-primary" @click="clickUploadButton">
          <i class="bi bi-upload"></i> Upload Image
        </button>
      </span>
      <span class="half">
        <toggle-switch
          v-model="variation.active"
          @change="updateVariationActive"
        />
      </span>
      <span class="half">
        <button class="btn btn-primary" @click="updateVariation">
          <i class="bi bi-check"></i>
        </button>
      </span>
      <span class="half">
        <button class="btn btn-danger" @click="toggleEdit">
          <i class="bi bi-x"></i>
        </button>
      </span>
      <span class="variation-handle half">
        <i class="bi bi-grip-vertical"></i>
      </span>
    </div>
    <div v-else class="variation-table-row d-flex align-items-center">
      <span class="full">{{ variation.name }}</span>
      <span class="full">${{ variation.price_modifier }}</span>
      <span class="full">
        <div class="position-relative" v-if="variation.image">
          <img
            :src="variation.image"
            alt="variation image"
            style="max-width: 100px"
            @click="clickUploadButton"
            class="upload-button"
          />
          <button
            class="btn btn-danger circle"
            @click="removeImage(variation.id)"
          >
            <i class="bi bi-x"></i>
          </button>
        </div>
        <button v-else class="btn btn-primary" @click="clickUploadButton">
          <i class="bi bi-upload"></i> Upload Image
        </button>
      </span>
      <span class="half">
        <toggle-switch
          v-model="variation.active"
          @change="updateVariationActive"
        />
      </span>
      <span class="half">
        <button class="btn btn-tertiary" @click="toggleEdit">
          <i class="bi bi-pencil"></i>
        </button>
      </span>
      <span class="half">
        <button class="btn btn-danger" @click="deleteVariation">
          <i class="bi bi-trash"></i>
        </button>
      </span>
      <span class="variation-handle half">
        <i class="bi bi-grip-vertical"></i>
      </span>
    </div>
  </div>
</template>

<script>
import ToggleSwitch from "../ToggleSwitch.vue";
export default {
  props: {
    variation: {
      type: Object,
      required: true,
    },
  },
  components: {
    ToggleSwitch,
  },
  data() {
    return {
      editing: false,
      originalName: "",
      originalPrice: 0,
    };
  },
  methods: {
    clickUploadButton() {
      this.$refs.image.click();
    },
    uploadImage() {
      const formData = new FormData();
      formData.append("image", this.$refs.image.files[0]);
      axios
        .post(`/api/products/variations/${this.variation.id}/image`, formData)
        .then((response) => {
          this.$toast.success("Image uploaded.", {
            position: "top-right",
          });
          this.variation.image = response.data.image;
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Error uploading image.", {
            position: "top-right",
          });
        });
    },
    removeImage() {
      axios
        .delete(`/api/products/variations/${this.variation.id}/image`)
        .then((response) => {
          this.$toast.success("Image removed.", {
            position: "top-right",
          });
          this.variation.image = null;
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Error removing image.", {
            position: "top-right",
          });
        });
    },
    toggleEdit() {
      this.editing = !this.editing;
      if (!this.editing) {
        this.variation.name = this.originalName;
        this.variation.price_modifier = this.originalPrice;
      } else {
        this.originalName = this.variation.name;
        this.originalPrice = this.variation.price_modifier;
      }
    },
    updateVariation() {
      axios
        .put(`/api/products/variations/${this.variation.id}`, {
          name: this.variation.name,
          price_modifier: this.variation.price_modifier,
        })
        .then((response) => {
          this.editing = false;
          this.$toast.success("Variation updated.", {
            position: "top-right",
          });
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Error updating variation.", {
            position: "top-right",
          });
        });
    },
    updateVariationActive() {
      axios
        .put(`/api/products/variations/${this.variation.id}/active`, {
          active: this.variation.active,
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error updating the variation", {
            position: "top-right",
          });
        });
    },
    deleteVariation() {
      this.$root.$refs.confirm
        .show({
          title: "Confirm Delete",
          message: `Are you sure you want to delete this variation?`,
          okButton: "Delete",
        })
        .then(() => {
          axios
            .delete(`/api/products/variations/${this.variation.id}`)
            .then((response) => {
              this.$toast.success("Variation deleted.", {
                position: "top-right",
              });
              this.$emit("variation-deleted", this.variation.id);
            })
            .catch((error) => {
              console.log(error);
              this.$toast.error("Error deleting variation.", {
                position: "top-right",
              });
            });
        });
    },
  },
};
</script>

<style scoped>
.full.input .form-control {
  width: 93%;
}

.upload-button {
  cursor: pointer;
}

.circle {
  border-radius: 100px;
  width: 20px;
  height: 20px;
  padding: 0;
  position: absolute;
  top: -3px;
  left: -8px;
}

.circle i {
  position: absolute;
  top: -1px;
  left: 2px;
}
</style>
