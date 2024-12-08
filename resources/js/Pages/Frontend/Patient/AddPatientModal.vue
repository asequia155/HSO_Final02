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
      <h2 class="text-xl font-semibold mb-4">Add Patient</h2>
      <form @submit.prevent="submit">
        <!-- Form grid for a horizontal layout with responsive columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <!-- First Name -->
          <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
            <input
              v-model="first_name"
              id="first_name"
              type="text"
              class="border w-full p-2 rounded"
              required
              placeholder="Enter first name"
            />
          </div>

          <!-- Last Name -->
          <div>
            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
            <input
              v-model="last_name"
              id="last_name"
              type="text"
              class="border w-full p-2 rounded"
              required
              placeholder="Enter last name"
            />
          </div>

          <!-- Gender -->
          <div>
            <label for="gender" class="block mb-2 text-sm font-medium text-gray-900">Gender</label>
            <select v-model="gender" id="gender" class="border w-full p-2 rounded" required>
              <option value="" disabled>Select gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
            <input
              v-model="email"
              id="email"
              type="email"
              class="border w-full p-2 rounded"
              required
              placeholder="Enter email"
            />
          </div>

          <!-- Phone -->
          <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone</label>
            <input
              v-model="phone"
              id="phone"
              type="tel"
              class="border w-full p-2 rounded"
              required
              placeholder="Enter phone number"
              autocomplete="tel"
            />
          </div>

          <!-- Date of Birth -->
          <div>
            <label for="date_of_birth" class="block mb-2 text-sm font-medium text-gray-900">Date of Birth</label>
            <input
              v-model="date_of_birth"
              id="date_of_birth"
              type="date"
              class="border w-full p-2 rounded"
              required
            />
          </div>

          <!-- Address -->
          <div class="md:col-span-2 lg:col-span-1">
            <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
            <input
              v-model="address"
              id="address"
              class="border w-full p-2 rounded"
              required
              placeholder="Enter address"
            />
          </div>

          <!-- Occupation -->
          <div>
            <label for="occupation" class="block mb-2 text-sm font-medium text-gray-900">Occupation</label>
            <input
              v-model="occupation"
              id="occupation"
              class="border w-full p-2 rounded"
              required
              placeholder="Enter occupation"
            />
          </div>
        </div>

        <!-- Separator Line -->
        <hr class="my-6 border-gray-300" />

        <!-- Eye Prescription Fields Section -->
        <h3 class="text-lg font-semibold mb-4">Eye Prescription Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <!-- RX (Prescription) -->
          <div>
            <label for="rx" class="block mb-2 text-sm font-medium text-gray-900">RX (Prescription)</label>
            <input
              v-model="rx"
              id="rx"
              type="text"
              class="border w-full p-2 rounded"
              placeholder="Enter prescription"
            />
          </div>

          <!-- OD (Right Eye) -->
          <div>
            <label for="od" class="block mb-2 text-sm font-medium text-gray-900">OD (Right Eye)</label>
            <input
              v-model="od"
              id="od"
              type="text"
              class="border w-full p-2 rounded"
              placeholder="Enter right eye value"
            />
          </div>

          <!-- OS (Left Eye) -->
          <div>
            <label for="os" class="block mb-2 text-sm font-medium text-gray-900">OS (Left Eye)</label>
            <input
              v-model="os"
              id="os"
              type="text"
              class="border w-full p-2 rounded"
              placeholder="Enter left eye value"
            />
          </div>

          <!-- Add (Addition) -->
          <div>
            <label for="add" class="block mb-2 text-sm font-medium text-gray-900">Add (Addition)</label>
            <input
              v-model="add"
              id="add"
              type="text"
              class="border w-full p-2 rounded"
              placeholder="Enter addition value"
            />
          </div>

          <!-- PD (Pupillary Distance) -->
          <div>
            <label for="pd" class="block mb-2 text-sm font-medium text-gray-900">PD (Pupillary Distance)</label>
            <input
              v-model="pd"
              id="pd"
              type="text"
              class="border w-full p-2 rounded"
              placeholder="Enter pupillary distance"
            />
          </div>
        </div>

        <!-- Action Buttons -->
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
            <span>Add Patient</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps(['isOpen']);
const emit = defineEmits();

const first_name = ref('');
const last_name = ref('');
const gender = ref('');
const email = ref('');
const phone = ref('');
const date_of_birth = ref('');
const address = ref('');
const occupation = ref('');
const rx = ref('');
const od = ref('');
const os = ref('');
const add = ref('');
const pd = ref('');

const submit = () => {
  const data = {
    first_name: first_name.value,
    last_name: last_name.value,
    gender: gender.value,
    email: email.value,
    phone: phone.value,
    date_of_birth: date_of_birth.value,
    address: address.value,
    occupation: occupation.value,
    rx: rx.value,
    od: od.value,
    os: os.value,
    add: add.value,
    pd: pd.value,
  };
  emit('add', data);
  emit('close');
};

const close = () => {
  emit('close');
};
</script>
