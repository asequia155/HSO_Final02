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

		<!-- Alert Modal -->
		<div v-if="flashMessage" class="fixed z-50 flex items-center max-w-lg overflow-hidden transform -translate-x-1/2 bg-white border border-green-600 rounded-lg shadow-lg top-5 left-1/2">
			<div class="flex items-center justify-center p-4 bg-green-600">
				<svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
				</svg>
			</div>
			<div class="flex-1 px-4 py-3 text-gray-700">
				{{ message }}
			</div>
		</div>

		<div class="relative overflow-visible bg-white rounded-lg shadow-lg">
			<div class="flex items-center justify-between w-full p-4 border-b border-neutral-200">
				<div class="flex items-center space-x-4">
					<!-- Search Bar and Filter Button -->
					<form class="flex items-center">
						<label for="search" class="sr-only">Search</label>
						<div class="relative w-80">
							<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
								<svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
								</svg>
							</div>
							<input
								type="text"
								id="search"
								v-model="searchQuery"
								placeholder="Search Patient..."
								class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
							/>
						</div>
					</form>
					<!-- Filter Dropdown -->
					<div class="relative inline-block text-left">
						<!-- Toggle Button -->
						<button
							@click="toggleFilterDropdown"
							id="filterDropdownButton"
							class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg md:w-auto focus:border-red-500 hover:bg-red-100 hover:text-red-500 focus:z-10 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 dark:bg-red-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-blue-400 dark:hover:bg-gray-700"
							type="button"
						>
							<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
								<path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
							</svg>
							Filter
							<svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
							</svg>
						</button>

						<!-- Dropdown Menu -->
						<div v-show="filterdropdownOpen" id="filterDropdown" class="absolute z-[100] w-48 mt-2 bg-white rounded-lg shadow-lg dark:bg-gray-700 p-3">
							<h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose gender</h6>
							<ul class="space-y-2 text-sm">
								<li class="flex items-center">
									<input
										id="male"
										type="checkbox"
										value="male"
										v-model="selectedGenders"
										class="w-4 h-4 bg-red-100 border-red-300 rounded focus:ring-2 focus:ring-red-500 focus:outline-none checked:bg-red-500 checked:border-red-500"
									/>
									<label for="male" class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Male</label>
								</li>
								<li class="flex items-center">
									<input
										id="female"
										type="checkbox"
										value="female"
										v-model="selectedGenders"
										class="w-4 h-4 bg-red-100 border-red-300 rounded focus:ring-2 focus:ring-red-500 focus:outline-none checked:bg-red-500 checked:border-red-500"
									/>
									<label for="female" class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Female</label>
								</li>
								<li class="flex items-center">
									<input
										id="other"
										type="checkbox"
										value="other"
										v-model="selectedGenders"
										class="w-4 h-4 bg-red-100 border-red-300 rounded focus:ring-2 focus:ring-red-500 focus:outline-none checked:bg-red-500 checked:border-red-500"
									/>
									<label for="other" class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Other</label>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- Buttons -->
				<div class="flex items-center space-x-3">
					<!-- Icon Buttons -->
					<button @click="exportToExcel" class="flex items-center justify-center bg-yellow-100 rounded-full w-9 h-9 hover:bg-yellow-200" title="Export to excel">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9v10h12V9M6 5h12v4H6z" />
						</svg>
					</button>
					<button class="flex items-center justify-center bg-purple-100 rounded-full w-9 h-9 hover:bg-purple-200" title="Export">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
						</svg>
					</button>
					<!-- Add Category Button -->
					<button @click="openAddModal" class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-500 rounded-lg hover:bg-gray-600">
						+ New Patient
					</button>
				</div>
			</div>

			<div class="overflow-x-auto">
				<div v-if="patients.length === 0" class="p-4 text-center">
					<p class="text-gray-500">No records yet.</p>
				</div>

				<table v-else class="min-w-full text-sm font-light text-left text-gray-700">
					<thead class="text-xs text-gray-700 uppercase bg-gray-200">
						<tr>
							<th scope="col" class="px-6 py-4">Id</th>
							<th scope="col" class="px-6 py-4">First Name</th>
							<th scope="col" class="px-6 py-4">Last Name</th>
							<th scope="col" class="px-6 py-4">Gender</th>
							<th scope="col" class="px-6 py-4">Email</th>
							<th scope="col" class="px-6 py-4">Contact</th>
							<th scope="col" class="px-6 py-4">Occupation</th>
							<th scope="col" class="px-6 py-4">Age</th>
							<th scope="col" class="px-6 py-4">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item in paginatedPatients" :key="item.id" class="transition border-b cursor-pointer border-neutral-200 hover:bg-neutral-100" @click="viewPatientDetails(item)">
							<td class="px-6 py-3 whitespace-nowrap">{{ item.id }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ item.first_name }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ item.last_name }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ item.gender ? item.gender : 'not set' }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ item.email }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ item.phone }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ item.occupation }}</td>
							<td class="px-6 py-3 whitespace-nowrap">{{ item.age }}</td>
							<td class="px-6 py-3 whitespace-nowrap">
								<!-- Dropdown button for actions -->
								<button
									id="apple-ipad-air-dropdown-button"
									@click.stop="toggleDropdown(item.id)"
									class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover:bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
									type="button"
								>
									<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
										<path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
									</svg>
								</button>

								<!-- Dropdown Menu -->
								<div v-if="dropdownOpen === item.id" class="absolute right-0 z-50 bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
									<ul class="py-1 text-sm" aria-labelledby="apple-ipad-air-dropdown-button">
										<li>
											<button @click.stop="openModal('edit', item)" class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-200">
												<svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
													<path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
													<path fill-rule="evenodd" clip-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
												</svg>
												Edit
											</button>
										</li>
										<li>
											<button
												@click.stop="openDeleteModal(item.first_name + ' ' + item.last_name, item.id)"
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
			<!-- pagination -->
			<div class="relative z-10 flex flex-col items-center justify-between p-4 border-t md:flex-row border-neutral-200">
				<span class="text-sm font-normal text-gray-500"> Showing <span class="font-semibold">{{ startItem }}</span> - <span class="font-semibold">{{ endItem }}</span> of <span class="font-semibold">{{ totalItems }}</span> </span>
				<ul class="inline-flex items-stretch mt-2 -space-x-px md:mt-0">
					<li>
						<button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1.5 border rounded-l-lg">Prev</button>
					</li>
					<li v-for="page in totalPages" :key="page">
						<button @click="changePage(page)" :class="['px-3 py-1.5 border', currentPage === page ? 'bg-gray-300' : 'bg-white']">{{ page }}</button>
					</li>
					<li>
						<button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1.5 border rounded-r-lg">Next</button>
					</li>
				</ul>
			</div>
		</div>

		<!-- Modal Component -->
		<ShowModal :isOpen="showModal" :patients="selectedPatients" @close="closeModal" />
		<EditModal :isOpen="editModal" :patientData="selectedPatients" @close="closeModal" @edit="updatePatient" />

		<!-- <EditModal :isOpen="editModal" :patientData="selectedPatients" @close="closeModal" @save="updatePatient" /> -->

		<AddPatientModal :isOpen="addModal" :patients="patients" @close="closeAddModal" @add="addPatient" />
		<DeletePatientModal :isOpen="deleteModal" :patientName="patientNameToDelete" @close="closeDeleteModal" @confirm="confirmDeletePatient" />
	</DashboardLayout>
