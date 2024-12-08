<template>
    <div>
      <div class="flex space-x-4 mb-4">
        <input type="date" v-model="startDate" class="border px-4 py-2 rounded" />
        <span class="text-xl">to</span>
        <input type="date" v-model="endDate" class="border px-4 py-2 rounded" />
        <button @click="fetchReport" class="bg-blue-500 text-white px-4 py-2 rounded">
          Filter
        </button>
      </div>
  
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
          <thead>
            <tr>
              <th class="px-4 py-2 border-b">Date</th>
              <th class="px-4 py-2 border-b">Customer Name</th>
              <th class="px-4 py-2 border-b">Total</th>
              <th class="px-4 py-2 border-b">Discount</th>
              <th class="px-4 py-2 border-b">Cart Items</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="transaction in transactions" :key="transaction.id">
              <td class="px-4 py-2 border-b">{{ transaction.created_at }}</td>
              <td class="px-4 py-2 border-b">{{ transaction.customer_name }}</td>
              <td class="px-4 py-2 border-b">{{ transaction.total }}</td>
              <td class="px-4 py-2 border-b">{{ transaction.discount_amount }}</td>
              <td class="px-4 py-2 border-b">
                <ul>
                  <li v-for="item in transaction.cart_items" :key="item.product_id">
                    {{ item.product_name }} (x{{ item.quantity }})
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  
  const startDate = ref('');
  const endDate = ref('');
  const transactions = ref([]);
  
  const fetchReport = () => {
    if (startDate.value && endDate.value) {
      Inertia.get('/transactions/report', {
        start_date: startDate.value,
        end_date: endDate.value,
      }, {
        preserveState: true,
        onSuccess: (page) => {
          transactions.value = page.props.transactions;
        },
      });
    }
  };
  </script>
  