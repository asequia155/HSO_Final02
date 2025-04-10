<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <!-- Title -->
            <h3 v-if="title" class="mb-4 text-xl font-semibold text-center text-gray-800">
                {{ title }}
            </h3>

            <!-- Message -->
            <p v-if="message" class="mb-6 text-center text-gray-600">
                {{ message }}
            </p>

            <!-- View-Only Content -->
            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6">
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">First Name:</label>
                        <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.firstName }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Last Name:</label>
                        <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.lastName }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Phone Number:</label>
                        <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.phone }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Email:</label>
                        <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.email }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Gender:</label>
                        <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.gender }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Age:</label>
                        <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.date_of_birth }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Address:</label>
                        <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.address }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Occupation:</label>
                        <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.occupation }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Selected Date:</label>
                        <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.appointmentDate }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Selected Time:</label>
                        <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.appointmentTime }}</p>
                    </div>
                </div>
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Remarks:</label>
                    <p class="p-2 bg-gray-100 border border-gray-300 rounded">{{ data.remarks }}</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end mt-6 space-x-3">
                <button
                    @click="close"
                    class="px-4 py-2 text-gray-800 transition bg-gray-300 rounded hover:bg-gray-400"
                >
                    Cancel
                </button>
                <button
                    @click="confirm"
                    class="px-4 py-2 text-white transition bg-blue-500 rounded hover:bg-blue-600"
                >
                    OK
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    show: { type: Boolean, required: true }, // Whether the modal is visible
    title: { type: String, default: '' },    // Modal title
    message: { type: String, default: '' }, // Modal message
    data: {
        type: Object,
        default: () => ({}),
    }, // Data to display in the modal
});

const emit = defineEmits(['update:show', 'confirm']);

const close = () => {
    emit('update:show', false);
};

const confirm = () => {
    emit('confirm');
    emit('update:show', false);
};
</script>

<style scoped>
/* Additional styling */
</style>
