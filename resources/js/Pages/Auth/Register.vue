<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <!-- Step 1 -->
            <div v-if="step === 1">
                <div>
                    <InputLabel for="first_name" value="First Name" />
                    <TextInput
                        id="first_name"
                        type="text"
                        class="block w-full mt-1"
                        v-model="form.first_name"
                        required

                    />
                    <InputError class="mt-2" :message="form.errors.first_name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="last_name" value="Last Name" />
                    <TextInput
                        id="last_name"
                        type="text"
                        class="block w-full mt-1"
                        v-model="form.last_name"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.last_name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        class="block w-full mt-1"
                        v-model="form.email"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
            </div>

            <!-- Step 2 -->
            <div v-if="step === 2">
                <div>
                    <InputLabel for="gender" value="Gender" />
                    <select
                        id="gender"
                        v-model="form.gender"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required
                    >
                        <option value="" disabled>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.gender" />
                </div>

                <div class="flex items-center mt-4">
    <InputLabel for="phone" value="Phone" class="w-full" />

    <div class="flex w-full mt-1">
        <!-- Static Prefix -->
        <span class="p-2 bg-gray-200 border border-r-0 rounded-l">+63</span>

        <!-- Phone Input -->
        <TextInput
            id="phone"
            type="text"
            class="block w-full border-l-0 rounded-r"
            v-model="form.phone"
            @input="formatPhone"
            placeholder="Enter your 10-digit number"
            required
        />
    </div>
    <InputError class="mt-2" :message="form.errors.phone" />
</div>

                <div class="mt-4">
                    <InputLabel for="date_of_birth" value="Date of Birth" />
                    <TextInput
                        id="date_of_birth"
                        type="date"
                        class="block w-full mt-1"
                        v-model="form.date_of_birth"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.date_of_birth" />
                </div>
            </div>

            <!-- Step 3 -->
            <div v-if="step === 3">
                <div>
                    <InputLabel for="address" value="Address" />
                    <TextInput
                        id="address"
                        type="text"
                        class="block w-full mt-1"
                        v-model="form.address"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.address" />
                </div>

                <div class="mt-4">
                    <InputLabel for="occupation" value="Occupation" />
                    <TextInput
                        id="occupation"
                        type="text"
                        class="block w-full mt-1"
                        v-model="form.occupation"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.occupation" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />
                    <TextInput
                        id="password"
                        type="password"
                        class="block w-full mt-1"
                        v-model="form.password"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="block w-full mt-1"
                        v-model="form.password_confirmation"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex items-center justify-between mt-4">
                <SecondaryButton
                    v-if="step > 1"
                    @click.prevent="previousStep"
                >
                    Previous
                </SecondaryButton>

                <PrimaryButton
                    v-if="step < 3"
                    @click.prevent="nextStep"
                >
                    Next
                </PrimaryButton>

                <PrimaryButton
                    v-if="step === 3"
                    :disabled="form.processing"
                    :class="{ 'opacity-25': form.processing }"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    first_name: '',
    last_name: '',
    gender: '',
    email: '',
    phone: '',
    date_of_birth: '',
    address: '',
    occupation: '',
    password: '',
    password_confirmation: '',
});

const step = ref(1); // Current step of the form

const validateStep = () => {
    form.errors = {}; // Reset local errors

    // Validation rules for each step
    if (step.value === 1) {
        if (!form.first_name) form.errors.first_name = 'First name is required.';
        if (!form.last_name) form.errors.last_name = 'Last name is required.';
        if (!form.email || !/^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/.test(form.email)) {
            form.errors.email = 'Valid email is required.';
        }
    } else if (step.value === 2) {
        if (!form.gender) form.errors.gender = 'Gender is required.';
        if (!form.phone || form.phone.length !== 10) {
            form.errors.phone = 'Phone number must be exactly 10 digits.';
        }

        if (!form.date_of_birth) form.errors.date_of_birth = 'Date of birth is required.';
    } else if (step.value === 3) {
        if (!form.address) form.errors.address = 'Address is required.';
        if (!form.occupation) form.errors.occupation = 'Occupation is required.';
        if (!form.password || form.password.length < 8) {
            form.errors.password = 'Password must be at least 8 characters.';
        }
        if (form.password !== form.password_confirmation) {
            form.errors.password_confirmation = 'Passwords do not match.';
        }
    }

    // Return true if no errors
    return Object.keys(form.errors).length === 0;
};


const nextStep = () => {
    if (validateStep()) {
        step.value++;
    }
};
const formatPhone = () => {
    // Remove all non-numeric characters
    form.phone = form.phone.replace(/[^\d]/g, '');

    // Limit the phone number to 10 digits
    if (form.phone.length > 10) {
        form.phone = form.phone.slice(0, 10);
    }
};


const previousStep = () => {
    if (step.value > 1) step.value--;
};

const submit = () => {
    if (validateStep()) {
        form.post(route('register'), {
            onSuccess: () => {
                window.location.href = route('login');
            },
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    }
};
</script>
