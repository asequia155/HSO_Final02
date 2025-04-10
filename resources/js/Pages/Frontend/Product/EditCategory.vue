<template>
    <div v-if="isOpen" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
      <div class="relative w-full max-w-md max-h-full p-4">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
          <!-- Modal header -->
          <div class="flex items-center justify-between pb-4 mb-4 border-b rounded-t sm:mb-5 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update Category</h3>
            <button type="button" @click.prevent="close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
              <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <form @submit.prevent="submit">
            <div class="grid gap-4 mb-4">
              <div class="flex items-center space-x-4">
                <label for="name" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white">Category Name: </label>
                <!-- Use v-model to bind to the category name -->
                <input v-model="category.name" id="name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-2/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 capitalize" placeholder="Ex. Apple iMac 27&ldquo;" required />
              </div>
              <div class="flex items-center space-x-4">
                <label for="description" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white">Description: </label>
                <textarea v-model="category.description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-2/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Add category description (optional)"></textarea>
              </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex justify-between mt-4">
              <button @click.prevent="close" type="button" class="px-4 py-2 text-black transition bg-gray-300 rounded-lg hover:bg-gray-400 dark:bg-gray-500 dark:text-white dark:hover:bg-gray-600">
                Cancel
              </button>
              <button type="submit" class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-600 rounded-lg hover:bg-gray-600">
                Add Category
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, defineProps, defineEmits, watch } from 'vue';

  const props = defineProps(['isOpen', 'category']);
  const emit = defineEmits();

  // Initialize category data with default values
  const category = ref({
  name: '',
  description: '',
  });

  // Watch for changes in the category prop and update the category data accordingly
  watch(
  () => props.category,
  (newValue) => {
    if (newValue) {
      category.value.name = newValue.name || ''; // Set category name
      category.value.description = newValue.description || ''; // Set category description
    }
  },
  { immediate: true }
  );

  // Handle form submission
  const submit = () => {
  console.log('Submitting Updated Category:', category.value); // Log the data being emitted
  emit('save', { id: props.category.id, ...category.value }); // Include the id in the emitted data
  close(); // Close the modal after submission
  };

  // Close modal
  const close = () => {
  emit('close'); // Emit a close event to the parent component
  };
  </script>

  <style scoped>
  /* Optional: You can add some additional styles here */
  </style>
