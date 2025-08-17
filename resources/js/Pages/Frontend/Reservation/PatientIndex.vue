Index

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
									<a href="/Reservation/Reservation List" class="inline-flex items-center text-sm font-medium text-red-600 group hover:text-red-600">
										<svg class="w-5 h-5 mr-1 text-gray-500 group-hover:text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
									<a href="reservations" class="inline-flex items-center text-sm font-medium text-red-600">
										Appointment
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="mt-2 text-xl font-semibold text-gray-900">Today's Appointments</h1>
				</div>


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
								placeholder="Search Appointment..."
								class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
							/>
						</div>
					</form>
                </div>
    <!-- New Appointment Button -->
    <a
      href="/ReservationForm"
      class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-500 rounded-lg hover:bg-gray-600"
    >
      +New Appointment
    </a>
      <!-- Full Remarks Modal -->
      <div v-if="showRemarksModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
          <h2 class="p-4 text-lg font-semibold text-white bg-red-500 rounded-t-lg">
            Full Remarks
          </h2>
          <p class="mt-4 text-gray-600 whitespace-pre-wrap">{{ fullRemarks }}</p>
          <div class="flex justify-end mt-6">
            <button
              @click="closeRemarksModal"
              class="px-4 py-2 text-sm text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none"
            >
              Close
            </button>
          </div>
        </div>
      </div>
		</div>
  <div class="overflow-x-auto">
    <div v-if="reservations.length === 0" class="p-4 text-center">
      <p class="text-gray-500">No records yet.</p>
    </div>

    <table v-else class="min-w-full text-sm font-light text-left text-gray-700">
      <thead class="text-xs text-gray-700 uppercase bg-gray-200">
        <tr>
          <th scope="col" class="px-6 py-4">Name</th>

          <th scope="col" class="px-6 py-4">Contact</th>
          <th scope="col" class="px-6 py-4">Email</th>
          <th scope="col" class="px-6 py-4">Gender</th>
          <th scope="col" class="px-6 py-4">Appointment Date</th>
          <th scope="col" class="px-6 py-4">Appointment Time</th>
          <th scope="col" class="py-4 px- 6">Remarks</th>
          <th scope="col" class="px-6 py-4">Actions</th>
        </tr>
      </thead>
      <tbody>

        <tr v-for="item in paginatedReservations" :key="item.id" class="transition border-b cursor-pointer border-neutral-200 hover:bg-neutral-100">
            <td class="px-6 py-3 whitespace-nowrap">{{ item.first_name + ' ' + item.last_name}}</td>
            <td class="px-6 py-3 whitespace-nowrap">+63 {{ item.phone }}</td>
          <td class="px-6 py-3 whitespace-nowrap">{{ item.email }}</td>
          <td class="px-6 py-3 whitespace-nowrap">{{ item.gender ? item.gender : 'not set' }}</td>
          <td class="px-6 py-3 whitespace-nowrap">{{ item.appointment_date }}</td>
          <td class="px-6 py-3 whitespace-nowrap">{{ formatTo12Hour(item.appointment_time) }}</td>
          <td
            class="px-6 py-3 whitespace-nowrap"
            @click.stop="openRemarksModal(item.remarks)"
            title="Click to view full remarks"
          >
            {{ truncateText(item.remarks, 15) }}
          </td>

          <td class="px-6 py-3 whitespace-nowrap">
								<!-- Dropdown button for actions -->

										<!-- Dropdown button for actions -->

                    <li>
                      <button
                        @click="openDeleteReservationModal(item.first_name + ' ' + item.last_name, item.id)"
                        class="flex items-center w-full px-4 py-2 text-red-500 hover:bg-red-500 hover:text-white focus:outline-none"
                      >
                        <svg
                          class="w-4 h-4 mr-2"
                          viewBox="0 0 14 15"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                          aria-hidden="true"
                        >
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
    <button
      @click="prevPage"
      :disabled="currentPage === 1"
      class="px-3 py-1.5 border rounded-l-lg">
      Prev
    </button>
  </li>

  <!-- Page Numbers -->
  <li v-if="currentPage > 3">
    <button @click="changePage(1)" class="px-3 py-1.5 border bg-white">1</button>
    <span class="px-2 py-1.5">...</span>
  </li>

  <!-- Dynamic Pages -->
  <li v-for="page in visiblePages" :key="page">
    <button
      @click="changePage(page)"
      :class="['px-3 py-1.5 border', currentPage === page ? 'bg-gray-300' : 'bg-white']">
      {{ page }}
    </button>
  </li>

  <li v-if="currentPage < totalPages - 2">
    <span class="px-2 py-1.5">...</span>
    <button @click="changePage(totalPages)" class="px-3 py-1.5 border bg-white">{{ totalPages }}</button>
  </li>

  <!-- Next Button -->
  <li>
    <button
      @click="nextPage"
      :disabled="currentPage === totalPages"
      class="px-3 py-1.5 border rounded-r-lg">
      Next
    </button>
  </li>
