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

									<a href="products" class="inline-flex items-center text-sm font-medium text-red-600">
										Point-of-sale
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="mt-2 text-xl font-semibold text-gray-900">Point Of Sale</h1>
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

      <div>
        <!-- Display Success Message -->
        <div class="flex">
          <div class="bg-white rounded-lg shadow-lg overflow-hidden w-[65%] max-h-[550px] flex flex-col">
            <div class="flex items-center p-4 border-b border-neutral-200">
              <div class="flex items-center">
						<form class="flex items-center w-full">
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
									placeholder="Search Products..."
									class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                  @input="debouncedSearch(searchQuery)"
                  ref="searchRef"
                  />
							</div>
						</form>
					</div>
          <label for="category-filter" class="ml-4 mr-2 font-medium"></label>
            <select
              id="category-filter"
              v-model="selectedCategory"
              @click="toggleDropdown"
              @change="filterByCategory"
              class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              style="width: 16rem;"
              ref="dropdownRef"
            >
              <option class="text-gray-900 bg-white hover:bg-red-100 dark:bg-gray-700 dark:hover:bg-red-800 dark:text-white" value="">
                All Categories
              </option>
              <option
                v-for="category in props.categories"
                :key="category.id"
                :value="category.id"
                class="text-gray-900 bg-white hover:bg-red-100 dark:bg-gray-700 dark:hover:bg-red-800 dark:text-white"
              >
                {{ category.name }}
              </option>
            </select>
          </div>

            <!-- Conditional rendering for "No products to show" -->
            <div class="flex-grow overflow-x-auto">
              <div v-if="paginatedProducts.length === 0" class="py-8 text-center text-gray-500">
                No products to show
              </div>

              <table v-else class="min-w-full text-sm font-light text-left text-gray-700">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                  <tr>
                    <th scope="col" class="px-6 py-4">Product code</th>
                    <th scope="col" class="px-6 py-4">Name</th>
                    <th scope="col" class="px-6 py-4">Category</th>
                    <th scope="col" class="px-6 py-4">Price</th>
                    <th scope="col" class="px-6 py-4">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in paginatedProducts" :key="item.id" class="transition border-b border-neutral-200 hover:bg-neutral-100" >
                    <td class="px-6 py-4 whitespace-nowrap">{{ item.product_code }}</td>
                    <td class="px-6 py-4 capitalize whitespace-nowrap">{{ item.name }}</td>
                    <td class="px-6 py-4 capitalize whitespace-nowrap">{{ categoryMap[item.category_id] || 'Uncategorized' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap"><a>₱ </a>{{ formatPrice(item.price) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <button @click="addToCart(item)" class="flex items-center px-4 py-2 space-x-2 font-semibold text-white transition duration-300 bg-red-600 rounded-lg shadow-lg hover:bg-gray-600" aria-label="Add to cart">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l3.2-7H6.4M7 13l-2 5h13M13 16h6m-6 3h2m-2 0a1 1 0 01-1-1m1 1a1 1 0 001 1m-1-4h-2m0 0a1 1 0 00-1 1m1-1a1 1 0 001 1"
                          />
                        </svg>
                        <span>Add</span>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

              <!-- Pagination (pushed to bottom) -->
            <div class="relative z-10 flex flex-col items-center justify-between p-4 mt-auto border-t md:flex-row border-neutral-200">
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
                <li>
                  <button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1.5 border rounded-r-lg">Next</button>
                </li>
              </ul>
            </div>
          </div>
          <!-- Cart Summary Section -->
          <div class="w-[35%] p-6 bg-white shadow-md rounded-lg ml-4">
            <CartSummary :cartItems="cartItems" @updateQuantity="handleUpdateQuantity" @processPayment="handlePaymentProcessing" @remove="handleRemove" />
            <TransactionModal :isOpen="isModalOpen" :products="products" :transaction="paymentData" @confirm="confirmInvoice" @close="closeModal" />
          </div>
        </div>
      </div>
    </DashboardLayout>
  </template>

  <script setup>
    import CartSummary from './CartSummary.vue';
    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import { ref, computed, defineProps, watch } from 'vue';
    import { onMounted, onBeforeUnmount } from 'vue';
    import debounce from 'lodash/debounce';
    import TransactionModal from './TransactionModal.vue';
    import { Inertia } from '@inertiajs/inertia';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
    import { Link, usePage } from "@inertiajs/inertia-vue3";


    const props = defineProps({
        products: Array,
        categories: Array,
        message: String,
        message_type: String,
        notifications: {
          type: Array,
          default: () => [], // Default to an empty array
        },
    });

  // State for dropdown visibility and notifications list
	const notifDropdownOpen = ref(false);

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

  const isModalOpen = ref(false);
    const searchQuery = ref('');
    const currentPage = ref(1);
    const itemsPerPage = ref(5);
    const selectedCategory = ref(''); // Empty string for "All Categories"
    const isDropdownOpen = ref(false);
    const cartItems = ref([]);
    const dropdownRef = ref(null);
    const searchRef = ref(null);

    // Debounced Search
    const debouncedSearch = debounce((value) => {
      searchQuery.value = value;
    }, 500);

    // Computed property for filtering products by search
    const filteredProducts = computed(() => {
      return props.products.filter(product => {
        const matchesSearch =
          product.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
          product.product_code.toLowerCase().includes(searchQuery.value.toLowerCase()); // Check product_code as well

        const matchesCategory =
          selectedCategory.value === '' || product.category_id === selectedCategory.value;

        const hasStock = product.quantity > 0; // Ensure the product has stock

        return matchesSearch && matchesCategory && hasStock;
      });
    });


// Computed properties for pagination
const totalItems = computed(() => filteredProducts.value.length);
const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1);
const endItem = computed(() => Math.min(startItem.value + itemsPerPage.value - 1, totalItems.value));

const paginatedProducts = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return filteredProducts.value.slice(start, start + itemsPerPage.value);
});

