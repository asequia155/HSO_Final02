<template>
  <div v-if="isOpen" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center" style="z-index: 1000;">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-3xl relative">
      <button
        @click="close"
        class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 transition duration-200 text-2xl p-2"
        aria-label="Close"
      >
        &times;
      </button>
      <h2 class="text-xl font-semibold mb-4">Edit Patient</h2>
      <hr class="my-6 border-gray-300" />
      <form @submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <!-- First Name -->
          <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
            <input
              v-model="first_name"
              id="first_name"
              type="text"
              class="border w-full p-2 rounded"
              placeholder="Enter first name"
            />
            <p v-if="errors.first_name" class="text-red-500 text-sm mt-1">{{ errors.first_name }}</p>
          </div>

          <!-- Last Name -->
          <div>
            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
            <input
              v-model="last_name"
              id="last_name"
              type="text"
              class="border w-full p-2 rounded"
              placeholder="Enter last name"
            />
            <p v-if="errors.last_name" class="text-red-500 text-sm mt-1">{{ errors.last_name }}</p>
          </div>

          <!-- Gender -->
          <div>
            <label for="gender" class="block mb-2 text-sm font-medium text-gray-900">Gender</label>
            <select v-model="gender" id="gender" class="border w-full p-2 rounded">
              <option value="" disabled>Select gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
            <p v-if="errors.gender" class="text-red-500 text-sm mt-1">{{ errors.gender }}</p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
            <input
              v-model="email"
              id="email"
              type="email"
              class="border w-full p-2 rounded"
              placeholder="Enter email"
            />
            <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
          </div>

          <!-- Phone -->
          <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone</label>
            <input
              v-model="phone"
              id="phone"
              type="tel"
              class="border w-full p-2 rounded"
              placeholder="Enter phone number"
            />
            <p v-if="errors.phone" class="text-red-500 text-sm mt-1">{{ errors.phone }}</p>
          </div>

          <!-- Date of Birth -->
          <div>
            <label for="date_of_birth" class="block mb-2 text-sm font-medium text-gray-900">Date of Birth</label>
            <input
              v-model="date_of_birth"
              id="date_of_birth"
              type="date"
              class="border w-full p-2 rounded"
            />
            <p v-if="errors.date_of_birth" class="text-red-500 text-sm mt-1">{{ errors.date_of_birth }}</p>
          </div>

          <!-- Address -->
          <div class="md:col-span-2 lg:col-span-1">
            <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
            <input
              v-model="address"
              id="address"
              class="border w-full p-2 rounded"
              placeholder="Enter address"
            />
            <p v-if="errors.address" class="text-red-500 text-sm mt-1">{{ errors.address }}</p>
          </div>

          <!-- Occupation -->
          <div>
            <label for="occupation" class="block mb-2 text-sm font-medium text-gray-900">Occupation</label>
            <input
              v-model="occupation"
              id="occupation"
              class="border w-full p-2 rounded"
              placeholder="Enter occupation"
            />
            <p v-if="errors.occupation" class="text-red-500 text-sm mt-1">{{ errors.occupation }}</p>
          </div>
        </div>

        <div class="flex items-center justify-between space-x-4 mt-6">
          <button
            type="button"
            @click="close"
            class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="text-white bg-red-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center space-x-2"
          >
            <span>Update</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps(['isOpen', 'patientData']);
const emit = defineEmits(['close', 'edit']);

// Form fields
const first_name = ref('');
const last_name = ref('');
const gender = ref('');
const email = ref('');
const phone = ref('');
const date_of_birth = ref('');
const address = ref('');
const occupation = ref('');

// Error messages
const errors = ref({
  first_name: '',
  last_name: '',
  gender: '',
  email: '',
  phone: '',
  date_of_birth: '',
  address: '',
  occupation: '',
});

// Watch for changes in patientData to prefill form
watch(
  () => props.patientData,
  (newData) => {
    if (newData) {
      first_name.value = newData.first_name || '';
      last_name.value = newData.last_name || '';
      gender.value = newData.gender || '';
      email.value = newData.email || '';
      phone.value = newData.phone || '';
      date_of_birth.value = newData.date_of_birth || '';
      address.value = newData.address || '';
      occupation.value = newData.occupation || '';
    }
  },
  { immediate: true }
);

// Validation function
const validate = () => {
  let isValid = true;
  errors.value = {}; // Reset errors

  if (!first_name.value) {
    errors.value.first_name = 'First name is required.';
    isValid = false;
  }
  if (!last_name.value) {
    errors.value.last_name = 'Last name is required.';
    isValid = false;
  }
  if (!gender.value) {
    errors.value.gender = 'Gender is required.';
    isValid = false;
  }
  if (!email.value || !/\S+@\S+\.\S+/.test(email.value)) {
    errors.value.email = 'A valid email is required.';
    isValid = false;
  }
  if (!phone.value || phone.value.length !== 10) {
    errors.value.phone = 'Phone number must be 10 digits.';
    isValid = false;
  }
  if (!date_of_birth.value || isNaN(new Date(date_of_birth.value).getTime())) {
    errors.value.date_of_birth = 'A valid date is required.';
    isValid = false;
  }
  if (!address.value) {
    errors.value.address = 'Address is required.';
    isValid = false;
  }
  if (!occupation.value) {
    errors.value.occupation = 'Occupation is required.';
    isValid = false;
  }

  return isValid;
};

// Submit handler
const submit = () => {
  if (validate()) {
    const data = {
      ...props.patientData,
      first_name: first_name.value,
      last_name: last_name.value,
      gender: gender.value,
      email: email.value,
      phone: phone.value,
      date_of_birth: date_of_birth.value,
      address: address.value,
      occupation: occupation.value,
    };
    emit('edit', data);
    emit('close');
  }
};

// Close handler
const close = () => {
  emit('close');
};
</script>
