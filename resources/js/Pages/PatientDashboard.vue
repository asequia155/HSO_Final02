<template>
    <DashboardLayout>
      <!-- Dashboard Header -->
      <DashboardHeader :notifications="notifications" />

      <!-- Dashboard Card Component -->
      <DashboardCard

        userRole="patient"
      />

      <!-- Wrapper for Sales Chart and Today's Reservation -->
      <div class="flex justify-between">
        <!-- Sales Chart Component -->
        <div class="w-1/2 ">
        </div>

        <!-- Today's Reservation Component -->
        <div class="w-1/2 ">

        </div>
      </div>

    <!-- Modal -->
    <div
      v-if="showErrorModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="w-full max-w-md p-4 bg-white rounded-lg shadow-lg">
        <div class="flex items-center justify-between pb-3 border-b">
          <h2 class="text-lg font-semibold text-gray-700">Error</h2>
          <button @click="closeErrorModal" class="text-gray-500 hover:text-gray-700">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-5 h-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
        <div class="mt-4 text-gray-600">
          <p>{{ errorMessage }}</p>
        </div>
        <div class="mt-6 text-right">
          <button
            @click="closeErrorModal"
            class="px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600"
          >
            Close
          </button>
        </div>
      </div>
    </div>



    </DashboardLayout>
  </template>

  <script setup>
  import DashboardLayout from "@/Layouts/DashboardLayout.vue";
  import DashboardHeader from "@/Components/DashboardHeader.vue";
  import { ref, watch } from "vue";

  const props = defineProps({

    notifications: {
      type: Array,
      required: true,
    },
    errors: {
    type: Object,
    required: false,
    default: () => ({}),
  },
  });

  // Error modal logic
const errorMessage = ref(props.errors.error || ""); // Extract error message
const showErrorModal = ref(!!errorMessage.value); // Show modal if error exists

const closeErrorModal = () => {
  showErrorModal.value = false; // Close modal
};
  // Debugging
  console.log("Received notifications:", props.notifications);

  </script>

  <style scoped>
  </style>
