<template>
  <!-- Main Modal -->
  <div v-if="isOpen" id="crud-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 overflow-y-auto overflow-x-hidden w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <!-- Modal Content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update Product</h3>
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
              <input v-model="product.name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required />
            </div>

            <!-- Product Price -->
            <div class="col-span-2 sm:col-span-1">
              <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
              <input v-model.number="product.price" id="price" type="number" step="0.01" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="₱ 000.00" required />
            </div>

            <!-- Product Category -->
            <div class="col-span-2 sm:col-span-1">
              <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Category</label>
              <select v-model="product.category_id" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                <option value="" disabled>Select a category</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                  {{ category.name }}
                </option>
              </select>
            </div>

            <!-- Product Description -->
            <div class="col-span-2">
              <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Description</label>
              <textarea v-model="product.description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Write product description here"></textarea>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex justify-between mt-4">
            <button @click.prevent="close" type="button" class="bg-gray-300 text-black px-4 py-2 rounded-lg hover:bg-gray-400 transition dark:bg-gray-500 dark:text-white dark:hover:bg-gray-600">
              Cancel
            </button>
            <button :disabled="!product.name || !product.price" type="submit" class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition duration-300">
              Update Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps(['isOpen', 'product', 'categories']);
const emit = defineEmits();

const product = ref({
  name: '',
  price: null,
  description: '',
  category_id: 'others',
  quantity: 0
});

watch(
  () => props.product,
  (newValue) => {
    if (newValue) {
      product.value = {
        name: newValue.name || '',
        price: newValue.price || null,
        description: newValue.description || '',
        category_id: newValue.category_id || 'others',
        quantity: newValue.quantity || 0
      };
    }
  },
  { immediate: true }
);

const submit = () => {
  product.value.name = product.value.name.trim();
  product.value.description = product.value.description.trim();

  console.log('Submitting Updated Product:', product.value);
  emit('save', { id: props.product.id, ...product.value });
  close();
};

const close = () => {
  product.value = {
    name: '',
    price: null,
    description: '',
    category_id: 'others',
    quantity: 0
  };
  emit('close');
};
</script>

<style scoped>
/* Optional: Additional styles can be added here */
</style>
