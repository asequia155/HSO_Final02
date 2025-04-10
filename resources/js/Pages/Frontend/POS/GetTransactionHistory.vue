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

  <transition name="alert-fade">
    <div v-if="message && messageType === 'error'" class="flex items-center px-4 py-3 mb-4 bg-red-100 border-t-4 border-red-700 shadow-md">
      <div class="flex items-center">
        <!-- Checkmark Icon -->
        <svg class="w-6 h-6 text-red-700" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="red"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
			<g id="SVGRepo_iconCarrier"> <path d="M2.20164 18.4695L10.1643 4.00506C10.9021 2.66498 13.0979 2.66498 13.8357 4.00506L21.7984 18.4695C22.4443 19.6428 21.4598 21 19.9627 21H4.0373C2.54022 21 1.55571 19.6428 2.20164 18.4695Z"
				stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 9V13" stroke="#000000"
				stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
			<path d="M12 17.0195V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			</path> </g>
		</svg>
        <!-- Alert Text -->
        <span class="ml-2 font-medium text-red-700">{{ message }}</span>
      </div>
    </div>
  </transition>

	<div class="p-4 mb-6 bg-white rounded-lg shadow-md">
		<div class="flex items-center justify-between">
				<!-- Breadcrumbs and Title -->
				<div>
					<nav class="flex" aria-label="Breadcrumb">
						<ol class="inline-flex items-center space-x-1 md:space-x-3">
							<!-- Home Icon and Link -->
							<li>
								<div class="flex items-center space-x-1">
									<a href="/dashboard" class="inline-flex items-center text-sm font-medium text-blue-600 group hover:text-blue-700">
										<svg class="w-5 h-5 mr-1 text-gray-500 group-hover:text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

									<a href="products" class="inline-flex items-center text-sm font-medium text-red-600">
										Transaction
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="mt-2 text-xl font-semibold text-gray-900">Transaction History</h1>
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
                    <!-- Name Search -->
                        <div class="flex items-center space-x-2">
                            <label for="nameSearch" class="text-sm font-medium text-gray-700">Search Name:</label>
                            <input
                            type="text"
                            id="nameSearch"
                            v-model="filters.nameQuery"
                            placeholder="Search by name"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                            />
                        </div>

						<div class="flex items-center space-x-2">
							<label for="startDate" class="text-sm font-medium text-gray-700">Start:</label>
							<input
								type="date"
								id="startDate"
								v-model="filters.startDate"
								class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
							/>
						</div>
						<div class="flex items-center space-x-2">
							<label for="endDate" class="text-sm font-medium text-gray-700">End:</label>
							<input
								type="date"
								id="endDate"
								v-model="filters.endDate"
								class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
							/>
						</div>
					</div>
				<!-- Buttons -->
				<div class="flex items-center space-x-3">
					<!-- Icon Buttons -->


					<!-- Generate Report -->
					<div class="relative">
						<button  @click.prevent="generateTotalSalesReport" class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-600 rounded-lg hover:bg-gray-600">
							Generate Report
						</button>
					</div>
				</div>
			</div>

            <div class="overflow-x-auto">
    <table class="min-w-full text-sm font-light text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th class="px-6 py-4">Date</th>
                <th class="px-6 py-4">Items</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="transaction in paginatedTransactions"
                :key="transaction.id"
                class="transition border-b cursor-pointer border-neutral-200 hover:bg-neutral-100"
                @click="showTransactionDetails(transaction)"
            >
                <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(transaction.created_at) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <ul>
                        <li
                            v-for="(item, index) in transaction.items"
                            :key="index"
                        >
                            {{ item.product.name }} (x{{ item.quantity }}) - ₱ {{ formatCurrency(item.price) }}
                        </li>
                        <li v-if="!transaction.items || transaction.items.length === 0">
                            No items in transaction
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Modal -->
    <div
    v-if="modalVisible"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75"
