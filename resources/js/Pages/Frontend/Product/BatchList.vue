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
									<a href="/dashboard" class="inline-flex items-center text-sm font-medium text-red-600 group hover:text-red-600">
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

									<a href="products" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-red-600">
										Inventory
									</a>

									<svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
									</svg>

									<a href="products" class="inline-flex items-center text-sm font-medium text-red-600">
										Batch
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="mt-2 text-xl font-semibold text-gray-900">Batch List</h1>
				</div>
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
                        <span v-if="notifications.length > 0" class="absolute bottom-0 left-0 w-2 h-2 mb-6 ml-5 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div v-if="notifDropdownOpen" class="absolute right-0 z-10 overflow-hidden bg-white rounded-lg shadow-lg w-72">
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
      <div class="flex items-center justify-between w-full p-4 border-b border-neutral-200">
        <div class="flex items-center space-x-4">
          <!-- Search Bar -->
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
                placeholder="Search Product Name..."
                class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              />
            </div>
          </form>
          <!-- Filter Dropdown -->
            <div class="relative inline-block text-left">
                <!-- Toggle Button -->
                <button
                    @click="toggleCategoryDropdown"
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
                <div v-show="isCategoryDropdownOpen1" id="filterDropdown" @click.stop class="absolute z-[100] w-48 mt-2 bg-white rounded-lg shadow-lg dark:bg-gray-700 p-3">
                    <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose Category</h6>
                    <ul class="space-y-2 text-sm">
                        <li v-for="category in props.categories" :key="category.id" @click.stop class="flex items-center">
                            <input type="checkbox" :id="'category-' + category.id" :value="category.id" v-model="selectedCategories" class="w-4 h-4 bg-red-100 border-red-300 rounded focus:ring-2 focus:ring-red-500 focus:outline-none checked:bg-red-500 checked:border-red-500" />
                            <label :for="'category-' + category.id" class="ml-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ category.name }} ({{ category.products_count }})
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Near Expiring Filter -->
          <div class="flex items-center">
            <label for="nearExpiring" class="text-sm font-medium text-gray-700">Show Near Expiring:</label>
            <input
              type="checkbox"
              id="nearExpiring"
              v-model="showNearExpiring"
              class="w-5 h-5 ml-2 border-gray-300 rounded focus:ring-red-500"
            />
          </div>
          <!-- pwede date picker na filter -->
        </div>
        <button
          @click.prevent="exportToPDF"
          class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-600 rounded-lg hover:bg-gray-600">

          Generate Report
        </button>
      </div>

      <!-- Batch Table -->
      <div class="overflow-x-auto">
        <div v-if="batches.length === 0" class="py-8 text-center text-gray-500">
            No products yet
        </div>
        <table class="min-w-full text-sm font-light text-left text-gray-700">
          <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
              <th class="px-6 py-4">Date</th>
              <th class="px-6 py-4">Batch Number</th>
              <th class="px-6 py-4">Product Name</th>
              <th class="px-6 py-4">Quantity</th>
              <th class="px-6 py-4">Production Date</th>
              <th class="px-6 py-4">Expiry Date</th>
              <th class="px-6 py-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="batch in paginatedBatches" :key="batch.id" class="border-b hover:bg-neutral-100">
              <td class="px-6 py-3">{{ formatDate(batch.created_at) || 'No date available' }}</td>
              <td class="px-6 py-3">{{ batch.batch_number }}</td>
              <td class="px-6 py-3 capitalize">{{ batch.product_name }}</td>
              <td class="px-6 py-3">{{ batch.quantity }}</td>
              <td class="px-6 py-3">{{ formatDate(batch.production_date) || 'No production date' }}</td>
              <td class="px-6 py-3">{{ batch.expiry_date || 'No Expiry' }}</td>
              <td class="px-6 py-3 whitespace-nowrap">
                <button
                  id="apple-ipad-air-dropdown-button"
                  @click.stop="toggleDropdown(batch.id)"
                  class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover:bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                  type="button"
                >
                  <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                  </svg>
                </button>
                <!-- Dropdown Menu -->
                <div v-if="dropdownOpen === batch.id" class="absolute right-0 z-50 bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                  <ul class="py-1 text-sm" aria-labelledby="apple-ipad-air-dropdown-button">
                    <li>
                      <button
                        @click.stop="openEditModal(batch)"
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
                        @click.stop="openDeleteModal(batch)"
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
    <!-- Edit Stock Modal -->
    <EditBatch
      :isOpen="isEditModalOpen"
      :batch="selectedBatch"
      @close="closeEditModal"
      @update="updateBatch"
    />
    <!-- Delete Modal -->
  <DeleteBatch
    v-if="isDeleteModalOpen"
    :isOpen="isDeleteModalOpen"
    :batchNumber="batchToDelete?.id"
    title="Delete Batch"
    @close="closeDeleteModal"
    @confirm="confirmDeleteBatch"
  />
