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
										Patient Detail
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="mt-2 text-xl font-semibold text-gray-900">Patient information</h1>
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
		<!-- Patient Details Section -->
		<div class="relative overflow-visible bg-white rounded-lg shadow-lg">
			<div class="flex items-center justify-between">
				<!-- Left Section -->
				<h2 class="mt-2 text-xl font-semibold text-gray-900 px-4 py-4">Patient Details</h2>

				<!-- Right Section -->
				<div class="flex items-center space-x-4 mr-4">
					<!-- Export to Excel Button -->
					<button @click="exportToExcel" class="flex items-center justify-center bg-yellow-100 rounded-full w-9 h-9 hover:bg-yellow-200" title="Export to Excel">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9v10h12V9M6 5h12v4H6z" />
						</svg>
					</button>
					<!-- Add New Record Button -->
					<button @click="openAddModal" class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-500 rounded-lg hover:bg-gray-600 mr-4">
						New Record
					</button>
				</div>
			</div>

			<hr class="border-t border-gray-300 w-full" />
			<div v-if="patient" class="px-4 py-4">
				<div class="mb-2">
					<p><strong>Name:</strong> <span class="text-gray-700">{{ patient.first_name }} {{ patient.last_name }}</span></p>
				</div>
				<div class="mb-2">
					<p><strong>Gender:</strong> <span class="text-gray-700">{{ patient.gender }}</span></p>
				</div>
				<div class="mb-2">
					<p><strong>Email:</strong> <span class="text-gray-700">{{ patient.email }}</span></p>
				</div>
				<div class="mb-2">
					<p><strong>Email:</strong> <span class="text-gray-700">{{ patient.phone }}</span></p>
				</div>
				<div class="mb-2">
					<p><strong>Occupation:</strong> <span class="text-gray-700">{{ patient.occupation }}</span></p>
				</div>
				<div class="mb-2">
					<p><strong>Address:</strong> <span class="text-gray-700">{{ patient.address }}</span></p>
				</div>
				<div class="mb-2">
					<p><strong>Age:</strong> <span class="text-gray-700">{{ calculateAge(patient.date_of_birth) }}</span></p>
				</div>
			</div>

			<!-- Prescription Table -->
			<div class="overflow-x-auto flex justify-center">
				<div class="w-full max-w-6xl mb-4">
					<table class="w-full text-sm font-light text-center text-gray-700 border border-gray-300">
						<thead class="text-xs text-white uppercase bg-red-400">
							<tr>
								<th scope="col" class="px-6 py-4">Date</th>
								<th scope="col" class="px-6 py-4">RX</th>
								<th scope="col" class="px-6 py-4">OD</th>
								<th scope="col" class="px-6 py-4">OS</th>
								<th scope="col" class="px-6 py-4">ADD</th>
								<th scope="col" class="px-6 py-4">PD</th>
								<th scope="col" class="px-6 py-4">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="prescription in patient.prescriptions" :key="prescription.id" class="border-t border-gray-300">
								<td class="px-6 py-3">{{ new Date(prescription.created_at).toLocaleDateString() }}</td>
								<td class="px-6 py-3">{{ prescription.rx }}</td>
								<td class="px-6 py-3">{{ prescription.od }}</td>
								<td class="px-6 py-3">{{ prescription.os }}</td>
								<td class="px-6 py-3">{{ prescription.add }}</td>
								<td class="px-6 py-3">{{ prescription.pd }}</td>
								<td class="px-6 py-3">
									<button
										id="apple-ipad-air-dropdown-button"
										@click.stop="toggleDropdown(prescription.id)"
										class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover:bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
										type="button"
									>
										<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
											<path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
										</svg>
									</button>
									<div v-if="dropdownOpen === prescription.id" class="absolute right-0 z-50 bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
										<ul class="py-1 text-sm" aria-labelledby="apple-ipad-air-dropdown-button">
											<li>
												<button
													@click.stop="openModal('edit', prescription)"
													class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-200"
												>
													<svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
														<path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
														<path fill-rule="evenodd" clip-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
													</svg>
													Edit
												</button>
											</li>
											<li>
												<button
													 @click="openDeleteModal(prescription.id)"
													class="flex items-center w-full px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-red-400"
												>
													<svg class="w-4 h-4 mr-2" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
														<path
															fill-rule="evenodd"
															clip-rule="evenodd"
															fill="currentColor"
															d="M6.09922 0.300781C5.93212 0.30087 5.76835 0.347476 5.62625 0.435378C5.48414 0.523281 5.36931 0.649009 5.29462 0.798481L4.64302 2.10078H1.59922C1.36052 2.10078 1.13161 2.1956 0.962823 2.36439C0.79404 2.53317 0.699219 2.76209 0.699219 3.00078C0.699219 3.23948 0.79404 3.46839 0.962823 3.63718C1.13161 3.80596 1.36052 3.90078 1.59922 3.90078V12.9008C1.59922 13.3782 1.78886 13.836 2.12643 14.1736C2.46399 14.5111 2.92183 14.7008 3.39922 14.7008H10.5992C11.0766 14.7008 11.5344 14.5111 11.872 14.1736C12.2096 13.836 12.3992 13.3782 12.3992 12.9008V3.90078C12.6379 3.90078 12.8668 3.80596 13.0356 3.63718C13.2044 3.46839 13.2992 3.23948 13.2992 3.00078C13.2992 2.76209 13.2044 2.53317 13.0356 2.36439C12.8668 2.1956 12.6379 2.10078 12.3992 2.10078H9.35542L8.70382 0.798481C8.62913 0.649009 8.5143 0.523281 8.37219 0.435378C8.23009 0.347476 8.06631 0.30087 7.89922 0.300781H6.09922ZM4.29922 5.70078C4.29922 5.46209 4.39404 5.23317 4.56282 5.06439C4.73161 4.8956 4.96052 4.80078 5.19922 4.80078C5.43791 4.80078 5.66683 4.8956 5.83561 5.06439C6.0044 5.23317 6.09922 5.46209 6.09922 5.70078V11.1008C6.09922 11.3395 6.0044 11.5684 5.83561 11.7372C5.66683 11.906 5.43791 12.0008 5.19922 12.0008C4.96052 12.0008 4.73161 11.906 4.56282 11.7372C4.39404 11.5684 4.29922 11.3395 4.29922 11.1008V5.70078ZM8.79922 4.80078C8.56052 4.80078 8.33161 4.8956 8.16282 5.06439C7.99404 5.23317 7.89922 5.46209 7.89922 5.70078V11.1008C7.89922 11.3395 7.99404 11.5684 8.16282 11.7372C8.33161 11.906 8.56052 12.0008 8.79922 12.0008C9.03791 12.0008 9.26683 11.906 9.43561 11.7372C9.6044 11.5684 9.69922 11.3395 9.69922 11.1008V5.70078C9.69922 5.46209 9.6044 5.23317 9.43561 5.06439C9.26683 4.8956 9.03791 4.80078 8.79922 4.80078Z"
														/>
													</svg>
													Delete
												</button>
											</li>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<AddPatientRecord :isOpen="addModal" :patientId="patient.id" @close="closeAddModal" @add="addRecord" />
		<!-- Edit Modal -->
		<EditPatientRecord
      :isOpen="editModal"
      :patientData="selectedPatient"
      @edit="handleEdit"
      @close="closeEditModal"
    />
	<DeletePatientRecord
  :isOpen="deleteModal"
  :prescriptionId="selectedPrescriptionId"
  :patientId="patient.id"
  @close="closeDeleteModal"
  @delete="handleDelete"
