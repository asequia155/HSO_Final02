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

                <!-- Diri start -->
				<div class="flex items-center space-x-3">
                    <div class="relative mt-2">
        <!-- Notification Icon -->
        <button @click.prevent="toggleNotifDropdown">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 17h5l-1.405-1.405C18.317 14.74 18 13.38 18 12V9c0-3.866-3.134-7-7-7S4 5.134 4 9v3c0 1.38-.317 2.74-.595 3.595L2 17h5m8 0a3 3 0 01-6 0m6 0H9"
                />
            </svg>
        </button>

        <!-- Notification Dropdown -->
        <div v-if="notifDropdownOpen" class="absolute z-10 mt-2 bg-white rounded-lg shadow-lg w-72">
            <ul>
                <!-- FIX: Correct key and property bindings -->
                <li v-for="notification in notifications" :key="notification.id" class="p-4 border-b">
                    <div>
                        <h4 class="font-semibold">{{ notification.title }}</h4>
                        <p class="text-sm text-gray-600">{{ notification.message }}</p>
                    </div>
                </li>
                <li>
                    <Link :href="route('notifications.index')">

                    <div v-if="notifications.length !== 0"  class="p-2 text-center text-gray-500">
                        Show all notifications
                    </div>
                </Link>
                </li>
            </ul>
            <!-- FIX: Check notifications array directly -->
            <div v-if="notifications.length === 0" class="p-4 text-center text-gray-500">
                No new notifications
            </div>
        </div>
    </div>
<!-- diri taman ang notif -->
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
								placeholder="Search Appointment..."
								class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
							/>
						</div>
					</form>
				</div>
                <div class="flex items-center space-x-4">
    <!-- New Appointment Button -->
    <a
      href="/ReservationForm"
      class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-500 rounded-lg hover:bg-gray-600"
    >
      +New Appointment
    </a>
  </div>
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
          <th scope="col" class="px-6 py-4">Status</th>
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
          <td class="px-6 py-3 whitespace-nowrap">{{ item.status }}</td>
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
<!-- New Holiday Modal -->

<!-- Holiday Modal -->


    <!-- Add Patient Modal (Left-Aligned) -->


		<DeleteReservationModal :isOpen="deleteModal" :reservationName="reservationNameToDelete" @close="closeDeleteModal" @confirm="confirmDeleteReservation" />
	</DashboardLayout>


</template>

<script setup>
import { ref, watch, computed, defineProps } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { onMounted, onBeforeUnmount } from 'vue';
import { route } from 'ziggy-js';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import axios from 'axios';

import { Link, usePage } from "@inertiajs/inertia-vue3";
import ReservationHistory from '../Reservation/ReservationHistory.vue';


    // State for HolidayModal
    const showHolidayModal = ref(false);


		const searchQuery = ref('');
		const currentPage = ref(1);
		const itemsPerPage = ref(5);
		const flashMessage = ref(null);

		const reservationNameToDelete = ref('');
		const filterdropdownOpen = ref(false);

		// State for selected genders
		const selectedGenders = ref([]);




    const formatTo12Hour = (time) => {
    const [hour, minute, ] = time.split(':');
    let hourIn12 = parseInt(hour, 10);
    const period = hourIn12 >= 12 ? 'PM' : 'AM';
    hourIn12 = hourIn12 % 12 || 12; // Convert 0 or 12 to 12 in 12-hour format
    return `${hourIn12}:${minute} ${period}`;
};



    const props = defineProps({
        reservations: Array,
        ReservationHistory: Array,
        message: String,
        message_type: String,
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

console.log(props.reservations?.data || []);


// Call refresh after deleting a reservation

		// Method to toggle the visibility of the gender filter dropdown
		function toggleFilterDropdown() {
		  filterdropdownOpen.value = !filterdropdownOpen.value;
		}



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

        const filteredReservations = computed(() => {
    // Extract the data array from the paginated reservations object
    const reservationData = props.reservations?.data || [];

    let filteredData = Array.isArray(reservationData) ? reservationData : [];

    // Filter by search query
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filteredData = filteredData.filter((reservation) => {
            return (
                reservation.first_name?.toLowerCase().includes(query) ||
                reservation.last_name?.toLowerCase().includes(query) ||
                reservation.email?.toLowerCase().includes(query)
            );
        });
    }

    // Filter by selected genders
    if (selectedGenders.value.length > 0) {
        filteredData = filteredData.filter((reservation) =>
            selectedGenders.value.includes(reservation.gender)
        );
    }

    // Optionally sort by `appointment_date`
    filteredData.sort((a, b) => (a.appointment_date < b.appointment_date ? 1 : -1));

    return filteredData;
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

