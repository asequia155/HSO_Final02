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
          <!-- Separator Line -->
          <hr class="my-6 border-gray-300" />
        <form @submit.prevent="submit">
          <h3 class="text-lg font-semibold mb-4">Eye Prescription Details</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
          <div class="flex items-center justify-between space-x-4 mt-6">
            <button
              type="button"
              @click="close"
              class="bg-gray-300 text-black text-sm px-5 py-2.5 rounded hover:bg-gray-400 transition focus:ring-4 focus:outline-none focus:ring-gray-300"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="text-white bg-red-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center space-x-2"
            >
              <span>Update</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineProps, defineEmits, watch } from 'vue';
  
  const props = defineProps(['isOpen', 'patientData']);
  const emit = defineEmits(['edit', 'close']);
  
  const rx = ref('');
  const od = ref('');
  const os = ref('');
  const add = ref('');
  const pd = ref('');
  
  watch(
    () => props.patientData,
    (newData) => {
      if (newData) {
        rx.value = newData.rx || '';
        od.value = newData.od || '';
        os.value = newData.os || '';
        add.value = newData.add || '';
        pd.value = newData.pd || '';
      }
    },
    { immediate: true }
  );
  const submit = () => {
  const data = {
    id: props.patientData.id, // Add the prescription ID
    rx: rx.value,
    od: od.value,
    os: os.value,
    add: add.value,
    pd: pd.value,
  };
  emit('edit', data);
  emit('close');
};

  
  const close = () => {
    emit('close');
  };
  </script>
  