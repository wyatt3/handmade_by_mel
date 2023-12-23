<template>
  <tr v-if="editing">
    <td class="w-75">
      <input type="text" class="form-control" v-model="variation.name" />
    </td>
    <td>
      <button
        class="btn btn-primary"
        @click="updateVariation"
        :disabled="variation.name.length <= 0"
      >
        <i class="bi bi-check"></i>
      </button>
    </td>
    <td>
      <button class="btn btn-danger" @click="toggleEdit">
        <i class="bi bi-x"></i>
      </button>
    </td>
  </tr>
  <tr v-else>
    <td class="w-75">
      <span>{{ variation.name }}</span>
    </td>
    <td>
      <button class="btn btn-warning" @click="toggleEdit">
        <i class="bi bi-pencil"></i>
      </button>
    </td>
    <td>
      <button class="btn btn-danger" @click="deleteVariation">
        <i class="bi bi-trash"></i>
      </button>
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    variation: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      editing: false,
      originalName: "",
    };
  },
  methods: {
    toggleEdit() {
      this.editing = !this.editing;
      if (!this.editing) {
        this.variation.name = this.originalName;
      } else {
        this.originalName = this.variation.name;
      }
    },
    updateVariation() {
      axios
        .put(`/api/products/variations/types/${this.variation.id}`, {
          name: this.variation.name,
        })
        .then((response) => {
          this.editing = false;
          this.$toast.success("Variation Type updated.", {
            position: "top-right",
          });
          this.$emit("updated");
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Error updating variation type.", {
            position: "top-right",
          });
        });
    },
    deleteVariation() {
      axios
        .delete(`/api/products/variations/types/${this.variation.id}`)
        .then((response) => {
          this.$toast.success("Variation Type deleted.", {
            position: "top-right",
          });
          this.$emit("deleted", this.variation.id);
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Error deleting variation type.", {
            position: "top-right",
          });
        });
    },
  },
};
</script>
