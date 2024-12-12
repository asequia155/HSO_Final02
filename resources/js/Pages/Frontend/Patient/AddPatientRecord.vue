<template>
    <div v-if="isOpen" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center" style="z-index: 1000;">
      <div class="bg-white p-6 rounded shadow-md w-full max-w-3xl relative">
        <button @click="close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 transition duration-200 text-2xl p-2" aria-label="Close">&times;</button>
        <h2 class="text-xl font-semibold mb-4">Add Record</h2>
        <hr class="my-6 border-gray-300" />
        <form @submit.prevent="submit">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
  <label for="rx" class="block mb-2 text-sm font-medium text-gray-900">RX (Prescription)</label>
  <input v-model="rx" id="rx" type="text" class="border w-full p-2 rounded" placeholder="Enter prescription" />
  <p v-if="errors.rx" class="text-red-500 text-sm mt-1">{{ errors.rx }}</p>
</div>
<div>
  <label for="od" class="block mb-2 text-sm font-medium text-gray-900">OD (Right Eye)</label>
  <input v-model="od" id="od" type="text" class="border w-full p-2 rounded" placeholder="Enter right eye value" />
  <p v-if="errors.od" class="text-red-500 text-sm mt-1">{{ errors.od }}</p>
</div>
<div>
  <label for="os" class="block mb-2 text-sm font-medium text-gray-900">OS (Left Eye)</label>
  <input v-model="os" id="os" type="text" class="border w-full p-2 rounded" placeholder="Enter left eye value" />
  <p v-if="errors.os" class="text-red-500 text-sm mt-1">{{ errors.os }}</p>
</div>
<div>
  <label for="add" class="block mb-2 text-sm font-medium text-gray-900">Add (Addition)</label>
  <input v-model="add" id="add" type="text" class="border w-full p-2 rounded" placeholder="Enter addition value" />
  <p v-if="errors.add" class="text-red-500 text-sm mt-1">{{ errors.add }}</p>
</div>
<div>
  <label for="pd" class="block mb-2 text-sm font-medium text-gray-900">PD (Pupillary Distance)</label>
  <input v-model="pd" id="pd" type="text" class="border w-full p-2 rounded" placeholder="Enter pupillary distance" />
  <p v-if="errors.pd" class="text-red-500 text-sm mt-1">{{ errors.pd }}</p>
</div>

          </div>
          <div class="flex items-center justify-between space-x-4 mt-6">
            <button type="button" @click="close" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition">Cancel</button>
            <button type="submit" class="text-white bg-red-500 hover:bg-gray-600 rounded-lg text-sm px-5 py-2.5">Add Record</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps(['isOpen', 'patientId']);
const emit = defineEmits(['close', 'add']);

const rx = ref('');
const od = ref('');
const os = ref('');
const add = ref('');
const pd = ref('');
const errors = ref({
  rx: '',
  od: '',
  os: '',
  add: '',
  pd: '',
});

const resetFields = () => {
  rx.value = '';
  od.value = '';
  os.value = '';
  add.value = '';
  pd.value = '';
  errors.value = {
    rx: '',
    od: '',
    os: '',
    add: '',
    pd: '',
  };
};

const validate = () => {
  let isValid = true;
  errors.value = {}; // Reset errors

  if (!rx.value) {
    errors.value.rx = 'RX is required.';
    isValid = false;
  }
  if (!od.value) {
    errors.value.od = 'OD (Right Eye) is required.';
    isValid = false;
  }
  if (!os.value) {
    errors.value.os = 'OS (Left Eye) is required.';
    isValid = false;
  }
  if (!add.value) {
    errors.value.add = 'Addition value is required.';
    isValid = false;
  }
  if (!pd.value) {
    errors.value.pd = 'PD (Pupillary Distance) is required.';
    isValid = false;
  }

  return isValid;
};

const submit = () => {
  if (validate()) {
    const data = { rx: rx.value, od: od.value, os: os.value, add: add.value, pd: pd.value };
    emit('add', data);
    close();
  }
};

const close = () => {
  resetFields();
  emit('close');
};
</script>
