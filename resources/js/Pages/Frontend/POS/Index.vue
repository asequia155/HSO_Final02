  <template>
    <DashboardLayout>
		<!-- Alert -->
    <transition name="alert-fade">
    <div v-if="message && messageType === 'success'" class="flex items-center border-t-4 border-green-700 bg-green-100 px-4 py-3 shadow-md mb-4">
      <div class="flex items-center">
        <!-- Checkmark Icon -->
        <svg class="h-6 w-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <!-- Alert Text -->
        <span class="ml-2 font-medium text-green-700">{{ message }}</span>
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
									<a href="/rawboard" class="inline-flex items-center group text-red-600 hover:text-red-600 text-sm font-medium">
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

									<a href="products" class="inline-flex items-center text-red-600 text-sm font-medium">
										Point-of-sale
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="text-xl font-semibold text-gray-900 mt-2">Point Of Sale</h1>
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
									class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
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
  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
  style="width: 16rem;"
  ref="dropdownRef"
>
  <option class="bg-white hover:bg-red-100 dark:bg-gray-700 dark:hover:bg-red-800 text-gray-900 dark:text-white" value="">
    All Categories
  </option>
  <option 
    v-for="category in props.categories" 
    :key="category.id" 
    :value="category.id"
    class="bg-white hover:bg-red-100 dark:bg-gray-700 dark:hover:bg-red-800 text-gray-900 dark:text-white"
  >
    {{ category.name }}
  </option>
</select>

            </div>

            <!-- Conditional rendering for "No products to show" -->
            <div class="overflow-x-auto flex-grow">
              <div v-if="paginatedProducts.length === 0" class="text-gray-500 text-center py-8">
                No products to show
              </div>

              <table v-else class="min-w-full text-left text-sm font-light text-gray-700">
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
                  <tr v-for="item in paginatedProducts" :key="item.id" class="border-b border-neutral-200 transition hover:bg-neutral-100">
                    <td class="whitespace-nowrap px-6 py-4">{{ item.product_code }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ item.name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ categoryMap[item.category_id] || 'Uncategorized' }}</td>
                    <td class="whitespace-nowrap px-6 py-4"><a>₱ </a>{{ formatPrice(item.price) }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
                      <button @click="addToCart(item)" class="bg-red-600 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-lg flex items-center space-x-2 transition duration-300" aria-label="Add to cart">
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
            <div class="flex flex-col md:flex-row justify-between items-center p-4 border-t border-neutral-200 mt-auto relative z-10">
              <span class="text-sm font-normal text-gray-500">
                Showing <span class="font-semibold">{{ startItem }}</span> - <span class="font-semibold">{{ endItem }}</span> of <span class="font-semibold">{{ totalItems }}</span>
              </span>
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

          <!-- Cart Summary Section -->
          <div class="w-[35%] p-6 bg-white shadow-md rounded-lg ml-4">
            <CartSummary :cartItems="cartItems" @updateQuantity="handleUpdateQuantity" @processPayment="handlePaymentProcessing" @remove="handleRemove" />
            <TransactionModal :isOpen="isModalOpen" :transaction="paymentData" @confirm="confirmInvoice" @close="closeModal" />
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
    import { usePage } from '@inertiajs/vue3';
    import TransactionModal from './TransactionModal.vue';
    import { Inertia } from '@inertiajs/inertia';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';


    const props = defineProps({
        products: Array,
        categories: Array,
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

    return matchesSearch && matchesCategory;
  });
});

    // Computed properties for pagination
    const totalItems = computed(() => filteredProducts.value.length);
    const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1);
    const endItem = computed(() => Math.min(startItem.value + itemsPerPage.value - 1, totalItems.value));

    const paginatedProducts = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage.value;
      const end = start + itemsPerPage.value;
      return filteredProducts.value.slice(start, end);
    });

    const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage.value));

    // Pagination navigation
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

    // Add to cart
    const addToCart = (product) => {
      const existingItem = cartItems.value.find(item => item.id === product.id);
      if (existingItem) {
        existingItem.quantity++;
      } else {
        cartItems.value.push({ ...product, quantity: 1 });
      }
    };

    // Handle Remove Item from Cart

    const handleUpdateQuantity = (itemId, quantity) => {
    const item = cartItems.value.find((item) => item.id === itemId);
    if (item) {
      item.quantity = quantity;
    }
  };

  const handleRemove = (itemId) => {
    cartItems.value = cartItems.value.filter((item) => item.id !== itemId);
  };

  const paymentData = ref({});  // Store the payment data

  const handlePaymentProcessing = (data) => {
    console.log('Transaction data:', data);
    paymentData.value = data;
    isModalOpen.value = true;
};

// Handle the confirm event from the TransactionModal
const confirmInvoice = (transaction) => {
  console.log('Invoice confirmed!');
  Inertia.post(route('pos.store'), transaction, {
    onSuccess: () => {
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