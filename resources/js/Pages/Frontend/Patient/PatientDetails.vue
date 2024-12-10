<template>
	<DashboardLayout>
		<!-- Alert -->
		<transition name="alert-fade">
			<div v-if="message && messageType === 'success'" class="flex items-center px-4 py-3 mb-4 bg-green-100 border-t-4 border-green-700 shadow-md">
				<div class="flex items-center">
					<!-- Checkmark Icon -->
					<svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
					</svg>
					<!-- Alert Text -->
					<span class="ml-2 font-medium text-green-700">{{ message }}</span>
				</div>
			</div>
		</transition>

		<!-- Header Section -->
		<div class="p-4 mb-6 bg-white rounded-lg shadow-md">
			<div class="flex items-center justify-between">
				<!-- Breadcrumbs and Title -->
				<div>
					<nav class="flex" aria-label="Breadcrumb">
						<ol class="inline-flex items-center space-x-1 md:space-x-3">
							<!-- Home Icon and Link -->
							<li>
								<div class="flex items-center space-x-1">
									<a href="/admin/dashboard" class="inline-flex items-center group text-red-600 hover:text-red-600 text-sm font-medium">
										<svg class="w-5 h-5 text-gray-500 mr-1 group-hover:text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path
												stroke-linecap="round"
												stroke-linejoin="round"
												stroke-width="2"
												d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
											/>
										</svg>
									</a>
									<svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
									</svg>
									<a v-if="$page.props.auth.user.roles[0].name === 'admin'" href="/admin/dashboard" class="inline-flex items-center text-sm font-medium text-black group hover:text-red-600">
										Admin Dashboard
									</a>

									<a v-if="$page.props.auth.user.roles[0].name === 'clerk'" href="/clerk/dashboard" class="inline-flex items-center text-sm font-medium text-red-600 group hover:text-red-600">
										<svg class="w-5 h-5 mr-1 text-gray-500 group-hover:text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path
												stroke-linecap="round"
												stroke-linejoin="round"
												stroke-width="2"
												d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
											/>
										</svg>
										Clerk Dashboard
									</a>

									<svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
									</svg>

									<a href="patients" class="inline-flex items-center text-sm font-medium text-red-600">
										Patients
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="mt-2 text-xl font-semibold text-gray-900">Patient List</h1>
				</div>
				<div class="flex items-center space-x-3">
					<div class="hidden sm:flex sm:items-center sm:ml-6">
						<div class="relative ml-3">
							<Dropdown align="right" width="48">
								<template #trigger>
									<span class="inline-flex rounded-md">
										<button
											type="button"
											class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-black transition duration-150 ease-in-out bg-transparent border border-transparent rounded-md focus:outline-none"
										>
											<svg class="w-6 h-6 mr-1 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													stroke-width="2"
													d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
												/>
											</svg>
											{{ $page.props.auth.user.name }}
											<svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
											</svg>
										</button>
									</span>
								</template>

								<template #content>
									<DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
									<DropdownLink :href="route('logout')" method="post" as="button">
										Log Out
									</DropdownLink>
								</template>
							</Dropdown>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="relative overflow-visible bg-white rounded-lg shadow-lg">
			<h2 class="mt-2 text-xl font-semibold text-gray-900 px-4 py-4">Patient details</h2>
			<hr class="border-t border-gray-300 w-full">
      <div v-if="patient" class="px-4 py-4">
        <div class="mb-2">
          <p><strong>Name:</strong> <span class="text-gray-700">{{ props.patient.first_name }} {{ props.patient.last_name }}</span></p>
        </div>
        <div class="mb-2">
          <p><strong>Gender:</strong> <span class="text-gray-700">{{ props.patient.gender }}</span></p>
        </div>
        <div class="mb-2">
          <p><strong>Email:</strong> <span class="text-gray-700">{{ props.patient.email }}</span></p>
        </div>
        <div class="mb-2">
          <p><strong>Occupation:</strong> <span class="text-gray-700">{{ props.patient.occupation }}</span></p>
        </div>
        <div class="mb-2">
          <p><strong>Address:</strong> <span class="text-gray-700">{{ props.patient.address }}</span></p>
        </div>
        <div class="mb-2">
          <p><strong>Age:</strong> <span class="text-gray-700">{{ calculateAge(props.patient.date_of_birth) }}</span></p>
        </div>
      </div>

	 	 <div class="overflow-x-auto">
			<table class="min-w-full text-sm font-light text-center text-gray-700">
				<thead class="text-xs text-white uppercase bg-red-400">
					<tr>
						<th scope="col" class="px-6 py-4">Diagnosis</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="px-6 py-3 whitespace-nowrap">Buang</td>
					</tr>
				</tbody>
			</table>
    	</div>
	</div>

    </DashboardLayout>
</template>
<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { ref, watch, defineProps, onMounted } from 'vue';

const props = defineProps({
    patient: Object,
    message: String,
    message_type: String,
});

const patients = ref(props.patients || null);
const message = ref(props.message || '');
const messageType = ref(props.message_type || 'info');


// Watch for updates in patients prop
watch(() => props.patient, (newValue) => {
    console.log('Updated patients:', newValue);
    patient.value = newValue;
});

// Clear message after timeout
const clearTimeoutDuration = 3000; // 3 seconds
onMounted(() => {
    setTimeout(() => {
        message.value = '';
        messageType.value = '';
    }, clearTimeoutDuration);
});

const calculateAge = (dateOfBirth) => {
		  if (!dateOfBirth) return null; // If date_of_birth is not provided
		  const birthDate = new Date(dateOfBirth);
		  const ageDiff = Date.now() - birthDate.getTime();
		  const ageDate = new Date(ageDiff);
		  return Math.abs(ageDate.getUTCFullYear() - 1970); // Calculate age
		};

// Log props for debugging
console.table(props.patient);
console.log('Message:', message.value);
console.log('Message Type:', messageType.value);
</script>