</ul>

			</div>
		</div>

<!-- Holiday Modal -->





		<DeleteReservationModal :isOpen="deleteModal" :reservationName="reservationNameToDelete" @close="closeDeleteModal" @confirm="confirmDeleteReservation" />
	</DashboardLayout>


</template>

<script setup>
		import { ref, watch, computed, defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DeleteReservationModal from './DeleteReservationModal.vue';
import { Inertia } from '@inertiajs/inertia';
import { onMounted, onBeforeUnmount } from 'vue';
import route from 'ziggy-js';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import axios from 'axios';
import { Link, usePage } from "@inertiajs/inertia-vue3";


    // State for HolidayModal
    const showHolidayModal = ref(false);

    // State for NewHolidayModal
    const showNewHolidayModal = ref(false);
    const addModal = ref(false);
    const reservationNameToConfirm = ref(''); // Stores the name of the reservation

		const searchQuery = ref('');
		const currentPage = ref(1);
		const itemsPerPage = ref(5);
		const flashMessage = ref(null);
		const showModal = ref(false);
		const selectedReservations = ref(null); // Initialized as null
		const deleteModal = ref(false);
		const reservationNameToDelete = ref('');
    const selectedPatients = ref(null);
    const patients = ref([]); // Patients data
    const viewReservationModalOpen = ref(false); // State to toggle the modal
    const selectedReservation = ref(null); // Data for the selected reservation

		// State for selected genders
		const selectedGenders = ref([]);
    const holidayDropdownOpen = ref(false);
    const deleteHolidayModal = ref(false);

    const { flash } = usePage().props;



    const patientExists = async (email) => {
    try {
        const response = await axios.get(route('patientexist.show', email));
        return response.data.exists;
    } catch (error) {
        console.error("Error checking patient existence:", error);
        return false; // Assume the patient does not exist in case of error
    }
};


    const formatTo12Hour = (time) => {
    const [hour, minute, ] = time.split(':');
    let hourIn12 = parseInt(hour, 10);
    const period = hourIn12 >= 12 ? 'PM' : 'AM';
    hourIn12 = hourIn12 % 12 || 12; // Convert 0 or 12 to 12 in 12-hour format
    return `${hourIn12}:${minute} ${period}`;
};

const openNewHolidayModal = () => {
    closeHolidayListModal(); // Ensure other modal is closed
    showNewHolidayModal.value = true;
  console.log('Opening new holiday modal');
};

const closeNewHolidayModal = () => {
    showNewHolidayModal.value = false;
};
		const props = defineProps({
		reservations: Array,
		default: () => ({}),
		message: String,
		message_type: String,
        reservations: Array,
        notifications: {
        type: Array,
            required: true,
        },

		});

        const notifDropdownOpen = ref(false);

// Toggle the dropdown visibility
const toggleNotifDropdown = () => {
    notifDropdownOpen.value = !notifDropdownOpen.value;
};

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

const openHolidayModal = () => {
    closeNewHolidayModal(); // Ensure other modal is closed
    showHolidayModal.value = true;
  console.log('Opening holiday modal');
};

const closeHolidayListModal = () => {
    showHolidayModal.value = false;
};

// Modal states
const showRemarksModal = ref(false);
const fullRemarks = ref("");

// Functions to handle remarks modal
const openRemarksModal = (remarks) => {
  fullRemarks.value = remarks;
  showRemarksModal.value = true;
};

const closeRemarksModal = () => {
  showRemarksModal.value = false;
  fullRemarks.value = "";
};



const openModals  = (item) => {
  // Close any open dropdowns

  closeDropdown();
  console.log(item);
  selectedPatients.value = {...item}; // Copy reservation data
  addModal.value = true; // Open the modal
  console.log( selectedPatients.value );

};


const closeAddModal = () => {
  addModal.value = false;
  selectedPatients.value = [];
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



// Functions to toggle and close the dropdown
const toggleHolidayDropdown = () => {
  holidayDropdownOpen.value = !holidayDropdownOpen.value;
};

const closeHolidayDropdown = () => {
  holidayDropdownOpen.value = false;
};


// Call refresh after adding a holiday
const handleAddNewHoliday = () => {
    holidayDropdownOpen.value = false;
    openNewHolidayModal();
};

// Call refresh after showing holidays
const handleShowHoliday = () => {
    holidayDropdownOpen.value = false;
    openHolidayModal();
};

// Call refresh after deleting a reservation

		// Method to toggle the visibility of the gender filter dropdown
		function toggleFilterDropdown() {
		  filterdropdownOpen.value = !filterdropdownOpen.value;
		}

		// Modal management SHOW and EDIT/Update
		const openModal = ( item) => {
		  closeDropdown(); // Close the dropdown whenever a modal is opened

		    selectedReservations.value = item; // Set the selected reservation
		    Inertia.get(`/reservations/${item.id}`);
			filterdropdownOpen.value = false;
		  }
		;



		// Computed property to filter reservations based on search query
		const filteredReservations = computed(() => {
      let filteredData = props.reservations;

      // Filter by search query
      if (searchQuery.value) {
          filteredData = filteredData.filter((reservation) => {
              return (
                  reservation.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                  reservation.last_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                  reservation.email.toLowerCase().includes(searchQuery.value.toLowerCase())
              );
          });
      }

      // Filter by selected genders
      if (selectedGenders.value.length > 0) {
          filteredData = filteredData.filter((reservation) => {
              return selectedGenders.value.includes(reservation.gender);
          });
      }

      // Sort by descending order (e.g., by ID or appointment_date)
      return filteredData;
        });
        const confirmReservation = (reservationId) => {
		    Inertia.post(`/reservations/${reservationId}/confirm`);
		};

        const openConfirmReservationModal = (reservationName, reservationId) => {
  closeDropdown(); // Close the dropdown whenever a modal is opened
  filterdropdownOpen.value = false;
  reservationNameToConfirm.value = reservationName; // Store the patient's name
  selectedReservations.value = reservationId; // Store reservation ID
  confirmModal.value = true; // Open confirmation modal
};

const closeConfirmModal = () => {
  confirmModal.value = false; // Close confirmation modal
  reservationNameToConfirm.value = ''; // Clear reservation name
};

const confirmConfirmReservation = async () => {
    confirmReservation(selectedReservations.value); // Use the correct ID for deletion
    refreshReservations(); // Refresh reservations after confirmation
  closeConfirmModal(); // Close the modal after confirmation
};


		//Delete Patient Function
		const deleteReservation = (reservationId) => {
		    Inertia.delete(route('reservations.destroy', reservationId));
		};

		const openDeleteReservationModal = (reservationName, reservationId) => {
    closeDropdown(); // Close the dropdown whenever a modal is opened
    filterdropdownOpen.value = false;
    reservationNameToDelete.value = reservationName; // Store the patient's name
    selectedReservations.value = reservationId; // Store reservation ID
    deleteModal.value = true; // Open delete confirmation modal
};


		const closeDeleteModal = () => {
		  deleteModal.value = false; // Close delete confirmation modal
		  reservationNameToDelete.value = ''; // Clear reservation name
		};

		const confirmDeleteReservation = async () => {
		  deleteReservation(selectedReservations.value); // Use the correct ID for deletion
          refreshReservations(); // Refresh reservations after deletion
		  closeDeleteModal(); // Close the modal after deletion
		};

		// Computed property for total items
		const totalItems = computed(() => filteredReservations.value.length);
		const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage.value));
		const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1);
		const endItem = computed(() => Math.min(startItem.value + itemsPerPage.value - 1, totalItems.value));

		// Computed property for pagination
		const paginatedReservations = computed(() => {
		  const start = (currentPage.value - 1) * itemsPerPage.value;
		  return filteredReservations.value.slice(start, start + itemsPerPage.value).map((reservation) => ({
		    ...reservation,

		  }));
		});

		const visiblePages = computed(() => {
  const range = 5; // Number of pages to display in range
  const pages = [];

  let start = Math.max(1, currentPage.value - Math.floor(range / 2));
  let end = Math.min(totalPages.value, start + range - 1);

  if (end === totalPages.value) {
    start = Math.max(1, end - range + 1);
  }

  for (let i = start; i <= end; i++) {
    pages.push(i);
  }
  return pages;
});

// Navigation functions
const changePage = (page) => {
  currentPage.value = page;
};

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
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




// Reset the "new reservation" count when viewing the page
onMounted(() => {
    axios.post(route('reservations.mark.viewed'))
        .then(() => {
            console.log('Viewed reservations, count reset.');
        })
        .catch((error) => {
            console.error('Error resetting reservation count:', error);
        });
    });
// Function to truncate text and append ellipsis
const truncateText = (text, length) => {
  if (!text) return ''; // If text is null or undefined
  return text.length > length ? text.substring(0, length) + '...' : text;
};

// Handle Manage Holidays button
const loadingHolidays = ref(false);

const fetchHolidays = async () => {
  loadingHolidays.value = true;
  try {
    const response = await axios.get(route("reservations.fetchHolidays"));
    holidays.value = response.data;
    console.log("Holidays fetched:", holidays.value);
  } catch (error) {
    console.error("Error fetching holidays:", error);
  } finally {
    loadingHolidays.value = false;
  }
};
const holidays = ref([]);




const closeHolidayModal = () => {
  showHolidayModal.value = false;
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

