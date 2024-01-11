<template>
  <div class="custom-select" :tabindex="tabindex" @blur="open = false">
    <div
      class="selected d-flex justify-content-between"
      :class="{ open: open }"
      @click="open = !open"
    >
      <span v-text="selected.name ? selected.name : selected"></span>
      <span
        class="price-modifier"
        v-if="selected.price_modifier"
        v-text="`+$${selected.price_modifier}`"
      ></span>
    </div>
    <div class="items" :class="{ selectHide: !open }">
      <div
        class="d-flex justify-content-between"
        v-for="(option, i) of options"
        :key="i"
        @click="
          selected = option;
          open = false;
          $emit('change', option);
        "
      >
        <span v-text="option.name"></span>
        <span
          class="price-modifier"
          v-if="option.price_modifier"
          v-text="`+$${option.price_modifier}`"
        ></span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    options: {
      type: Array,
      required: true,
    },
    default: {
      type: String,
      required: false,
      default: null,
    },
    tabindex: {
      type: Number,
      required: false,
      default: 0,
    },
  },
  data() {
    return {
      selected: this.default
        ? this.default
        : this.options.length > 0
        ? this.options[0]
        : null,
      open: false,
    };
  },
  mounted() {
    this.$emit("input", this.selected);
  },
};
</script>

<style scoped>
.custom-select {
  position: relative;
  width: 100%;
  text-align: left;
  outline: none;
  height: 47px;
  line-height: 47px;
}

.custom-select .selected {
  background-color: #f8fafc;
  border-radius: 6px;
  border: 1px solid #666666;
  color: #000;
  padding-left: 1em;
  padding-right: 2.25em;
  cursor: pointer;
  user-select: none;
}

.custom-select .selected.open {
  border: 1px solid #000;
  border-radius: 6px 6px 0px 0px;
}

.custom-select .selected:after {
  position: absolute;
  content: "";
  top: 22px;
  right: 1em;
  width: 0;
  height: 0;
  border: 5px solid transparent;
  border-color: #000 transparent transparent transparent;
}

.custom-select .items {
  color: #000;
  border-radius: 0px 0px 6px 6px;
  overflow: hidden;
  border-right: 1px solid #000;
  border-left: 1px solid #000;
  border-bottom: 1px solid #000;
  position: absolute;
  background-color: #fff;
  left: 0;
  right: 0;
  z-index: 1;
}

.custom-select .items div {
  color: #000;
  padding: 0 1em;
  cursor: pointer;
  user-select: none;
}

.custom-select .items div:hover {
  background-color: #95b2b8;
}

.selectHide {
  display: none;
}

.price-modifier {
  color: #777;
  font-weight: 600;
}
</style>