/>

	</DashboardLayout>
</template>

<script setup>
	  import DashboardLayout from '@/Layouts/DashboardLayout.vue';
	  import { ref, onMounted, defineProps } from 'vue';
	  import Dropdown from '@/Components/Dropdown.vue';
	  import DropdownLink from '@/Components/DropdownLink.vue';
	  import AddPatientRecord from './AddPatientRecord.vue';
	  import { Inertia } from '@inertiajs/inertia';
	  import { route } from 'ziggy-js';
	  import EditPatientRecord from './EditPatientRecord.vue';
	  import { router } from '@inertiajs/vue3';
	  import DeletePatientRecord from './DeletePatientRecord.vue';
	  const props = defineProps({
		patient: Object,
		message: String,
		message_type: String,
	  });

	  	const message = ref(props.message || '');
		const messageType = ref(props.message_type || 'info');
		const dropdownOpen = ref(null);
		const editModal = ref(false);
		const selectedPatient = ref(null);
		const deleteModal = ref(false);
const selectedPrescriptionId = ref(null);

const openDeleteModal = (prescriptionId) => {
  selectedPrescriptionId.value = prescriptionId;
  deleteModal.value = true;
};

const closeDeleteModal = () => {
  deleteModal.value = false;
  selectedPrescriptionId.value = null;
};

