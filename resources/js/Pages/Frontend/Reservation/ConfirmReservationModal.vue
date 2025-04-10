<template>
    <div v-if="isOpen" class="fixed top-0 left-0 z-50 flex items-center justify-center w-full h-full rounded-lg">
      <!-- Background overlay -->
      <div class="absolute inset-0 bg-gray-900 opacity-50" @click="close"></div>

      <!-- Modal container -->
      <div class="relative w-full max-w-md max-h-full bg-white rounded-lg shadow dark:bg-gray-800">
        <!-- Modal header -->
        <div class="flex items-center justify-between px-4 py-2 bg-green-200 border-b dark:bg-gray-700">
          <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ title }}</h3>
          <button @click="close" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
            <span class="text-2xl">&times;</span>
          </button>
        </div>

        <!-- Modal body -->
        <div class="p-4 text-left">
          <!-- Main content or slot area -->
          <p class="mb-4 text-gray-700 dark:text-gray-300">
            Are you sure you want to <strong>confirm</strong> this reservation: <strong>{{ reservationName }}</strong>?
          </p>

          <div class="flex justify-end space-x-4">
            <button
              @click="close"
              class="px-4 py-2 text-sm text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 focus:outline-none"
            >
              Cancel
            </button>
            <button
              @click="confirm"
              class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
            >
              Confirm
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { defineProps, defineEmits } from 'vue';

  const props = defineProps({
    isOpen: Boolean,
    title: { type: String, default: 'Confirm Reservation' },
    reservationName: String, // Reservation name to display
  });

  const emit = defineEmits(['close', 'confirm']);

  const confirm = () => {
    emit('confirm', props.reservationName); // Emit the confirm event with reservationName
  };

  const close = () => {
    emit('close'); // Emit the close event to close the modal
  };
  </script>
