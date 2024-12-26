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
										Clerk Dashboard
									</a>

									<svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
									</svg>
									<a href="../patients" class="inline-flex items-center text-sm font-medium text-black group hover:text-red-600">
										Patient List
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
		<div class="relative overflow-visible bg-white rounded-lg shadow-lg px-2">
			<div class="flex items-center justify-between">
				<!-- Left Section -->
				<h2 class="mt-2 text-xl font-semibold text-gray-900 px-4 py-4">Patient Details</h2>
				<!-- Right Section -->
				<div class="flex items-center space-x-4">
					<!-- Add New Record Button -->
					<button @click="opeEditPatientModal" class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-500 rounded-lg hover:bg-gray-600 mr-4">
						Update Details
					</button>
				</div>
			</div>
			<!-- Patient Details -->
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
					<p><strong>Phone:</strong> <span class="text-gray-700">+63 {{ patient.phone }}</span></p>
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
		</div>
		<div class="relative overflow-visible bg-white rounded-lg shadow-lg mt-4">
			<!-- Header Section -->
			<div class="flex items-center justify-between px-4 py-2 border-b border-gray-200">
				<h2 class="text-lg font-semibold text-gray-700">Prescriptions Details</h2>
				<!-- Right Section with Buttons -->
				<div class="flex items-center space-x-4">
					<!-- Export to Excel Button -->
					<button @click="exportToExcel" class="flex items-center justify-center bg-yellow-100 rounded-full w-9 h-9 hover:bg-yellow-200" title="Export to Excel">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9v10h12V9M6 5h12v4H6z" />
						</svg>
					</button>
					<!-- Add New Record Button -->
					<button @click="openAddModal" class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-500 rounded-lg hover:bg-gray-600">
						New Record
					</button>
				</div>
			</div>

			<!-- Table Section -->
			<div class="overflow-x-auto">
				<!-- Display message when no prescriptions are available -->
				<div v-if="paginatedPrescriptions.length === 0" class="p-4 text-center">
					<p class="text-gray-500">No prescriptions available.</p>
				</div>

				<!-- Prescription Table -->
				<table v-else class="min-w-full text-sm font-light text-left text-gray-700">
					<thead class="text-xs text-gray-700 uppercase bg-gray-200">
						<tr>
							<th scope="col" class="px-6 py-4">Date</th>
							<th scope="col" class="px-6 py-4">RX</th>
							<th scope="col" class="px-6 py-4">OD</th>
							<th scope="col" class="px-6 py-4">OS</th>
							<th scope="col" class="px-6 py-4">ADD</th>
							<th scope="col" class="px-6 py-4">PD</th>
							<th scope="col" class="px-6 py-4">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="prescription in paginatedPrescriptions" :key="prescription.id" class="transition border-b cursor-pointer border-neutral-200 hover:bg-neutral-100">
							<td class="px-6 py-3 whitespace-nowrap">{{ new Date(prescription.created_at).toLocaleDateString() }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ prescription.rx }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ prescription.od }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ prescription.os }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ prescription.add }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ prescription.pd }}</td>
							<td class="px-6 py-3 whitespace-nowrap">
								<!-- Dropdown button for actions -->
								<button
									@click.stop="toggleDropdown(prescription.id)"
									class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover:bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
								>
									<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
										<path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
									</svg>
								</button>

								<!-- Dropdown Menu -->
								<div v-if="dropdownOpen === prescription.id" class="absolute right-0 z-50 bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
									<ul class="py-1 text-sm">
										<li>
											<button @click.stop="openModal('edit', prescription)" class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-200">
												Edit
											</button>
										</li>
										<li>
											<button @click.stop="openDeleteModal(prescription.id)" class="flex items-center w-full px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-red-400">
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

			<!-- Pagination -->
			<div class="relative z-10 flex flex-col items-center justify-between p-4 border-t md:flex-row border-neutral-200">
				<span class="text-sm font-normal text-gray-500"> Showing <span class="font-semibold">{{ startItem }}</span> - <span class="font-semibold">{{ endItem }}</span> of <span class="font-semibold">{{ totalItems }}</span> </span>
				<ul class="inline-flex items-stretch mt-2 -space-x-px md:mt-0">
					<li>
						<button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1.5 border rounded-l-lg">Prev</button>
					</li>
					<li v-for="page in totalPages" :key="page">
						<button @click="changePage(page)" :class="['px-3 py-1.5 border', currentPage === page ? 'bg-gray-300' : 'bg-white']">
							{{ page }}
						</button>
					</li>
					<li>
						<button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1.5 border rounded-r-lg">Next</button>
					</li>
				</ul>
			</div>
		</div>

		<AddPatientRecord :isOpen="addModal" :patientId="patient.id" @close="closeAddModal" @add="addRecord" />
		<!-- Edit Modal -->
		<EditPatientRecord :isOpen="editModal" :patientData="selectedPatient" @edit="handleEdit" @close="closeEditModal" />
		<EditModal :isOpen="editPatientModal" :patientData="selectedPatients" @close="closeModal" @edit="updatePatient" />
		<DeletePatientRecord :isOpen="deleteModal" :prescriptionId="selectedPrescriptionId" :patientId="patient.id" @close="closeDeleteModal" @delete="handleDelete" />
	</DashboardLayout>
