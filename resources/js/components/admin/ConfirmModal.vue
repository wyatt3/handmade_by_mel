<template>
  <modal :open="open" class="confirm-modal">
    <div class="container my-3">
      <h1 v-text="title"></h1>
      <p class="message" v-html="message"></p>
      <div class="d-flex justify-content-center">
        <button
          class="btn btn-tertiary mx-2"
          @click="_cancel"
          v-text="cancelButton"
        ></button>
        <button
          class="btn btn-danger mx-2"
          @click="_confirm"
          v-text="okButton"
        ></button>
      </div>
    </div>
  </modal>
</template>

<script>
import Modal from "../Modal.vue";

export default {
  name: "ConfirmDialogue",
  components: { Modal },
  data() {
    return {
      title: undefined,
      message: undefined, // Main text content
      okButton: undefined, // Text for confirm button; leave it empty because we don't know what we're using it for
      cancelButton: "Go Back", // text for cancel button

      // Private variables
      open: false,
      resolvePromise: undefined,
      rejectPromise: undefined,
    };
  },
  methods: {
    show(opts = {}) {
      this.title = opts.title;
      this.message = opts.message;
      this.okButton = opts.okButton;
      if (opts.cancelButton) {
        this.cancelButton = opts.cancelButton;
      }
      // Once we set our config, we tell the popup modal to open
      this.open = true;
      // Return promise so the caller can get results
      return new Promise((resolve, reject) => {
        this.resolvePromise = resolve;
        this.rejectPromise = reject;
      });
    },
    _confirm() {
      this.open = false;
      this.resolvePromise(true);
    },
    _cancel() {
      this.open = false;
      this.rejectPromise(new Error("User canceled the dialogue"));
    },
  },
};
</script>

<style scoped>
.confirm-modal {
  z-index: 2000;
  position: relative;
}

.message {
  white-space: pre-wrap;
  font-size: 1rem;
}
</style>
