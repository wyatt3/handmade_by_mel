<template>
  <transition name="fade">
    <div class="modal-container" v-if="open">
      <div class="background" @click="toggle"></div>
      <div :class="['modal-body', 'bg-body', size]">
        <slot></slot>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "Modal",
  props: {
    open: {
      type: Boolean,
      required: true,
    },
    size: {
      type: String,
      default: "auto",
    },
  },
  emits: ["toggle"],
  methods: {
    toggle() {
      this.$emit("toggle");
    },
  },
  watch: {
    open(newVal) {
      if (newVal) {
        document.body.classList.add("modal-open");
      } else {
        document.body.classList.remove("modal-open");
      }
    },
  },
};
</script>

<style scoped>
.background {
  position: fixed;
  top: 0;
  left: 0;
  /* z-index: 1000; */
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
}
.modal-body {
  max-height: 95%;
  overflow-y: auto;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  /* z-index: 1001; */
  border-radius: 10px;
}

.auto {
  width: auto;
}

.md {
  width: 40vw;
}

@media screen and (max-width: 500px) {
  .auto {
    width: 90vw;
  }

  .md {
    width: auto;
  }
}

@media screen and (min-width: 501px) and (max-width: 960px) {
  .md {
    width: 55vw;
  }
}

.full {
  width: 90vw;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
