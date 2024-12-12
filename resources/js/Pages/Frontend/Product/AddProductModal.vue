<template>
  <!-- Main Modal -->
    <div v-if="isOpen" id="crud-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 overflow-y-auto overflow-x-hidden w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-md max-h-full">
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          
          <!-- Modal Header -->
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Product</h3>
            <button @click.prevent="close" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          
          <!-- Modal Body -->
          <form @submit.prevent="submit" class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-1 sm:grid-cols-2">
              
              <!-- Product Name -->
              <div class="col-span-2">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input v-model="product.name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" />
                <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
              </div>
              
              <!-- Product Price -->
              <div class="col-span-2 sm:col-span-1">
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                <input v-model.number="product.price" id="price" type="number" step="0.01" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="₱ 000.00" />
                <p v-if="errors.price" class="text-red-500 text-sm mt-1">{{ errors.price }}</p>
              </div>
  
              <!-- Product Category -->
              <div class="col-span-2 sm:col-span-1">
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Category</label>
                <select v-model="product.category_id" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                  <option value="" disabled>Select a category</option>
                  <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                  </option>
                </select>
                <p v-if="errors.category_id" class="text-red-500 text-sm mt-1">{{ errors.category_id }}</p>
              </div>
  
              <!-- Product Description -->
              <div class="col-span-2">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Description</label>
                <textarea v-model="product.description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write product description here"></textarea>
              </div>
            </div>
  
            <!-- Action Buttons -->
            <div class="flex justify-between mt-4">
              <button @click.prevent="close" type="button" class="bg-gray-300 text-black px-4 py-2 rounded-lg hover:bg-gray-400 transition dark:bg-gray-500 dark:text-white dark:hover:bg-gray-600">
                Cancel
              </button>
              <button type="submit" class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition duration-300">
                Add Product
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineProps, defineEmits } from 'vue';
  
  const props = defineProps({
    categories: {
      type: Array,
      required: true,
    },
    isOpen: {
      type: Boolean,
      required: true,
    },
  });
  
  const emit = defineEmits(['add', 'close']);
  const product = ref({
    name: '',
    price: null, // Initialize with null to avoid initial invalid values
    category_id: null, // Store category ID here
    description: '',
  });
  
  const errors = ref({
    name: '',
    price: '',
    category_id: '',
  });
  
  const validate = () => {
    let isValid = true;
    errors.value = {}; // Reset errors
  
    if (!product.value.name) {
      errors.value.name = 'Product name is required.';
      isValid = false;
    }
    if (product.value.price === null || product.value.price <= 0) {
      errors.value.price = 'Price must be greater than 0.';
      isValid = false;
    }
    if (!product.value.category_id) {
      errors.value.category_id = 'Please select a category.';
      isValid = false;
    }
  
    return isValid;
  };
  
  const submit = () => {
    if (validate()) {
      emit('add', {
        name: product.value.name, // Product Name
        price: product.value.price, // Product Price
        category_id: product.value.category_id, // Selected Category ID
        description: product.value.description, // Product Description
      });
      resetForm();
      emit('close');
    }
  };
  
  const resetForm = () => {
    product.value = { name: '', price: null, category_id: null, description: '' }; // Reset all fields
    errors.value = {}; // Reset errors
  };
  
  const close = () => {
    resetForm();
    emit('close');
  };
  </script>
  