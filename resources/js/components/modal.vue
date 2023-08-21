

<template>
    <Transition name="modal">
      <div v-if="show" class="modal-mask modal" tabindex="-1">
        <div class="modal-wrapper modal-dialog modal-fullscreen modal-lg">
          <div class="modal-container modal-content">
            <div class="modal-header" v-if="$slots.header">
              <slot name="header">default header</slot>
            </div>

            <div class="modal-body">
              <slot name="body">default body</slot>
            </div>

            <div class="modal-footer" v-if="$slots.footer">
              <slot name="footer">

              </slot>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </template>


  <script setup>
  import { ref } from "vue";
  const props = defineProps({
    show: Boolean,
  });
  </script>

  <style>
  .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: block;
    transition: opacity 0.3s ease;
  }

  .modal-wrapper {
    vertical-align: middle;
  }

  .modal-container {
    margin: 0px auto;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
  }

  .modal-header h3 {
    margin-top: 0;
    color: black;
  }

  .modal-body {
    margin: 20px 0;
  }

  .modal-default-button {
    float: right;
  }

  /*
   * The following styles are auto-applied to elements with
   * transition="modal" when their visibility is toggled
   * by Vue.js.
   *
   * You can easily play with the modal transition by editing
   * these styles.
   */

  .modal-enter-from {
    opacity: 0;
  }

  .modal-leave-to {
    opacity: 0;
  }

  .modal-enter-from .modal-container,
  .modal-leave-to .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }
  </style>
