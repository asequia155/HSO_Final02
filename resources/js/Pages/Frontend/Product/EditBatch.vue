<template>
    <div v-if="isOpen" tabindex="-1" aria-hidden="true" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-[50]">
      <div class="relative w-full max-w-md max-h-full p-4">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
          <!-- Modal header -->
          <div class="flex items-center justify-between pb-4 mb-4 border-b rounded-t sm:mb-5 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Stock</h3>
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
              <!-- Quantity Input -->
              <div class="flex items-center space-x-4">
                <label for="quantity" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white">Quantity: </label>
                <input v-model.number="newQuantity" id="quantity" type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-2/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required min="1" />
              </div>

              <!-- Batch Number -->
              <div class="flex items-center space-x-4">
                <label for="batch_number" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white">Batch No:</label>
                <input v-model="batchNumber" id="batch_number" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-2/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
              </div>

              <!-- Expiration Control -->
              <div class="flex items-center space-x-4">
                <label class="w-1/3 text-sm font-medium text-gray-900 dark:text-white">Expiration:</label>
                <div class="flex w-2/3 space-x-4">
                  <div>
                    <input v-model="hasExpiration" type="radio" id="has_expiration" value="true" class="mr-2" />
                    <label for="has_expiration" class="text-sm font-medium text-gray-900 dark:text-white">Yes</label>
                  </div>
                  <div>
                    <input v-model="hasExpiration" type="radio" id="no_expiration" value="false" class="mr-2" />
                    <label for="no_expiration" class="text-sm font-medium text-gray-900 dark:text-white">No</label>
                  </div>
                </div>
              </div>

              <!-- Production Date -->
              <div v-if="hasExpiration === 'true'" class="flex items-center space-x-4">
                <label for="production_date" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white">Production:</label>
                <input v-model="productionDate" id="production_date" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-2/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
              </div>

              <!-- Expiry Date -->
              <div v-if="hasExpiration === 'true'" class="flex items-center space-x-4">
                <label for="expiry_date" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white">Expiry:</label>
                <input v-model="expiryDate" id="expiry_date" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-2/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
              </div>
            </div>

            <!-- Buttons container -->
            <div class="flex justify-end space-x-4">
              <button @click="submit" class="text-white bg-red-600 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Save Changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, defineProps, defineEmits, watch } from 'vue';
  import { Inertia } from '@inertiajs/inertia';


  const props = defineProps(['isOpen', 'batch']);
  const emit = defineEmits();

  // Initialize batch details with default values
  const batchNumber = ref('');
  const newQuantity = ref(0);
  const productionDate = ref('');
  const expiryDate = ref('');
  const hasExpiration = ref('false');

  // Watch for changes in the batch prop and update local data
  watch(
    () => props.batch,
    (newValue) => {
      if (newValue) {
        batchNumber.value = newValue.batch_number || '';
        newQuantity.value = newValue.quantity || 0;
        productionDate.value = newValue.production_date || '';
        expiryDate.value = newValue.expiry_date || '';
        hasExpiration.value = newValue.expiry_date ? 'true' : 'false';
      }
    },
    { immediate: true }
  );

  // Handle form submission
  const submit = () => {
    emit('update', {
      ...props.batch,
      batch_number: batchNumber.value,
      quantity: newQuantity.value,
      production_date: productionDate.value,
      expiry_date: expiryDate.value,
    });

    close();
  };

  // Close modal
  const close = () => {
    emit('close');
  };
  </script>