</DashboardLayout>
</template>
<script setup>
import { ref, defineProps, watch, computed } from 'vue';
import { Link, usePage } from "@inertiajs/inertia-vue3";
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import EditBatch from './EditBatch.vue';
import DeleteBatch from './DeleteBatch.vue';
import { Inertia } from '@inertiajs/inertia';
import route from 'ziggy-js';
import autoTable from "jspdf-autotable";
import { jsPDF } from "jspdf";

// Props Definition
const props = defineProps({
    categories: Array,
    message: String,
    message_type: String,
    batches: Array,
    products: Array,
    notifications: {
        type: Array,
        default: () => [], // Default to an empty array
    },
});

// State
const notifDropdownOpen = ref(false);
const currentPage = ref(1);
const itemsPerPage = ref(10);
const searchQuery = ref("");
const selectedCategories = ref([]);
const isCategoryDropdownOpen = ref(false);
const isCategoryDropdownOpen1 = ref ('');
const showNearExpiring = ref(false);
const daysThreshold = ref(30); // Days to consider near-expiring


// PDF Export Logic
const exportToPDF = (reportedBy = "Admin") => {
  const doc = new jsPDF();

  // Add logo
  const logo = new Image();
  logo.src = '/images/logo.png'; // Path to your logo image
  doc.addImage(logo, 'PNG', 30, 3, 25, 20); // Adjust logo position and size

  // Add header text
  doc.setFontSize(18);
  doc.setFont('Helvetica', 'bold');
  doc.setTextColor('#e74c3c'); // Hollywood red color
  doc.text("Hollywood Spectacles Optical", 105, 10, { align: "center" });

  doc.setFontSize(12);
  doc.setFont('Helvetica', 'normal');
  doc.setTextColor('#000'); // Black color for address and contact
  doc.text("Aguinaldo Street, Iligan City", 105, 15, { align: "center" });
  doc.text("Contact No: 091277747297", 105, 20, { align: "center" });

  // Draw a red line under the header
  doc.setDrawColor(231, 76, 60); // Red color
  doc.line(10, 25, 200, 25); // Line from (x1, y1) to (x2, y2)

  // Add centered title
  doc.setFontSize(16);
  doc.setFont('Helvetica', 'bold');
  doc.setTextColor('#e74c3c');
  const pageWidth = doc.internal.pageSize.getWidth();
  const titleText = "Batch List Report";
  const titleX = (pageWidth - doc.getTextWidth(titleText)) / 2;
  doc.text(titleText, titleX, 35);

  // Define table headers
  const headers = [
    ["Batch Number", "Product Name", "Quantity", "Production Date", "Expiry Date"],
  ];

  // Map the batch data into table rows
  const rows = filteredBatches.value.map((batch) => [
    batch.batch_number || "N/A",
    batch.product_name || "N/A",
    batch.quantity || 0,
    formatDate(batch.production_date) || "No production date",
    batch.expiry_date || "No Expiry",
  ]);

  // Add table to PDF and capture its final position
  let finalY; // Variable to track the final Y position of the table
  autoTable(doc, {
    head: headers,
    body: rows,
    margin: { top: 40 }, // Adjust margin to fit the header
    styles: {
      fontSize: 10,
      textColor: [0, 0, 0], // Black text for rows
      lineColor: [231, 76, 60], // Red border for rows
    },
    headStyles: {
      fillColor: [231, 76, 60], // Hollywood red for header background
      textColor: [255, 255, 255], // White text for headers
      fontStyle: 'bold',
    },
    alternateRowStyles: {
      fillColor: [245, 245, 245], // Light gray for alternate rows
    },
    bodyStyles: {
      fillColor: [255, 255, 255], // White background for main rows
      textColor: [0, 0, 0], // Black text for body rows
    },
    didDrawPage: (data) => {
      finalY = data.cursor.y; // Capture the Y position after the table is drawn
    },
  });

  // Add "Reported by" section below the table
  const padding = 25; // Space between table and "Reported by"
  const reportedByY = finalY + padding;

  doc.setFontSize(12);
  doc.setFont('Helvetica', 'italic');
  doc.setTextColor('#000'); // Black text
  doc.text(`Reported by: __________________`, 20, reportedByY); // Add "Reported by" below the table

  // Add footer
  const pageHeight = doc.internal.pageSize.height;
  doc.setFontSize(10);
  doc.setFont('Helvetica', 'normal');
  doc.setTextColor('#000');
  doc.text("Generated by Hollywood Spectacles Optical", 105, pageHeight - 20, { align: "center" });
  doc.text("© 2025 Hollywood Spectacles Optical. All rights reserved.", 105, pageHeight - 15, { align: "center" });

  // Add a border line for the footer
  doc.setDrawColor(231, 76, 60);
  doc.line(15, pageHeight - 25, 195, pageHeight - 25);

  // Save the PDF
  doc.save("Batch_List_Report.pdf");
};


