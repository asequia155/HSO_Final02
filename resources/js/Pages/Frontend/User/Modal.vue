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



            <!-- Buttons -->
            <div class="flex justify-between mt-6 space-x-3">
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
