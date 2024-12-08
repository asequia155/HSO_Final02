<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <span class="login100-form-title">Login</span>
            <div class="w-full h-[2px] bg-gray-500"></div>
            <div>
                <div
			  class="wrap-input100 validate-input"
			  :data-validate="'Valid email is required: ex@abc.xyz'"
			>
                <TextInput
                    id="email"
                    type="email"
                    class="input100 input100-email block w-full mt-1"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Email"
                />
                <span class="focus-input100"></span>
			  <span class="symbol-input100">
				<i class="fa fa-envelope" aria-hidden="true"></i>
			  </span>
			</div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-12">
                <div
			  class="wrap-input100 validate-input" style="margin-top: 20px;"
			  :data-validate="'Password is required'"
			>

                <TextInput
                    id="password"
                    type="password"
                    class="input100 block w-full mt-1"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                />
                <span class="focus-input100"></span>
			  <span class="symbol-input100">
				<i class="fa fa-lock" aria-hidden="true"></i>
			  </span>
			</div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="text-sm text-gray-600" style="margin-left: 6px;">
						Remember me
					</span>
                </label>
            </div>

            <div class="container-login100-form-btn flex items-center justify-center" style="margin-top: 12px;">
                <PrimaryButton
    class="login100-form-btn"
    :class="{ 'opacity-25': form.processing }"
    :disabled="form.processing"
>
    Log in
</PrimaryButton>
            </div>
            <div class="flex justify-center mt-2">
    <Link
        v-if="canResetPassword"
        :href="route('password.request')"
        class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
    >
        Forgot your password?
    </Link>
</div>

        </form>
    </GuestLayout>
</template>
<style scoped>
/* Include the CSS from your Blade template here */
@import '../../../../public/css/util.css';
@import '../../../../public/css/main.css';
</style>
