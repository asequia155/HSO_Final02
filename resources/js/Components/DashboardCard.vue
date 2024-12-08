<template>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
      <div class="container max-w-6xl mx-auto">
        <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-4">

          <!-- Total Sales Section -->
          <div
             v-if="userRole === 'admin' || userRole === 'clerk'"
            class="flex items-center justify-between p-5 bg-white rounded-lg shadow-md"
          >
            <div>
              <div class="text-sm text-black">Total Sales</div>
              <div class="flex items-center pt-1">
                <div class="text-xl font-medium text-red-500">₱{{ formattedTotalSales }}</div>
              </div>
            </div>
            <div class="text-gray-300">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 51 51">
                <path stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M48.875 12.75L28.687 32.938 18.063 22.312 2.126 38.25"></path>
                <path stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M36.125 12.75h12.75V25.5"></path>
              </svg>
            </div>
          </div>

          <!-- Total Product Section -->
          <div
            v-if="userRole === 'admin' || userRole === 'clerk'"
            class="flex items-center justify-between p-5 bg-white rounded-lg shadow-md"
          >
            <div>
              <div class="text-sm text-black">Total Product</div>
              <div class="flex items-center pt-1">
                <div v-if="totalProducts !== undefined" class="text-xl font-medium text-red-500">{{ totalProducts }}</div>
                <p v-else>Loading...</p>
              </div>
            </div>
            <div class="text-gray-300">
              <svg class="w-8 h-8 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
          </div>

          <!-- Total Patients Section -->
          <div
            v-if="userRole === 'admin'"
            class="flex items-center justify-between p-5 bg-white rounded-lg shadow-md"
          >
            <div>
              <div class="text-sm text-black">Total Patients</div>
              <div class="flex items-center pt-1">
                <div v-if="totalPatients !== undefined" class="text-xl font-medium text-red-500">{{ totalPatients }}</div>
                <p v-else>Loading...</p>
              </div>
            </div>
            <div class="text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 47 46">
                <path stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M39.167 40.25v-3.833a7.585 7.585 0 00-2.295-5.422 7.92 7.92 0 00-5.539-2.245H15.667a7.92 7.92 0 00-5.54 2.245 7.585 7.585 0 00-2.294 5.422v3.833M23.5 21.083c4.326 0 7.833-3.432 7.833-7.666 0-4.235-3.507-7.667-7.833-7.667-4.326 0-7.833 3.432-7.833 7.667 0 4.234 3.507 7.666 7.833 7.666z"></path>
              </svg>
            </div>
          </div>

          <!-- MRR Section -->
          <div
            v-if="userRole === 'admin' || userRole === 'clerk'"
            class="flex items-center justify-between p-5 bg-white rounded-lg shadow-md"
          >
            <div>
              <div class="text-sm text-black">Today's Sales</div>
              <div class="flex items-center pt-1">
                <div class="text-xl font-medium text-red-500">₱{{ formattedTodayTotalSales }}</div>
              </div>
            </div>
            <div class="text-gray-300">
              <svg class="w-8 h-8" viewBox="0 0 47 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M23.5 38.3334V19.1667" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M35.25 38.3334V7.66675" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M11.75 38.3334V30.6667" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { defineProps, computed } from 'vue';

  const props = defineProps({
    totalPatients: {
      type: Number,
      default: 0,
    },
    totalProducts: {
      type: Number,
      default: 0,
    },
    totalSales: {
      type: [Number, String], // Allow both Number and String to prevent warnings
      default: 0,
    },
    todayTotalSales: {
      type: [Number, String], // Allow both Number and String to prevent warnings
      default: 0.00,
    },
    userRole: {
      type: String,
      required: true, // Role is required to determine visibility
    },
  });

  // Utility function for formatting numbers
  function formatNumber(value) {
    return new Intl.NumberFormat('en-US', {
      style: 'decimal',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    }).format(Number(value));
  }

  // Computed properties for formatted values
  const formattedTotalSales = computed(() => formatNumber(props.totalSales));
  const formattedTodayTotalSales = computed(() => formatNumber(props.todayTotalSales));
  </script>
