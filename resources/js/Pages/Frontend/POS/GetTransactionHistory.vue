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

		      <div class="bg-white shadow-md rounded-lg p-4 mb-6">
			<div class="flex justify-between items-center">
				<!-- Breadcrumbs and Title -->
				<div>
					<nav class="flex" aria-label="Breadcrumb">
						<ol class="inline-flex items-center space-x-1 md:space-x-3">
							<!-- Home Icon and Link -->
							<li>
								<div class="flex items-center space-x-1">
									<a href="/rawboard" class="inline-flex items-center group text-blue-600 hover:text-blue-700 text-sm font-medium">
										<svg class="w-5 h-5 text-gray-500 mr-1 group-hover:text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

									<a href="products" class="inline-flex items-center text-red-600 text-sm font-medium">
										Transaction
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="text-xl font-semibold text-gray-900 mt-2">Transaction History</h1>
				</div>
        <div class="flex items-center space-x-3">
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black bg-transparent focus:outline-none transition ease-in-out duration-150"
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

		<div class="bg-white rounded-lg shadow-lg overflow-visible relative">
			<div class="flex items-center p-4 border-b border-neutral-200 justify-between w-full">
				<div class="flex items-center space-x-4">
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
					<button @click="exportToExcel" class="flex items-center justify-center w-9 h-9 rounded-full bg-yellow-100 hover:bg-yellow-200" title="Print">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9v10h12V9M6 5h12v4H6z" />
						</svg>
					</button>
					<button class="flex items-center justify-center w-9 h-9 rounded-full bg-purple-100 hover:bg-purple-200" title="Export">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
						</svg>
					</button>
					<!-- Generate Report -->
					<div class="relative">
						<button @click="toggleReportDropdown" class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition duration-300">
							Generate Report
						</button>
						<div v-show="showReportDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
							<ul class="py-2">
								<li>
									<a href="#" @click.prevent="generateTotalSalesReport" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Total Sales</a>
								</li>
								<li>
									<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Total Discount</a>
								</li>
								<li>
									<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Total Tax</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="overflow-x-auto">
					<table class="min-w-full text-left text-sm font-light text-gray-700">
						<thead class="text-xs text-gray-700 uppercase bg-gray-200">
							<tr>
								<th class="px-6 py-4">Date</th>
								<th class="px-6 py-4">Customer Name</th>
								<th class="px-6 py-4">Total</th>
								<th class="px-6 py-4">Discount</th>
								<th class="px-6 py-4">Cart Items</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="transaction in paginatedTransactions" :key="transaction.id" class="border-b border-neutral-200 transition hover:bg-neutral-100">
								<td class="whitespace-nowrap px-6 py-4">{{ formatDate(transaction.created_at) }}</td>
								<td class="whitespace-nowrap px-6 py-4">{{ transaction.customer_name }}</td>
								<td class="whitespace-nowrap px-6 py-4">₱ {{ formatCurrency(transaction.total) }}</td>
								<td class="whitespace-nowrap px-6 py-4">{{ formatCurrency(transaction.discount_amount) }}</td>
								<td class="whitespace-nowrap px-6 py-4">
									<ul>
										<li v-for="(item, index) in parseCartItems(transaction.cart_items)" :key="index">
											{{ item.product_name }} (x{{ item.quantity }}) - ₱ {{ formatCurrency(item.price) }}
										</li>
										<li v-if="!transaction.cart_items || parseCartItems(transaction.cart_items).length === 0">
											No items in cart
										</li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
			</div>


			<!-- Pagination -->
		<div class="flex flex-col md:flex-row justify-between items-center p-4 border-t border-neutral-200 relative z-10">
				<span class="text-sm font-normal text-gray-500"> Showing <span class="font-semibold">{{ startItem }}</span> - <span class="font-semibold">{{ endItem }}</span> of <span class="font-semibold">{{ totalItems }}</span> </span>
				<ul class="inline-flex items-stretch -space-x-px mt-2 md:mt-0">
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
</DashboardLayout>
</template>

