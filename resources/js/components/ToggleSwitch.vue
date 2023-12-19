<template>
  <label class="switch">
    <input type="checkbox" @click="toggleCheckbox" :checked="localModelValue" />
    <div class="slider round"></div>
  </label>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: [Boolean, Number],
      required: true,
    },
  },
  data() {
    return {
      localModelValue: this.modelValue,
    };
  },
  watch: {
    modelValue(newVal) {
      this.localModelValue = newVal;
    },
  },
  methods: {
    toggleCheckbox() {
      this.localModelValue = !this.localModelValue;
      this.$emit("update:modelValue", this.localModelValue);
    },
  },
  created() {
    this.localModelValue = Boolean(this.modelValue);
  },
};
</script>

<style scoped>
.switch {
  position: relative;
  display: inline-block;
  width: 48px;
  height: 25px;
}

.switch input {
  visibility: hidden;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #222e50;
}

input:focus + .slider {
  box-shadow: 0 0 1px #222e50;
}

input:checked + .slider:before {
  -webkit-transform: translateX(21px);
  -ms-transform: translateX(21px);
  transform: translateX(21px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
