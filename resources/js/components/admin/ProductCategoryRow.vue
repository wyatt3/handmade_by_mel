<template>
  <tr v-if="editing">
    <td class="w-75">
      <input type="text" class="form-control" v-model="category.name" />
    </td>
    <td>
      <button
        class="btn btn-primary"
        @click="updateCategory"
        :disabled="category.name.length <= 0"
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
      <span>{{ category.name }}</span>
    </td>
    <td>
      <button class="btn btn-warning" @click="toggleEdit">
        <i class="bi bi-pencil"></i>
      </button>
    </td>
    <td>
      <button class="btn btn-danger" @click="deleteCategory">
        <i class="bi bi-trash"></i>
      </button>
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    category: {
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
        this.category.name = this.originalName;
      } else {
        this.originalName = this.category.name;
      }
    },
    updateCategory() {
      axios
        .put(`/api/products/categories/${this.category.id}`, {
          name: this.category.name,
        })
        .then((response) => {
          this.editing = false;
          this.$toast.success("Category updated.", {
            position: "top-right",
          });
          this.$emit("updated");
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Error updating category.", {
            position: "top-right",
          });
        });
    },
    deleteCategory() {
      axios
        .delete(`/api/products/categories/${this.category.id}`)
        .then((response) => {
          this.$toast.success("Category deleted.", {
            position: "top-right",
          });
          this.$emit("deleted", this.category.id);
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Error deleting category.", {
            position: "top-right",
          });
        });
    },
  },
};
</script>