<script setup>
	import { ref, computed, onMounted, watch, onBeforeUnmount } from 'vue';
	import DashboardLayout from '@/Layouts/DashboardLayout.vue';
	import Dropdown from '@/Components/Dropdown.vue';
	import DropdownLink from '@/Components/DropdownLink.vue';
	import { utils, writeFile } from 'xlsx';
	import debounce from 'lodash/debounce';
	import { jsPDF } from "jspdf";
	import DatePicker from '@/Components/DatePicker.vue';

	const props = defineProps({
		transactions: Array, // Received from the backend
		message: String,
		message_type: String,
	});

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

	// Function to toggle the report dropdown
	const toggleReportDropdown = () => {
		showReportDropdown.value = !showReportDropdown.value;
	};

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
	const generateTotalSalesReport = () => {
    if (!filters.value.startDate || !filters.value.endDate) {
        message.value = 'Please specify both start and end dates to generate the report!';
        messageType.value = 'error';
        return;
    }

    const filteredData = filteredTransactions.value;
    let totalSales = 0;

    filteredData.forEach(transaction => {
        totalSales += parseFloat(transaction.total);
    });

    const doc = new jsPDF();
    doc.text("Total Sales Report", 10, 10);
    doc.text(`Date Range: ${filters.value.startDate || 'N/A'} to ${filters.value.endDate || 'N/A'}`, 10, 20);
    doc.text(`Total Sales: ₱ ${totalSales.toFixed(2)}`, 10, 30);

    doc.save("Total_Sales_Report.pdf");
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

		const start = new Date(filters.value.startDate).getTime();
		const end = new Date(filters.value.endDate).getTime();

		return props.transactions.filter((transaction) => {
			const transactionDate = new Date(transaction.created_at).getTime();
			return transactionDate >= start && transactionDate <= end;
		});
	});

	// Function to export table data to Excel
// Function to export table data to Excel
const exportToExcel = () => {
    const headers = ['Date', 'Customer Name', 'Total', 'Discount', 'Cart Items'];

    const data = filteredTransactions.value.map((transaction) => {
        // Parse cart items and convert them to a readable format
        const cartItems = parseCartItems(transaction.cart_items)
            .map(item => `${item.product_name} (x${item.quantity}) - ₱${formatCurrency(item.price)}`)
            .join('\n');

        return [
            formatDate(transaction.created_at),
            transaction.customer_name,
            formatCurrency(transaction.total),
            formatCurrency(transaction.discount_amount),
            cartItems
        ];
    });

    const worksheet = utils.aoa_to_sheet([headers, ...data]);
    
    // Get the range of the worksheet
    const range = utils.decode_range(worksheet['!ref']);

    // Set wrapText for all cells in the "Cart Items" column (the last column)
    for (let row = range.s.r; row <= range.e.r; row++) {
        const cellAddress = utils.encode_cell({ r: row, c: headers.length - 1 }); // Last column index is headers.length - 1
        if (!worksheet[cellAddress]) continue; // Skip if cell does not exist

        // Apply wrapText style
        worksheet[cellAddress].s = {
            alignment: {
                wrapText: true, // Enable wrapping text for cells
            },
        };
    }

    const workbook = utils.book_new();
    utils.book_append_sheet(workbook, worksheet, 'Transaction History');
    writeFile(workbook, 'Transaction_History.xlsx');
};



	// Pagination
	const itemsPerPage = 5;
	const currentPage = ref(1);
	const totalItems = computed(() => filteredTransactions.value.length);
	const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));
	const startItem = computed(() => (currentPage.value - 1) * itemsPerPage + 1);
	const endItem = computed(() => Math.min(currentPage.value * itemsPerPage, totalItems.value));

	const paginatedTransactions = computed(() => {
		const start = (currentPage.value - 1) * itemsPerPage;
		const end = start + itemsPerPage;
		return filteredTransactions.value.slice(start, end);
	});

	const prevPage = () => {
		if (currentPage.value > 1) currentPage.value--;
	};

	const nextPage = () => {
		if (currentPage.value < totalPages.value) currentPage.value++;
	};

	const changePage = (page) => {
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