<template>
  <tr v-if="editing">
    <td class="w-75">
      <input type="text" class="form-control" v-model="category.name" />
    </td>
    <td>
      <button class="btn btn-primary" @click="saveCategory">
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
    saveCategory() {
      axios
        .put(`/products/categories/${this.category.id}`, {
          name: this.category.name,
        })
        .then((response) => {
          this.toggleEdit();
          this.$emit("updated");
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteCategory() {
      axios
        .delete(`/products/categories/${this.category.id}`)
        .then((response) => {
          this.$emit("deleted");
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
</style>
