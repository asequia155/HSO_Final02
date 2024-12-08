<template>
    <DashboardLayout>
      <!-- Header -->
      <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center">
          <!-- Breadcrumbs and Title -->
          <div>
            <nav class="flex" aria-label="Breadcrumb">
              <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li>
                  <div class="flex items-center space-x-1">
                    <a href="/rawboard" class="inline-flex items-center group text-blue-600 hover:text-blue-700 text-sm font-medium">
                      <svg class="w-5 h-5 text-gray-500 mr-1 group-hover:text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                      </svg>
                    </a>
                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <a href="patients" class="inline-flex items-center hover:text-blue-700 text-gray-700 text-sm font-medium">Patients</a>
                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <a href="add-patient" class="inline-flex items-center text-blue-600 text-sm font-medium">Add Patient</a>
                  </div>
                </li>
              </ol>
            </nav>
            <h1 class="text-xl font-semibold text-gray-900 mt-2">Add Patient</h1>
          </div>
        </div>
      </div>
  
      <!-- Form -->
      <div class="p-6 w-full mx-auto bg-white rounded-lg shadow-md">
        <form @submit.prevent="submitForm" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] gap-4">
            <!-- Patient Fields Section -->
            <div class="space-y-4 col-span-1">
              <h2 class="text-lg font-semibold mb-4 border-b pb-2">Patient Details</h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-gray-700 font-medium" for="first_name">First Name</label>
                  <input type="text" v-model="form.first_name" id="first_name" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required />
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="last_name">Last Name</label>
                  <input type="text" v-model="form.last_name" id="last_name" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required />
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="gender">Gender</label>
                  <select v-model="form.gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="email">Email</label>
                  <input type="email" v-model="form.email" id="email" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required />
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="phone">Phone</label>
                  <input type="text" v-model="form.phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required />
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="occupation">Occupation</label>
                  <input type="text" v-model="form.occupation" id="occupation" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="date_of_birth">Date of Birth</label>
                  <input type="date" v-model="form.date_of_birth" id="date_of_birth" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required />
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="address">Address</label>
                  <input type="text" v-model="form.address" id="address" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                </div>
              </div>
            </div>
  
            <!-- Vertical Divider -->
            <div class="hidden md:block border border-gray-200 h-full my-auto"></div>

  
            <!-- Prescription Fields Section -->
            <div class="space-y-4 col-span-1">
              <h2 class="text-lg font-semibold mb-4 border-b pb-2">Prescription Details</h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-gray-700 font-medium" for="rx">RX</label>
                  <input type="text" v-model="form.prescription.rx" id="rx" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="od">OD (Right Eye)</label>
                  <input type="number" v-model="form.prescription.od" id="od" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="os">OS (Left Eye)</label>
                  <input type="number" v-model="form.prescription.os" id="os" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="add">Add (Addition)</label>
                  <input type="number" v-model="form.prescription.add" id="add" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                </div>
                <div>
                  <label class="block text-gray-700 font-medium" for="pd">PD (Pupillary Distance)</label>
                  <input type="number" v-model="form.prescription.pd" id="pd" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                </div>
              </div>
            </div>
          </div>
  
          <!-- Submit Button -->
          <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md shadow-md transition-all duration-300">
              Add Patient and Prescription
            </button>
          </div>
        </form>
      </div>
    </DashboardLayout>
  </template>
  
  
  
  <script setup>
  import DashboardLayout from '@/Layouts/DashboardLayout.vue';
  import { reactive, ref } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  
  // Define the form data as a reactive object
  const form = reactive({
    first_name: '',
    last_name: '',
    gender: '',
    email: '',
    phone: '',
    occupation: '',
    date_of_birth: '',
    address: '',
    prescription: {
      rx: '',
      od: null,
      os: null,
      add: null,
      pd: null,
    },
  });
  
  // Step control
  const step = ref(1);
  
  const nextStep = () => {
    step.value++;
  };
  
  const prevStep = () => {
    step.value--;
  };
  
  // Function to submit the form data to the backend
  const submitForm = () => {
    Inertia.post('/patients/store', form);
  };
  </script>
  
  <style scoped>
  /* Optional custom styles */
  </style>
  
  