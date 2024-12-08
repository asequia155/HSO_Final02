<template>
	<div class="limiter">
	  <div class="container-login100">
		<div class="wrap-login100">
		  <div class="login100-pic js-tilt" data-tilt>
			<img :src="logoImage" alt="IMG" />
		  </div>
  
		  <form class="login100-form validate-form" @submit.prevent="submitLogin">
			<span class="login100-form-title">Welcome to login</span>
  
			<div
			  class="wrap-input100 validate-input"
			  :data-validate="'Valid email is required: ex@abc.xyz'"
			>
			  <input
				v-model="form.email"
				class="input100"
				type="email"
				placeholder="Email"
			  />
			  <span class="focus-input100"></span>
			  <span class="symbol-input100">
				<i class="fa fa-envelope" aria-hidden="true"></i>
			  </span>
			</div>
  
			<div
			  class="wrap-input100 validate-input"
			  :data-validate="'Password is required'"
			>
			  <input
				v-model="form.password"
				class="input100"
				type="password"
				placeholder="Password"
			  />
			  <span class="focus-input100"></span>
			  <span class="symbol-input100">
				<i class="fa fa-lock" aria-hidden="true"></i>
			  </span>
			</div>

			<div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox 
					style="
                border: 0.5px solid #496182;
                background-color: #EEEE; /* Dark gray background */
                color: #4c51bf; /* Indigo color for the checked state */
                border-radius: 4px; /* Rounded corners */
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* Small shadow */
                outline: none; /* Remove default outline */
            "
					 name="remember" v-model:checked="form.remember" />
                    <span class="text-sm text-gray-600" style="margin-left: 6px;">
						Remember me
					</span>
                </label>
            </div>
  
			<div class="container-login100-form-btn">
			  <button type="submit" class="login100-form-btn">Login</button>
			</div>
  
			<div class="text-center p-t-12">
			  <span class="txt1">Forgot</span>
			  <a class="txt2" href="#">Username / Password?</a>
			</div>
  
			<div class="text-center p-t-12">
			  <span class="txt1">New here?</span>
			  <a class="txt2" :href="registerUrl">Register</a>
			</div>
		  </form>
		</div>
	  </div>
	</div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import Checkbox from '@/Components/Checkbox.vue';
  import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
  
  const logoImage = '/images/logo.png';
  const registerUrl = '/register';
  
  // Use Inertia's useForm for form state and submission
  const form = useForm({
	email: '',
	password: '',
	remember: false,
  });
  
  function submitLogin() {
	form.post(route('login'), {
	  onFinish: () => form.reset('password'), // Clear password after submission
	});
  }
  </script>
  
  <style scoped>
  /* Include the CSS from your Blade template here */
  @import '../../../public/css/util.css';
  @import '../../../public/css/main.css';
  </style>
  