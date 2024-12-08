<template>
  <div v-if="isOpen && transaction" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
    <div class="modal-content bg-white p-6 rounded-lg max-w-3xl w-full shadow-lg relative">
      <button class="absolute top-2 right-2 text-gray-600 text-xl" @click="closeModal">
        <i class="fa fa-times"></i>
      </button>

      <!-- Invoice Header -->
      <div class="flex justify-between mb-6">
        <div>
          <h2 class="text-3xl font-bold text-gray-800">Invoice {{ invoiceNumber }}</h2>
          <p class="text-sm text-gray-500">Issued: {{ currentDate }}</p>
        </div>
        <div class="text-right">
          <h3 class="text-lg font-semibold text-gray-700">{{ companyName }}</h3>
          <p class="text-sm text-gray-500">Address: {{ companyAddress }}</p>
          <p class="text-sm text-gray-500">Phone: {{ companyPhone }}</p>
          <p class="text-sm text-gray-500">Email: {{ companyEmail }}</p>
        </div>
      </div>

      <!-- Customer Info -->
      <div class="border-t border-gray-200 pt-4 mb-6">
        <div v-if="transaction.customer_name">
          <h4 class="text-lg font-semibold text-gray-700">Bill To:</h4>
          <p class="text-sm text-gray-600">{{ transaction.customer_name }}</p>
        </div>
      </div>

      <!-- Invoice Table -->
      <table v-if="transaction.cart_items && transaction.cart_items.length > 0" class="min-w-full text-left text-sm text-gray-600 mb-6">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b font-semibold text-gray-700">Item</th>
            <th class="py-2 px-4 border-b font-semibold text-gray-700">Quantity</th>
            <th class="py-2 px-4 border-b font-semibold text-gray-700">Price</th>
            <th class="py-2 px-4 border-b font-semibold text-gray-700">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in transaction.cart_items" :key="index">
            <td class="py-2 px-4 border-b">{{ item.product_name }}</td>
            <td class="py-2 px-4 border-b text-center">{{ item.quantity }}</td>
            <td class="py-2 px-4 border-b text-center">₱ {{ (Number(item.price)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</td>
            <td class="py-2 px-4 border-b text-center">₱ {{ (Number(item.price) * Number(item.quantity)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</td>
          </tr>
        </tbody>
      </table>

      <!-- Invoice Total -->
      <div class="flex justify-end font-semibold text-gray-700">
        <div class="w-1/2 text-right">
          <p class="text-lg">Subtotal: ₱ {{ transaction.total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</p>
          <p class="text-lg">Discount: -₱ {{ transaction.discount_amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</p>
          <hr class="my-2 border-gray-300">
          <p class="text-xl">Total: ₱ {{ (transaction.total - transaction.discount_amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</p>
        </div>
      </div>

      <!-- Button Row -->
      <div class="mt-6 flex justify-between">
        <button @click="closeModal" class="bg-gray-300 text-gray-700 py-2 px-6 rounded-md hover:bg-gray-400">
          Cancel
        </button>
        <button @click="confirmInvoice" class="bg-red-600 text-white py-2 px-6 rounded-md hover:bg-gray-600">
          Confirm
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits, computed } from 'vue';

const props = defineProps({
  isOpen: Boolean,
  transaction: {
    type: Object,
    required: true
  }
});

const emit = defineEmits();

const invoiceNumber = '';
const currentDate = new Date().toLocaleDateString();
const companyName = 'Hollywood Sepctacles';
const companyAddress = 'Gen. Aguinaldo St., Iligan City';
const companyPhone = '+1 234 567 890';
const companyEmail = 'hollywoodspectaclesiligan@domain.com';

function closeModal() {
  emit('close');
}

function confirmInvoice() {
  emit('confirm', props.transaction);
  closeModal();
}
</script>