const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage.value));

// Dynamic visible page numbers
const visiblePages = computed(() => {
  const range = 5; // Number of visible page links
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

// Pagination navigation methods
const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

const changePage = (page) => {
  currentPage.value = page;
};

    // Category Mapping
    const categoryMap = computed(() => {
      const map = {};
      props.categories.forEach(category => {
        map[category.id] = category.name;
      });
      return map;
    });

    // Dropdown toggle
    const toggleDropdown = () => {
      isDropdownOpen.value = !isDropdownOpen.value;
    };

    // Close dropdown if click is outside
    const closeDropdown = (event) => {
      if (dropdownRef.value && !dropdownRef.value.contains(event.target) &&
          searchRef.value && !searchRef.value.contains(event.target)) {
        isDropdownOpen.value = false;
      }
    };

    onMounted(() => {
      document.addEventListener('click', closeDropdown);
    });

    onBeforeUnmount(() => {
      document.removeEventListener('click', closeDropdown);
    });

    const addToCart = (product) => {
  const existingItem = cartItems.value.find(item => item.id === product.id);
  if (existingItem) {
    if (existingItem.userQuantity < existingItem.quantity) {
      // Increase user quantity only if it's less than stock
      existingItem.userQuantity++;
    } else {
      alert('Cannot add more than available stock!');
    }
  } else {
    // Add product with userQuantity initialized to 1
    cartItems.value.push({ ...product, userQuantity: 1 });
  }
};

const handleUpdateQuantity = (itemId, userQuantity) => {
  const item = cartItems.value.find((i) => i.id === itemId);
  if (item) {
    item.userQuantity = userQuantity; // Update userQuantity in the cart
  }
};

  const handleRemove = (itemId) => {
    cartItems.value = cartItems.value.filter((item) => item.id !== itemId);
  };

  const paymentData = ref({});  // Store the payment data

  const handlePaymentProcessing = (data) => {
    console.log('Transaction data:', data);
    console.log(data.transaction_items); // Ensure items exist
    console.log(data.patient_id);        // Ensure patient ID is included if applicable

    paymentData.value = data;
    isModalOpen.value = true;
};

// Handle the confirm event from the TransactionModal
const confirmInvoice = (transaction) => {
  console.log('Invoice confirmed!');
  Inertia.post(route('pos.store'), transaction, {
    onSuccess: () => {
      console.log('Transaction saved successfully!');
      cartItems.value = [];  // Clear cart after sending payment data
    },
    onError: (error) => {
      console.error("Payment processing error:", error);
    },
  });

  closeModal();
};
  watch([searchQuery, selectedCategory], () => {
    currentPage.value = 1;  // Reset to the first page when filters change
  });


  const closeModal = () => {
    isModalOpen.value = false;
  };

// Function to format price with commas and two decimal places
const formatPrice = (price) => {
  return new Intl.NumberFormat('en-US', {
    style: 'decimal',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(price);
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