</template>

<script setup>
		  import DashboardLayout from '@/Layouts/DashboardLayout.vue';
		  import { ref, defineProps, computed } from 'vue';
		  import { onMounted, onBeforeUnmount } from 'vue';
		  import Dropdown from '@/Components/Dropdown.vue';
		  import DropdownLink from '@/Components/DropdownLink.vue';
		  import AddPatientRecord from './AddPatientRecord.vue';
		  import { Inertia } from '@inertiajs/inertia';
		  import { route } from 'ziggy-js';
		  import EditPatientRecord from './EditPatientRecord.vue';
		  import EditModal from './EditPatientModal.vue';
		  import DeletePatientRecord from './DeletePatientRecord.vue';
		  const props = defineProps({
			patient: Object,
			message: String,
			message_type: String,
		  });

		  	const message = ref(props.message || '');
			const messageType = ref(props.message_type || 'info');
			console.log(props.message);   // Log message content
			console.log(props.message_type); // Log message type
			const dropdownOpen = ref(null);
			const editModal = ref(false);
			const selectedPatient = ref(null);
			const deleteModal = ref(false);
			const editPatientModal = ref(false);
			const selectedPatients = ref(null);
	const selectedPrescriptionId = ref(null);
	const prescriptions = ref(props.patient?.prescriptions || []); // Safely access `patient.prescriptions`
	const currentPage = ref(1);
	const itemsPerPage = ref(5);

	const totalItems = computed(() => prescriptions.value.length);
	const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage.value));

	const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1);
	const endItem = computed(() => Math.min(currentPage.value * itemsPerPage.value, totalItems.value));

	const paginatedPrescriptions = computed(() =>
	  prescriptions.value.slice(startItem.value - 1, endItem.value)
	);

	const changePage = (page) => {
	  if (page >= 1 && page <= totalPages.value) {
	    currentPage.value = page;
	  }
	};

	const prevPage = () => {
	  if (currentPage.value > 1) {
	    currentPage.value--;
	  }
	};

	const nextPage = () => {
	  if (currentPage.value < totalPages.value) {
	    currentPage.value++;
	  }
	};

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

		const opeEditPatientModal = () => {
			editPatientModal.value = true;
			selectedPatients.value = props.patient;
		}

		const closeModal = () => {
			editPatientModal.value = false;
			};

			const updatePatient = (updatedPatient) => {
			  console.log('Updated patient data:', updatedPatient); // Check updated patient data
			  Inertia.put(route('patients.update', updatedPatient.id), updatedPatient, {
			    onSuccess: () => {
			      flashMessage.value = 'Patient updated successfully!';
			      close();
			    },
			    onError: (errors) => {
			      console.error('Error updating patient:', errors);
			      flashMessage.value = 'Error updating patient. Please try again.';
			    },
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
