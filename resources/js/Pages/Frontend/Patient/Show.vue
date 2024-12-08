<template>
  <div v-if="isOpen" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full relative">
      
      <!-- Header Section -->
      <div class="bg-red-600 text-white p-4 rounded-t-lg">
        <h2 class="text-xl font-semibold">Patient Details</h2>
      </div>

      <!-- Close Button -->
      <button @click="close" class="absolute top-2 right-2 text-white hover:text-gray-800 transition duration-200 text-2xl p-2">
        &times;
      </button>

      <!-- Content Section -->
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Patient Details Section -->
        <div>
          <div v-if="patients">
            <div class="mb-2">
              <p><strong>Name:</strong> <span class="text-gray-700">{{ patients.first_name }} {{ patients.last_name }}</span></p>
            </div>
            <div class="mb-2">
              <p><strong>Gender:</strong> <span class="text-gray-700">{{ patients.gender }}</span></p>
            </div>
            <div class="mb-2">
              <p><strong>Email:</strong> <span class="text-gray-700">{{ patients.email }}</span></p>
            </div>
            <div class="mb-2">
              <p><strong>Occupation:</strong> <span class="text-gray-700">{{ patients.occupation }}</span></p>
            </div>
            <div class="mb-2">
              <p><strong>Address:</strong> <span class="text-gray-700">{{ patients.address }}</span></p>
            </div>
            <div class="mb-2">
              <p><strong>Date of Birth:</strong> <span class="text-gray-700">{{ patients.date_of_birth }}</span></p>
            </div>
          </div>
        </div>

        <!-- Prescription Details Section -->
        <div>
          <div v-if="patients">
            <div class="mb-2">
              <p><strong>RX:</strong> <span class="text-gray-700">{{ patients.rx || 'Not recorded' }}</span></p>
            </div>
            <div class="mb-2">
              <p><strong>OD (Right Eye):</strong> <span class="text-gray-700">{{ patients.od || 'Not recorded' }}</span></p>
            </div>
            <div class="mb-2">
              <p><strong>OS (Left Eye):</strong> <span class="text-gray-700">{{ patients.os || 'Not recorded' }}</span></p>
            </div>
            <div class="mb-2">
              <p><strong>Add (Addition):</strong> <span class="text-gray-700">{{ patients.add || 'Not recorded' }}</span></p>
            </div>
            <div class="mb-2">
              <p><strong>PD (Pupillary Distance):</strong> <span class="text-gray-700">{{ patients.pd || 'Not recorded' }}</span></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Close Button Positioned to the Right Below the Content -->
      <div class="flex justify-end pr-6 mb-6">
        <button
          @click="close"
          class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition"
        >
          Close
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps(['isOpen', 'patients']);
const emit = defineEmits();

const close = () => {
  emit('close');
};
</script>
