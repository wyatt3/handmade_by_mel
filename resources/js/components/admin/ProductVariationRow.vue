<template>
  <div v-if="editing" class="variation-table-row d-flex align-items-center">
    <span class="full input">
      <input class="form-control" v-model="variation.name" />
    </span>
    <span class="full input">
      <input class="form-control" v-model="variation.price_modifier" />
    </span>
    <span class="full">
      <img
        :src="variation.image"
        alt="variation image"
        style="max-width: 100px"
      />
    </span>
    <span class="half">
      <toggle-switch
        v-model="variation.active"
        @change="updateVariationActive"
      />
    </span>
    <span class="half">
      <button class="btn btn-primary" @click="updateVariation">
        {{ variation.order }}
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
      <img
        :src="variation.image"
        alt="variation image"
        style="max-width: 100px"
      />
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
</style>
