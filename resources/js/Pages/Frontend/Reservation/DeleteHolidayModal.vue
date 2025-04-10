<template>
    <!-- Modal Overlay -->
    <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Background Overlay -->
        <div class="absolute inset-0 bg-gray-900 opacity-50" @click="close"></div>

        <!-- Modal Content -->
        <div class="relative z-10 w-full max-w-md bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-4 py-3 bg-red-500 rounded-t-lg">
                <h3 class="text-lg font-bold text-white">{{ title }}</h3>
                <button @click="close" class="text-white hover:text-gray-200 focus:outline-none">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 text-center">
                <p class="text-gray-800 dark:text-gray-300">
                    Are you sure you want to delete <strong class="text-red-500">{{ holidayName }}</strong>?
                </p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    This action cannot be undone.
                </p>

                <!-- Action Buttons -->
                <div class="flex justify-center mt-6 space-x-4">
                    <button
                        @click="close"
                        class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 focus:outline-none"
                    >
                        Cancel
                    </button>
                    <button
                        @click="confirmDelete"
                        :disabled="isDeleting"
                        class="px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                    >
                        <span v-if="isDeleting" class="loader"></span>
                        <span v-else>Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    isOpen: Boolean,
    holidayId: Number, // The ID of the holiday to delete
    holidayName: String, // The name of the holiday to display
    title: { type: String, default: 'Delete Holiday' },
});

const emit = defineEmits(['close','confirm', 'refreshHolidays']);

const isDeleting = ref(false); // Loader state for the delete button

// Confirm deletion
// Confirm deletion
// Confirm deletion
const confirmDelete = () => {
    if (!props.holidayId) return;

    isDeleting.value = true;

    router.delete(route('reservations.destroyHoliday', props.holidayId), {
        onSuccess: () => {
            emit('refreshHolidays'); // Emit the event to refresh holidays in parent
            close(); // Close the modal after successful deletion
        },
        onError: (errors) => {
            console.error('Error deleting holiday:', errors);
            alert('Failed to delete the holiday. Please try again.');
        },
        onFinish: () => {
            isDeleting.value = false; // Reset the deleting state
        },
    });
};






// Close the modal
const close = () => {
    emit('close'); // Emit the close event to parent
};
</script>

<style scoped>
button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.loader {
    border: 2px solid #f3f3f3;
    border-top: 2px solid #ffffff;
    border-radius: 50%;
    width: 14px;
    height: 14px;
    animation: spin 1s linear infinite;
    display: inline-block;
    margin-right: 4px;
}
@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
