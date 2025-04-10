<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
      <!-- Existing Close Button at the top-right -->
      <button @click="close" class="absolute p-2 text-2xl text-gray-500 transition duration-200 top-2 right-2 hover:text-gray-800">
        &times;
      </button>
      <h2 class="mb-4 text-xl font-semibold">Product Details</h2>
      <hr class="mb-4 border-t border-gray-300">
      <div v-if="product" class="mb-2">
        <p><strong>Name:</strong> <span class="text-gray-700">{{ product.name }}</span></p>
      </div>
      <div v-if="product" class="mb-2">
        <p><strong>Price:</strong> <span class="text-gray-700">₱{{ product.price.replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</span></p>
      </div>
      <div v-if="product" class="mb-2">
        <p><strong>Category:</strong> <span class="text-gray-700">{{ categoryMap[product.category_id] || 'Uncategorized' }}</span></p>
      </div>
      <div v-if="product" class="mb-2">
        <p><strong>Quantity:</strong> <span class="text-gray-700">{{ product.quantity }}</span></p>
      </div>
      <div v-if="product" class="mb-2">
        <p><strong>Description:</strong> <span class="text-gray-700">{{ product.description }}</span></p>
      </div>

      <!-- Close Button under the Description -->
      <div class="mt-4 text-right">
        <button @click="close" class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-600 rounded-lg hover:bg-gray-600">
          Close
        </button>
      </div>
    </div>
  </div>
</template>




<script setup>
import { defineProps, defineEmits, computed } from 'vue';

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
  product: {
    type: Object,
    default: () => null, // Allow product to be null by default
  },
  category: {
    type: Array,
    required: true,
    default: () => [],
  },
});

const emit = defineEmits(['close']);

// Create a computed property to map category IDs to category names
const categoryMap = computed(() => {
  const map = {};
  props.category.forEach((category) => {
    map[category.id] = category.name;
  });
  return map;
});

// Emit a 'close' event when the close button is clicked
const close = () => {
  emit('close');
};
</script>
