<template>
    <div v-if="isOpen" class="fixed top-0 left-0 z-50 flex items-center justify-center w-full h-full">
      <!-- Background overlay -->
      <div class="bg-gray-900 opacity-50" @click="close"></div>

      <!-- Modal container -->
      <div class="relative w-full max-w-md max-h-full bg-white shadow dark:bg-gray-800">
        <!-- Modal header -->
        <div class="flex items-center justify-between px-4 py-2 bg-red-200 border-b dark:bg-gray-700">
          <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ title }}</h3>
          <button @click="close" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
            <span class="text-2xl">&times;</span>
          </button>
        </div>

        <!-- Modal body -->
        <div class="p-4 text-left">
          <!-- Main content or slot area -->
          <p class="mb-4 text-gray-700 dark:text-gray-300">
            Are you sure you want to reject this reservation: <strong>{{ reservationName }}</strong>?
          </p>

          <div class="flex justify-end space-x-4">
            <button
              @click="close"
              class="px-4 py-2 text-sm text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 focus:outline-none"
            >
              Cancel
            </button>
            <button
              @click="confirmDelete"
              class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
            >
              Delete
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
  title: { type: String, default: 'Confirm Reject' },
  reservationName: String, // Reservation name to display
});

const emit = defineEmits(['close', 'confirm']);

const confirmDelete = () => {
  emit('confirm', props.reservationName); // Emit the confirm event with reservationName
};

const close = () => {
  emit('close'); // Emit the close event to close the modal
};
</script>