</template>

<script setup>
		import { ref, watch, computed, defineProps } from 'vue';
		import { router } from '@inertiajs/vue3';
		import ShowModal from './Show.vue';
		import EditModal from './EditPatientModal.vue';
		import DashboardLayout from '@/Layouts/DashboardLayout.vue';
		import AddPatientModal from './AddPatientModal.vue';
		import DeletePatientModal from './DeletePatientModal.vue';
		import { Inertia } from '@inertiajs/inertia';
		import { onMounted, onBeforeUnmount } from 'vue';
		import { route } from 'ziggy-js';
		import Dropdown from '@/Components/Dropdown.vue';
		import DropdownLink from '@/Components/DropdownLink.vue';
		import { utils, writeFile } from 'xlsx';


		const props = defineProps({
		patients: Array,
		default: () => ({}),
		message: String,
		message_type: String,
		});

		const message = ref(props.message || '');
		const messageType = ref(props.message_type || 'info');
		console.log(props.message);   // Log message content
		console.log(props.message_type); // Log message type

		onMounted(() => {
	  		setTimeout(() => {
	    		message.value = ''; // Clear the message after 3 seconds
				messageType.value = '';
	  		}, 3000);
		});

		const addModal = ref(false);
		const searchQuery = ref('');
		const currentPage = ref(1);
		const itemsPerPage = ref(5);
		const flashMessage = ref(null);
		const showModal = ref(false);
		const editModal = ref(false);
		const selectedPatients = ref(null); // Initialized as null
		const deleteModal = ref(false);
		const patientNameToDelete = ref('');
		const filterdropdownOpen = ref(false);

		// State for selected genders
		const selectedGenders = ref([]);

		// Method to toggle the visibility of the gender filter dropdown
		function toggleFilterDropdown() {
		  filterdropdownOpen.value = !filterdropdownOpen.value;
		}

		// Modal management SHOW and EDIT/Update
		const openModal = (type, item) => {
		  closeDropdown(); // Close the dropdown whenever a modal is opened

		  if (type === 'edit') {
		    selectedPatients.value = item; // Set the selected patient
		    editModal.value = true;
			filterdropdownOpen.value = false;
		  } else if (type === 'show') {
		    selectedPatients.value = item; // Set the selected patient
		    Inertia.get(`/patients/${item.id}`);
			filterdropdownOpen.value = false;
		  }
		};

		const viewPatientDetails = (item) => {
  router.get(`/patients/${item.id}`, { patient: item }, {
    preserveState: true, // Keeps the current state for smooth navigation
    preserveScroll: true, // Keeps the scroll position
  });
};

		const closeModal = () => {
		  editModal.value = false;
		  showModal.value = false;
		};

		// Computed property to filter patients based on search query
		const filteredPatients = computed(() => {
		  let filteredData = props.patients;

		  // Filter by search query
		  if (searchQuery.value) {
		    filteredData = filteredData.filter((patient) => {
		      return (
		        patient.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
		        patient.last_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
		        patient.email.toLowerCase().includes(searchQuery.value.toLowerCase())
		      );
		    });
		  }

		  // Filter by selected genders
		  if (selectedGenders.value.length > 0) {
		    filteredData = filteredData.filter((patient) => {
		      return selectedGenders.value.includes(patient.gender); // Match selected gender(s)
		    });
		  }

		  return filteredData;
		});

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

		//Delete Patient Function
		const deletePatient = (patientId) => {
		    Inertia.delete(route('patients.destroy', patientId));
		};

		const openDeleteModal = (patientName, patientId) => {
		  closeDropdown(); // Close the dropdown whenever a modal is opened
		  filterdropdownOpen.value = false;
		  patientNameToDelete.value = patientName; // Store the patient's name
		  selectedPatients.value = patientId; // Ensure selectedPatients is an object with an id
		  deleteModal.value = true; // Open delete confirmation modal
		};

		const closeDeleteModal = () => {
		  deleteModal.value = false; // Close delete confirmation modal
		  patientNameToDelete.value = ''; // Clear patient name
		};

		const confirmDeletePatient = () => {
		  deletePatient(selectedPatients.value); // Use the correct ID for deletion
		  closeDeleteModal(); // Close the modal after deletion
		};

		// Computed property for total items
		const totalItems = computed(() => filteredPatients.value.length);
		const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage.value));
		const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1);
		const endItem = computed(() => Math.min(startItem.value + itemsPerPage.value - 1, totalItems.value));

		// Computed property for pagination
		const paginatedPatients = computed(() => {
		  const start = (currentPage.value - 1) * itemsPerPage.value;
		  return filteredPatients.value.slice(start, start + itemsPerPage.value).map((patient) => ({
		    ...patient,
		    age: calculateAge(patient.date_of_birth), // Add the age property
		  }));
		});

		// Pagination navigation functions
		const nextPage = () => {
		  if (currentPage.value < totalPages.value) currentPage.value++;
		};

		const prevPage = () => {
		  if (currentPage.value > 1) currentPage.value--;
		};

		const changePage = (page) => {
		  currentPage.value = page;
		};

		// Modal functions
		const openAddModal = () => {
		  closeDropdown(); // Close the dropdown whenever a modal is opened
		  filterdropdownOpen.value = false;
		  selectedPatients.value = null; // Reset to ensure no patient is selected
		  addModal.value = true;
		};

		const closeAddModal = () => {
		  addModal.value = false;
		};

		const addPatient = (patient) => {
		  Inertia.post(
		    route('patients.store'),
		    {
		      first_name: patient.first_name,
		      last_name: patient.last_name,
		      gender: patient.gender,
		      email: patient.email,
		      phone: patient.phone,
		      date_of_birth: patient.date_of_birth,
		      address: patient.address,
		      occupation: patient.occupation,
		      rx: patient.rx,
		      od: patient.od,
		      os: patient.os,
		      add: patient.add,
		      pd: patient.pd,
		    },
		    {
		      onSuccess: () => {
		        closeAddModal(); // Close the modal after a successful addition
		      },
		      onError: (errors) => {
		        console.error('Error adding patient:', errors);
		      },
		    }
		  );
		};

		// Dropdown functions
		const dropdownOpen = ref(null); // Store the id of the opened dropdown

		const toggleDropdown = (id) => {
		  dropdownOpen.value = dropdownOpen.value === id ? null : id; // Toggle dropdown based on id
		};

		const closeDropdown = () => {
		  dropdownOpen.value = null;
		};

		// Attach event listener to handle clicks outside of dropdown
		onMounted(() => {
		  window.addEventListener('click', (event) => {
		    const target = event.target;
		    const isDropdownButton = target.closest('#apple-ipad-air-dropdown-button'); // Check if clicked inside the button
		    const isDropdownMenu = target.closest('.absolute'); // Check if clicked inside the dropdown
		    if (!isDropdownButton && !isDropdownMenu) {
		      closeDropdown(); // Close if clicked outside
		    }
		  });
		});

		onBeforeUnmount(() => {
		  window.removeEventListener('click', closeDropdown);
		});

		// Age calculation
		const calculateAge = (dateOfBirth) => {
		  if (!dateOfBirth) return null; // If date_of_birth is not provided
		  const birthDate = new Date(dateOfBirth);
		  const ageDiff = Date.now() - birthDate.getTime();
		  const ageDate = new Date(ageDiff);
		  return Math.abs(ageDate.getUTCFullYear() - 1970); // Calculate age
		};

		const exportToExcel = () => {
	    const worksheetData = props.patients.map((patient) => ({
	        Id: patient.id,
	        'First Name': patient.first_name,
	        'Last Name': patient.last_name,
	        Gender: patient.gender ? patient.gender : 'not set',
	        Email: patient.email,
	        Contact: patient.phone,
	        Occupation: patient.occupation,
	        Age: calculateAge(patient.date_of_birth),
			RX: patient.rx ? patient.rx : 'not recorded',
	        OD: patient.od ? patient.od : 'not recorded',
	        OS: patient.os ? patient.os : 'not recorded',
	        ADD: patient.add ? patient.add : 'not recorded',
	        PD: patient.pd ? patient.pd : 'not recorded',
	    }));

	    const worksheet = utils.json_to_sheet(worksheetData);
	    const workbook = utils.book_new();
	    utils.book_append_sheet(workbook, worksheet, 'Patients');

	    // Generate and download the Excel file
	    writeFile(workbook, 'Patient_List.xlsx');
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