const handleDelete = ({ prescriptionId, patientId }) => {
  Inertia.delete(`/patients/${patientId}/prescriptions/${prescriptionId}`, {
    onSuccess: () => {
      alert('Prescription deleted successfully!');
      deleteModal.value = false; // Close the modal
    },
    onError: (errors) => {
      console.error('Error deleting prescription:', errors);
      alert('Failed to delete the prescription.');
    },
  });
};


		const handleEdit = (updatedData) => {
  console.log('Edited Patient Data:', updatedData);

  Inertia.put(`/patients/${props.patient.id}/prescriptions/${updatedData.id}`, updatedData, {
    onSuccess: () => {
      alert('Prescription updated successfully!');
      editModal.value = false; // Close the modal
    },
    onError: (errors) => {
      console.error('Error updating prescription:', errors);
      alert('Failed to update the prescription.');
    },
  });
};


const closeEditModal = () => {
	editModal.value = false;
}
		const toggleDropdown = (id) => {
			  dropdownOpen.value = dropdownOpen.value === id ? null : id; // Toggle dropdown based on id
			};

			const openModal = (type, item) => {
			  closeDropdown(); // Close the dropdown whenever a modal is opened

			  if (type === 'edit') {
			    selectedPatient.value = item; // Set the selected patient
			    editModal.value = true;
			  }
			};
			const closeDropdown = () => {
			  dropdownOpen.value = null;
			};

			console.log(message);   // Log message content
			console.log(messageType); // Log message type

			onMounted(() => {
		  		setTimeout(() => {
		    		message.value = ''; // Clear the message after 3 seconds
					messageType.value = '';
		  		}, 3000);
			});

	  const addModal = ref(false);
	  const openAddModal = () => {
			  addModal.value = true;
			};

			const closeAddModal = () => {
			  addModal.value = false;
			};
	  // Calculate Age Function
	  const calculateAge = (dateOfBirth) => {
		if (!dateOfBirth) return null;
		const birthDate = new Date(dateOfBirth);
		const ageDiff = Date.now() - birthDate.getTime();
		const ageDate = new Date(ageDiff);
		return Math.abs(ageDate.getUTCFullYear() - 1970);
	  };


	  const addRecord = (data) => {
	  Inertia.post(`/patients/${props.patient.id}/prescriptions`, data, {
	    preserveScroll: true,
	    onSuccess: (response) => {
	      // Update the patient prescriptions from the response
	      patient.value.prescriptions = response.props.patient.prescriptions;
	      closeAddModal();
	    }
	  });
	};
</script>

<style scoped>
	 /* Fade transition for the alert */
	 .alert-fade-enter-active, .alert-fade-leave-active {
	transition: opacity 0.5s ease;
	 }

	 .alert-fade-enter, .alert-fade-leave-to /* .alert-fade-leave-active in <2.1.8 */ {
	opacity: 0;
	 }
</style>
