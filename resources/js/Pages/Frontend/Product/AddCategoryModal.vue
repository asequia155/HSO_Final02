<template>
    <!-- Main Modal -->
    <div v-if="isOpen" id="crud-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 overflow-y-auto overflow-x-hidden w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative w-full max-w-md max-h-full p-4">

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

          <!-- Modal Header -->
          <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Category</h3>
            <button @click.prevent="close" type="button" class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>

          <!-- Modal Body -->
          <form @submit.prevent="submit" class="p-4 md:p-5">
            <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-2">

              <!-- Category Name -->
              <div class="col-span-2">
                <label for="categoryName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category Name</label>
                <input v-model="categoryName" id="categoryName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter category name" required />
              </div>

              <!-- Category Description -->
              <div class="col-span-2">
                <label for="categoryDescription" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <textarea v-model="categoryDescription" id="categoryDescription" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter category description (optional)"></textarea>
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
  import { ref, defineProps, defineEmits } from 'vue';

  // Props to control the modal visibility
  const props = defineProps({
    isOpen: Boolean, // Whether the modal is open
  });

  // Emits to notify the parent component
  const emit = defineEmits();

  // Local state for the category name and description input
  const categoryName = ref('');
  const categoryDescription = ref('');

  // Submit handler
  const submit = () => {
  const trimmedName = categoryName.value.trim();
  const trimmedDescription = categoryDescription.value.trim();

  if (trimmedName === '') {
    alert('Category name cannot be empty.');
    return;
  }
  emit('add', trimmedName, trimmedDescription); // Emit the category name to the parent
  categoryName.value = ''; // Reset the input field after submission
  categoryDescription.value = ''; // Reset the description field

  close(); // Close the modal
};

// Close the modal
const close = () => {
  emit('close'); // Emit the close event to parent to change `isOpen` to false
};
</script>
