<template>
    <div v-if="isOpen" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full relative">
        <button
          class="absolute top-2 right-2 text-gray-600 hover:text-gray-900"
          @click="closeModal"
        >
          <i class="fas fa-times"></i>
        </button>
        <div class="text-center">
          <h2 class="text-xl font-semibold text-gray-800 mb-4">Notification</h2>
          <p class="text-gray-600">{{ message }}</p>
          <button
            @click="closeModal"
            class="bg-red-600 text-white px-4 py-2 mt-4 rounded-md hover:bg-red-700"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue';
  
  const props = defineProps({
    isOpen: Boolean,
    message: {
      type: String,
      default: 'Your cart is empty.',
    },
  });
  
  const emit = defineEmits(['close']);
  
  const closeModal = () => {
    emit('close');
  };
  </script>
  
  <style scoped>
  /* Modal background and styles */
  .fixed {
    position: fixed;
  }
  </style>
  