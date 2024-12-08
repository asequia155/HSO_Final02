<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
    />
</template>

<style scoped>
input {
    background-color: #EEEE; /* Light gray background */
    color: #4c51bf; /* Indigo color for the checked state */
    border-radius: 4px; /* Rounded corners */
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* Small shadow */
    outline: none; /* Remove default outline */
    accent-color: red; /* Red checkmark color */
}
</style>