// Notifications Dropdown Logic
const toggleNotifDropdown = () => {
    notifDropdownOpen.value = !notifDropdownOpen.value;
};
const closeNotifDropdown = () => {
    notifDropdownOpen.value = false;
};

const toggleCategoryDropdown = () => {
    isCategoryDropdownOpen1.value = !isCategoryDropdownOpen1.value;
};

//for dropdown modal add, edit, delete
const dropdownOpen = ref(null); // Store the id of the opened dropdown

const toggleDropdown = (itemId) => {
    dropdownOpen.value = dropdownOpen.value === itemId ? null : itemId; // Toggle dropdown visibility
};

const closeDropdown = () => {
    dropdownOpen.value = null;
};
// Watch for outside clicks to close the dropdown
document.addEventListener("click", (event) => {
    const notifDropdown = document.querySelector(".notif-dropdown");
    if (notifDropdown && !notifDropdown.contains(event.target)) {
        closeNotifDropdown();
    }
});

// Message State
const message = ref(props.message || '');
const messageType = ref(props.message_type || 'info');

// Clear message after 3 seconds
watch(message, (newMessage) => {
    if (newMessage) {
        setTimeout(() => {
            message.value = '';
            messageType.value = '';
        }, 3000);
    }
});

watch(selectedCategories, (newVal) => {
  console.log("Selected categories updated:", newVal);
});

const formatDate = (dateString) => {
  if (!dateString) return "N/A"; // Handle cases where the date is null or undefined

  const options = { year: 'numeric', month: 'long', day: 'numeric' }; // Example: January 1, 2025
  return new Date(dateString).toLocaleDateString(undefined, options);
};


// Filter Logic
const filteredBatches = computed(() => {
  // Start with all batches
  let filtered = props.batches;

  // Filter by search query (batch number or product name)
  if (searchQuery.value) {
    filtered = filtered.filter((batch) =>
      batch.product_name?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      batch.batch_number?.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  }

  // Filter by selected categories
  if (selectedCategories.value.length > 0) {
    filtered = filtered.filter((batch) =>
      selectedCategories.value.includes(batch.category_id)
    );
  }

  // Filter near-expiring
  if (showNearExpiring.value) {
    const now = new Date();
    const thresholdDate = new Date();
    thresholdDate.setDate(now.getDate() + daysThreshold.value);

    filtered = filtered.filter((batch) => {
      if (!batch.expiry_date) return false; // Exclude items without expiry dates
      const expiry = new Date(batch.expiry_date);
      return expiry >= now && expiry <= thresholdDate;
    });
  }

  return filtered;
});




// Computed property for total items
const totalItems = computed(() => filteredBatches.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage.value));
const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1);
const endItem = computed(() => Math.min(startItem.value + itemsPerPage.value - 1, totalItems.value));

// Computed property for pagination
const paginatedBatches = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return filteredBatches.value.slice(start, start + itemsPerPage.value).map((batches) => ({
    ...batches,

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

//for edit delete functions
// State for the modal
const isEditModalOpen = ref(false);

// Selected batch to edit
const selectedBatch = ref(null);

// Function to open the modal
const openEditModal = (batch) => {
  selectedBatch.value = batch; // Set the batch to be edited
  isEditModalOpen.value = true; // Open the modal
};

// Function to handle closing the modal
const closeEditModal = () => {
  isEditModalOpen.value = false;
  selectedBatch.value = null;
};

// Handle batch update
const updateBatch = (updatedBatch) => {
  Inertia.put(route('batches.update', updatedBatch.id), updatedBatch, {
    onSuccess: () => {
      console.log('Batch updated successfully!');
      closeEditModal();
    },
    onError: (errors) => {
      console.error('Failed to update batch:', errors);
    },
  });
};

const isDeleteModalOpen = ref(false);
const batchToDelete = ref(null);

const openDeleteModal = (batch) => {
  batchToDelete.value = batch;
  isDeleteModalOpen.value = true;
  dropdownOpen.value = false;
};

const closeDeleteModal = () => {
  isDeleteModalOpen.value = false;
};

const confirmDeleteBatch = () => {
  if (batchToDelete.value) {
    Inertia.delete(route('batches.delete', batchToDelete.value.id), {
      onSuccess: () => {
        isDeleteModalOpen.value = false; // Close modal on success
        alert('Batch deleted successfully!');
      },
      onError: (errors) => {
        console.error('Error deleting batch:', errors); // Log errors if any
      },
    });
  }
};
</script>
