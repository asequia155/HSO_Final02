<template>
  <div v-if="isOpen" id="crud-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 overflow-y-auto overflow-x-hidden w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <!-- Modal Content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Record</h3>
          <button @click.prevent="close" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal Body -->
        <form @submit.prevent="submit" class="p-4 md:p-5">
          <div class="grid gap-4 mb-4 grid-cols-1 sm:grid-cols-2">
            <!-- OD -->
            <div class="col-span-2 sm:col-span-1">
              <label for="od" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">OD (Right Eye)</label>
              <input v-model="od" id="od" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter right eye value" />
              <p v-if="errors.od" class="text-red-500 text-sm mt-1">{{ errors.od }}</p>
            </div>
            <!-- OS -->
            <div class="col-span-2 sm:col-span-1">
              <label for="os" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">OS (Left Eye)</label>
              <input v-model="os" id="os" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter left eye value" />
              <p v-if="errors.os" class="text-red-500 text-sm mt-1">{{ errors.os }}</p>
            </div>
            <!-- Add -->
            <div class="col-span-2 sm:col-span-1">
              <label for="add" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Add (Addition)</label>
              <input v-model="add" id="add" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter addition value" />
              <p v-if="errors.add" class="text-red-500 text-sm mt-1">{{ errors.add }}</p>
            </div>
            <!-- PD -->
            <div class="col-span-2 sm:col-span-1">
              <label for="pd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PD (Pupillary Distance)</label>
              <input v-model="pd" id="pd" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter pupillary distance" />
              <p v-if="errors.pd" class="text-red-500 text-sm mt-1">{{ errors.pd }}</p>
            </div>
            <!-- Remarks -->
            <div class="col-span-2">
              <label for="remarks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remarks</label>
              <textarea v-model="remarks" id="remarks" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter remarks"></textarea>
            </div>
          </div>
          <!-- Action Buttons -->
          <div class="flex justify-between mt-4">
            <button @click.prevent="close" type="button" class="bg-gray-300 text-black px-4 py-2 rounded-lg hover:bg-gray-400 transition dark:bg-gray-500 dark:text-white dark:hover:bg-gray-600">
              Cancel
            </button>
            <button type="submit" class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition duration-300">
              Add Record
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

  
  <script setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps(['isOpen', 'patientId']);
const emit = defineEmits(['close', 'add']);

const remarks = ref('');
const od = ref('');
const os = ref('');
const add = ref('');
const pd = ref('');
const errors = ref({
  od: '',
  os: '',
  add: '',
  pd: '',
});

const resetFields = () => {
  od.value = '';
  os.value = '';
  add.value = '';
  pd.value = '';
  remarks.value = '';
  errors.value = {
    od: '',
    os: '',
    add: '',
    pd: '',
  };
};

const validate = () => {
  let isValid = true;
  errors.value = {}; // Reset errors

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
    const data = { od: od.value, os: os.value, add: add.value, pd: pd.value, remarks: remarks.value, };
    emit('add', data);
    close();
  }
};

const close = () => {
  resetFields();
  emit('close');
};
</script>
