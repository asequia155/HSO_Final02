<template>
    <div v-if="isOpen" tabindex="-1" aria-hidden="true" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-[50]">
      <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
          <!-- Modal header -->
          <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Stock</h3>
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
                <label for="quantity" class="text-sm font-medium text-gray-900 dark:text-white w-1/3">Quantity: </label>
                <input v-model.number="newQuantity" id="quantity" type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-2/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0" required min="1" />
              </div>
            </div>
  
            <!-- Buttons container -->
            <div class="flex justify-end space-x-4">
              <button type="submit" class="text-white bg-red-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Add
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineProps, defineEmits, watch } from 'vue';
  
  const props = defineProps(['isOpen', 'product']);
  const emit = defineEmits();
  
  // Initialize product data with default values
  const product = ref({
    name: '',
    price: null, // Initialize with null to handle invalid inputs
    description: '',
    category_id: '',
    quantity: null // Default value for quantity
  });
  
  // Store the value entered in the input field for quantity
  const newQuantity = ref(0);
  
  // Watch for changes in the product prop and update local product data
  watch(
    () => props.product,
    (newValue) => {
      if (newValue) {
        product.value = {
          name: newValue.name,
          price: newValue.price,
          description: newValue.description,
          category_id: newValue.category_id, // Default to "Others" if not present
          quantity: newValue.quantity || 0 // Default value for quantity if missing
        };
      }
    },
    { immediate: true }
  );
  
  // Handle form submission
  const submit = () => {
    const updatedQuantity = product.value.quantity + newQuantity.value; // Add the new quantity to the current quantity
    emit('save', { id: props.product.id, ...product.value, quantity: updatedQuantity }); // Emit the updated product data
    close(); // Close the modal after submission
  };
  
  // Close modal
  const close = () => {
    emit('close'); // Emit a close event to the parent component
  };
  </script>
  