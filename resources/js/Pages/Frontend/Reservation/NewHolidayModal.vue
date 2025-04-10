

<template>
    <!-- Modal Overlay -->
    <div v-if="isOpen" class="fixed top-0 left-0 z-50 flex items-center justify-center w-full h-full">
        <!-- Background overlay -->
        <div class="bg-gray-900 opacity-50" @click="close"></div>

        <!-- Modal Content -->
        <div class="relative w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-4 py-3 bg-red-500 rounded-t-lg">
                <h3 class="text-lg font-bold text-white">Add New Holiday</h3>
                <button @click="close" class="text-white hover:text-gray-200">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>

            <!-- Success Message -->
            <div v-if="successMessage" class="p-4 mb-2 text-center bg-green-100 rounded-md">
                <p class="text-sm font-medium text-green-700">{{ successMessage }}</p>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form @submit.prevent="submitHoliday">
                    <!-- Holiday Name -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-200">Holiday Name</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full p-2 border rounded-md dark:bg-gray-700 dark:text-gray-300"
                            placeholder="Enter holiday name"
                            required
                        />
                    </div>

                    <!-- Date Picker -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-200">Date</label>
                        <input
                            v-model="form.date"
                            type="date"
                            class="w-full p-2 border rounded-md dark:bg-gray-700 dark:text-gray-300"
                            required
                        />
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-4">
                        <button
                            type="button"
                            @click="close"
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-700 focus:outline-none"
                        >
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits, ref } from 'vue';

// Props for controlling modal visibility
defineProps({
    isOpen: Boolean,
});

// Events
const emit = defineEmits();

// Form data
const form = useForm({
    name: '',
    date: '',
});

// Success message state
const successMessage = ref('');

// Submit logic for creating a holiday
const submitHoliday = () => {
    form.post(route('reservations.storeHoliday'), {
        onSuccess: () => {
            successMessage.value = "Holiday successfully added!";
            setTimeout(() => {
                successMessage.value = '';
                form.reset();
                emit('add', { ...form }); // Emit 'add' event with the new holiday data
                emit('refreshHolidays', { ...form }); // Pass new holiday data to refresh the holidays list
                emit('close'); // Emit 'close' event to close the modal
            }, 2000);
        },
        onError: (errors) => {
            console.error('Error submitting holiday:', errors);
        },
    });
};



// Close modal event
const close = () => {
    emit('close');
    successMessage.value = ''; // Clear success message when modal closes
    form.reset(); // Reset form fields
};
</script>
