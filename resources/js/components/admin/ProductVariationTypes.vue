<template>
  <div class="container my-4">
    <h1>Product Variation Types</h1>
    <div v-if="variationTypes == null">
      <hollow-dots-spinner
        class="m-auto"
        :animation-duration="1000"
        :dot-size="20"
        :dots-num="3"
        color="#222E50"
      />
    </div>
    <div v-else>
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <variation-type-row
            v-for="variation in variationTypes"
            :key="variation.id"
            :variation="variation"
            @updated="$emit('updated')"
            @deleted="$emit('deleted', $event)"
          />
          <tr v-if="adding">
            <td class="w-75">
              <input
                type="text"
                class="form-control"
                v-model="newVariation"
                placeholder="Variation Type Name"
              />
            </td>
            <td>
              <button
                class="btn btn-primary"
                @click="createVariation"
                :disabled="newVariation.length <= 0"
              >
                <i class="bi bi-check"></i>
              </button>
            </td>
            <td>
              <button class="btn btn-danger" @click="toggleAdd">
                <i class="bi bi-x"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="!adding">
        <button class="fake-link" @click="toggleAdd">
          <i class="bi bi-plus"></i>Add New Variation Type
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { HollowDotsSpinner } from "epic-spinners";
import VariationTypeRow from "./ProductVariationTypeRow.vue";
export default {
  props: {
    variationTypes: {
      type: Array,
      required: true,
    },
  },
  components: {
    HollowDotsSpinner,
    VariationTypeRow,
  },
  data() {
    return {
      adding: false,
      newVariation: "",
    };
  },
  methods: {
    toggleAdd() {
      this.newVariation = "";
      this.adding = !this.adding;
    },
    createVariation() {
      axios
        .post("/api/products/variations/types", {
          name: this.newVariation,
        })
        .then((response) => {
          this.$toast.success("Variation type created.", {
            position: "top-right",
          });
          this.$emit("variation-type-updated");
          this.toggleAdd();
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Error creating variation type.", {
            position: "top-right",
          });
        });
    },
  },
};
</script>
