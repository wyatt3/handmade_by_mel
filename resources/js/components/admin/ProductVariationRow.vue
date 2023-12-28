<template>
  <div class="variation-table-row d-flex align-items-center"></div>
  <div class="variation-table-row d-flex align-items-center">
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
        @change="updateVariationActive(variation.id, variation.active)"
      />
    </span>
    <span class="half">
      <button class="btn btn-tertiary" @click="toggleEdit">
        <i class="bi bi-pencil"></i>
      </button>
    </span>
    <span class="half">
      <button class="btn btn-danger" @click="deleteVariation(variation.id)">
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
    };
  },
  methods: {
    updateVariationActive(variationId, active) {
      axios
        .put(`/api/products/variations/${variationId}/active`, {
          active: active,
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("There was an error updating the variation", {
            position: "top-right",
          });
        });
    },
    deleteVariation(variationId) {
      this.$root.$refs.confirm
        .show({
          title: "Confirm Delete",
          message: `Are you sure you want to delete this variation?`,
          okButton: "Delete",
        })
        .then(() => {
          axios
            .delete(`/api/products/variations/${variationId}`)
            .then((response) => {
              this.$toast.success("Variation deleted.", {
                position: "top-right",
              });
              this.$emit("variation-deleted", variationId);
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