>
    <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
        <!-- Close Button at the top-right -->
        <button
            @click="modalVisible = false"
            class="absolute p-2 text-2xl text-gray-500 transition duration-200 top-2 right-2 hover:text-gray-800"
        >
            &times;
        </button>
        <h2 class="mb-4 text-xl font-semibold">Transaction Details</h2>
        <hr class="mb-4 border-t border-gray-300">

        <!-- Transaction Details -->
        <div class="mb-2">
            <p><strong>Date:</strong> <span class="text-gray-700">{{ formatDate(selectedTransaction.created_at) }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Customer:</strong> <span class="text-gray-700">{{ selectedTransaction.customer_name }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Tax:</strong> <span class="text-gray-700">₱ {{ formatCurrency(selectedTransaction.tax_amount) }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Discount:</strong> <span class="text-gray-700">₱ {{ formatCurrency(selectedTransaction.discount_amount) }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Total:</strong> <span class="text-gray-700">₱ {{ formatCurrency(selectedTransaction.total_amount) }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Items:</strong></p>
            <ul class="pl-5 list-disc">
                <li
                    v-for="(item, index) in selectedTransaction.items"
                    :key="index"
                    class="text-gray-700"
                >
                    {{ item.product.name }} (x{{ item.quantity }}) - ₱ {{ formatCurrency(item.price) }}
                </li>
                <li v-if="!selectedTransaction.items || selectedTransaction.items.length === 0">
                    No items in transaction
                </li>
            </ul>
        </div>

        <!-- Close Button under the Description -->
        <div class="mt-4 text-right">
            <button
                @click="modalVisible = false"
                class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-600 rounded-lg hover:bg-gray-600"
            >
                Close
            </button>
        </div>
    </div>
</div><div
    v-if="modalVisible"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75"
>
    <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
        <!-- Close Button at the top-right -->
        <button
            @click="modalVisible = false"
            class="absolute p-2 text-2xl text-gray-500 transition duration-200 top-2 right-2 hover:text-gray-800"
        >
            &times;
        </button>
        <h2 class="mb-4 text-xl font-semibold">Transaction Details</h2>
        <hr class="mb-4 border-t border-gray-300">

        <!-- Transaction Details -->
        <div class="mb-2">
            <p><strong>Date:</strong> <span class="text-gray-700">{{ formatDate(selectedTransaction.created_at) }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Customer:</strong> <span class="text-gray-700">{{ selectedTransaction.customer_name }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Processed By:</strong> <span class="text-gray-700">{{ selectedTransaction.user?.name || 'Unknown' }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Tax:</strong> <span class="text-gray-700">₱ {{ formatCurrency(selectedTransaction.tax_amount) }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Discount:</strong> <span class="text-gray-700">₱ {{ formatCurrency(selectedTransaction.discount_amount) }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Total:</strong> <span class="text-gray-700">₱ {{ formatCurrency(selectedTransaction.total_amount) }}</span></p>
        </div>
        <div class="mb-2">
            <p><strong>Items:</strong></p>
            <ul class="pl-5 list-disc">
                <li
                    v-for="(item, index) in selectedTransaction.items"
                    :key="index"
                    class="text-gray-700"
                >
                    {{ item.product.name }} (x{{ item.quantity }}) - ₱ {{ formatCurrency(item.price) }}
                </li>
                <li v-if="!selectedTransaction.items || selectedTransaction.items.length === 0">
                    No items in transaction
                </li>
            </ul>
        </div>

        <!-- Close Button under the Description -->
        <div class="mt-4 text-right">
            <button
                @click="modalVisible = false"
                class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-600 rounded-lg hover:bg-gray-600"
            >
                Close
            </button>
        </div>
    </div>
</div>


</div>



			  <!-- Pagination -->
              <div class="flex flex-col items-center justify-between p-4 border-t md:flex-row border-neutral-200">
        <span class="text-sm font-normal text-gray-500">
          Showing <span class="font-semibold">{{ startItem }}</span> - <span class="font-semibold">{{ endItem }}</span> of <span class="font-semibold">{{ totalItems }}</span>
        </span>
        <ul class="inline-flex items-stretch mt-2 -space-x-px md:mt-0">
          <li>
            <button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1.5 border rounded-l-lg">Prev</button>
          </li>
          <li v-if="currentPage > 3">
            <button @click="changePage(1)" class="px-3 py-1.5 border bg-white">1</button>
            <span class="px-2 py-1.5">...</span>
          </li>
          <li
            v-for="page in visiblePages"
            :key="page"
            class="px-3 py-1.5 border"
            :class="{ 'bg-gray-300': page === currentPage }"
          >
            <button @click="changePage(page)">{{ page }}</button>
          </li>
          <li v-if="currentPage < totalPages - 2">
            <span class="px-2 py-1.5">...</span>
            <button @click="changePage(totalPages)" class="px-3 py-1.5 border bg-white">{{ totalPages }}</button>
          </li>
          <li>
            <button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1.5 border rounded-r-lg">Next</button>
          </li>
        </ul>
      </div>
    </div>
</DashboardLayout>
</template>

<script setup>
	import { ref, computed, onMounted, watch, onBeforeUnmount } from 'vue';
	import DashboardLayout from '@/Layouts/DashboardLayout.vue';
	import Dropdown from '@/Components/Dropdown.vue';
	import DropdownLink from '@/Components/DropdownLink.vue';
	import debounce from 'lodash/debounce';
	import DatePicker from '@/Components/DatePicker.vue';
  import { Link, usePage } from "@inertiajs/inertia-vue3";
  import { jsPDF } from "jspdf";
	import autoTable from "jspdf-autotable";



	const props = defineProps({
		transactions: Array, // Received from the backend
		message: String,
		message_type: String,
    bestSellingProducts: Array,
    notifications: {
    		type: Array,
    		default: () => [], // Default to an empty array
  	},
	});
console.log(props.bestSellingProducts);
    // State for dropdown visibility and notifications list
	const notifDropdownOpen = ref(false);

  // Toggle the dropdown visibility
  const toggleNotifDropdown = () => {
    notifDropdownOpen.value = !notifDropdownOpen.value;
  };

		const message = ref(props.message || '');
		const messageType = ref(props.message_type || 'info');
		console.log(props.message);   // Log message content
		console.log(props.message_type); // Log message type

		watch([message, messageType], () => {
    if (message.value) {
        setTimeout(() => {
            message.value = '';
            messageType.value = '';
        }, 3000);
    }
});


	// Date range filter state
	const filters = ref({
		startDate: '',
		endDate: '',
	});

	// Toggle for the report dropdown
	const showReportDropdown = ref(false);

	// Function to handle clicks outside of dropdown to close it
	const handleClickOutside = (event) => {
		if (!event.target.closest('.relative')) {
			showReportDropdown.value = false;
		}
	};

	watch(filters, debounce(() => {
  		currentPage.value = 1; // Reset page to 1 on filter change
	}, 300), { deep: true });

	onMounted(() => {
		window.addEventListener('click', handleClickOutside);
	});

	onBeforeUnmount(() => {
  window.removeEventListener('click', handleClickOutside);
});

// Generate a PDF report for total sales
// Generate a PDF report for total sales
const generateTotalSalesReport = () => {
    // Check if both start and end dates are provided
    if (!filters.value.startDate || !filters.value.endDate) {
        message.value = 'Please specify both start and end dates to generate the report!';
        messageType.value = 'error';
        return;
    }

    // Get filtered transactions based on the date range
    const filteredData = filteredTransactions.value;

    // Initialize totals
    let totalSales = 0;
    let totalTax = 0;
    let totalDiscount = 0;

    // Calculate total sales, total tax, and total discount from filtered transactions
    filteredData.forEach(transaction => {
        totalSales += parseFloat(transaction.total) || 0; // Total sales
        totalTax += parseFloat(transaction.tax) || 0; // Total tax
        totalDiscount += parseFloat(transaction.discount_amount) || 0; // Total discount
    });

    // Generate PDF
    const doc = new jsPDF();

    // Add Logo and Header
    const logo = new Image();
    logo.src = '/images/logo.png';
    doc.addImage(logo, 'PNG', 30, 3, 25, 20);

    doc.setFontSize(18);
    doc.setFont('Helvetica', 'bold');
    doc.setTextColor('#e74c3c');
    doc.text("Hollywood Spectacles Optical", 105, 10, { align: "center" });

    doc.setFontSize(12);
    doc.setFont('Roboto', 'normal');
    doc.setTextColor('#000');
    doc.text("Aguinaldo Street, Iligan City", 105, 15, { align: "center" });
    doc.text("Contact No: 091277747297", 105, 20, { align: "center" });

    doc.setDrawColor(231, 76, 60);
    doc.line(10, 25, 200, 25);

    // PDF Styling
    const red = "#ff0000";
    const white = "#ffffff";

    doc.setTextColor(red);
    doc.setFontSize(16);
    doc.text("Total Sales Summary", doc.internal.pageSize.getWidth() / 2, 37, { align: "center" });

    // Add Date Range
    doc.setFont('Helvetica', 'bold');
    doc.setFontSize(12);
    doc.text("Dr. Dializa O. Remedios", 15, 45);
    doc.setFont('Roboto', 'normal');
    doc.text(`Report Period: ${new Date(filters.value.startDate).toLocaleDateString()} - ${new Date(filters.value.endDate).toLocaleDateString()}`, 15, 52);

    // Add Table Header for Summary
    const tableHeaders = ["Description", "Amount"];
    const tableRows = [
        ["Total Sales", totalSales.toFixed(2)],
        ["Total Tax", totalTax.toFixed(2)],
        ["Total Discount", totalDiscount.toFixed(2)]
    ];

    doc.setFontSize(14);
    doc.autoTable({
        head: [tableHeaders],
        body: tableRows,
        startY: 70,
        headStyles: { fillColor: red, textColor: white },
        bodyStyles: { textColor: "#000000" },
        alternateRowStyles: { fillColor: "#f2f2f2" },
        theme: 'grid'
    });

    // Add Best-Selling Products
    const productHeaders = ["Product Name", "Quantity Sold"];
    const productRows = props.bestSellingProducts.map(product => [
        product.name,
        product.total_sales,
        product.total_quantity,
    ]);

    doc.setFontSize(14);
    doc.text("Best-Selling Products", 15, doc.lastAutoTable.finalY + 10);
    doc.autoTable({
        head: [productHeaders],
        body: productRows,
        startY: doc.lastAutoTable.finalY + 15,
        headStyles: { fillColor: "#4CAF50", textColor: white },
        bodyStyles: { textColor: "#000000" },
        alternateRowStyles: { fillColor: "#f2f2f2" },
        theme: 'grid'
    });

    // Add Footer
    const pageHeight = doc.internal.pageSize.height;
    doc.setFontSize(10);
    doc.setFont('Helvetica', 'normal');
    doc.setTextColor('#000');
    doc.text("Generated by Hollywood Spectacles Optical", 105, pageHeight - 10, { align: "center" });
    doc.text("© 2025 Hollywood Spectacles Optical. All rights reserved.", 105, pageHeight - 5, { align: "center" });

    // Add a border line
    doc.setDrawColor(231, 76, 60);
    doc.line(15, pageHeight - 15, 195, pageHeight - 15);

    // Save the PDF
    doc.save('Total_Sales_Summary.pdf');
};





	// Function to parse the cart_items JSON string into an array of objects
	const parseCartItems = (cartItems) => {
		try {
			return JSON.parse(cartItems);
		} catch (e) {
			console.error('Error parsing cart_items:', e);
			return [];
		}
	};

	// Format a date to a readable string
	const formatDate = (date) => {
		const options = { year: 'numeric', month: 'long', day: 'numeric' };
		return new Date(date).toLocaleDateString(undefined, options);
	};

	// Format a number as currency
	const formatCurrency = (value) => {
		const numValue = parseFloat(value);
		if (isNaN(numValue)) {
			return '0.00';
		}
		return numValue.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
	};

	// Computed property to filter transactions based on the date range
	const filteredTransactions = computed(() => {
		if (!filters.value.startDate || !filters.value.endDate) {
			return props.transactions; // Show all transactions if no date range is set
		}

		const start = new Date(filters.value.startDate).setHours(0, 0, 0, 0);
		const end = new Date(filters.value.endDate).setHours(23, 59, 59, 999);

		return props.transactions.filter((transaction) => {
			const transactionDate = new Date(transaction.created_at).getTime();
			return transactionDate >= start && transactionDate <= end;
		});
	});


	// Function to export table data to Excel
// Function to export table data to Excel
// const exportToExcel = () => {
//     const headers = ['Date', 'Customer Name', 'Tax', 'Discount', 'Total', 'Cart Items']; // Add "Tax" and reorder as per your table

//     const data = filteredTransactions.value.map((transaction) => {
//         // Parse cart items and convert them to a readable format
//         const cartItems = parseCartItems(transaction.cart_items)
//             .map(item => `${item.product_name} (x${item.quantity}) - ₱${formatCurrency(item.price)}`)
//             .join('\n');

//         return [
//             formatDate(transaction.created_at),
//             transaction.customer_name,
//             formatCurrency(transaction.tax), // Add tax field
//             formatCurrency(transaction.discount_amount),
//             formatCurrency(transaction.total),
//             cartItems
//         ];
//     });

//     const worksheet = utils.aoa_to_sheet([headers, ...data]);
//     const workbook = utils.book_new();
//     utils.book_append_sheet(workbook, worksheet, 'Transaction History');
//     writeFile(workbook, 'Transaction_History.xlsx');
// };

// Modal state
const modalVisible = ref(false);
const selectedTransaction = ref({});


// Show transaction details in modal
const showTransactionDetails = (transaction) => {
    selectedTransaction.value = transaction;
    modalVisible.value = true;
};


	// Pagination
	const itemsPerPage = 5;
	const currentPage = ref(1);
	// Pagination
const totalItems = computed(() => filteredTransactions.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));
const startItem = computed(() => (currentPage.value - 1) * itemsPerPage + 1);
const endItem = computed(() => Math.min(currentPage.value * itemsPerPage, totalItems.value));
const paginatedTransactions = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredTransactions.value.slice(start, start + itemsPerPage);
});

// Visible Pages Logic
const visiblePages = computed(() => {
  const pages = [];
  const range = 2; // Number of pages to show before and after the current page
  const start = Math.max(1, currentPage.value - range);
  const end = Math.min(totalPages.value, currentPage.value + range);

  for (let i = start; i <= end; i++) {
    pages.push(i);
  }
  return pages;
});

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};

const changePage = page => {
  currentPage.value = page;
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
