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

		<!-- Header Section -->
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

									<a href="products" class="inline-flex items-center hover:text-red-600 text-gray-700 text-sm font-medium">
										Products
									</a>

									<svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
									</svg>

									<a href="products" class="inline-flex items-center text-red-600 text-sm font-medium">
										Products List
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="text-xl font-semibold text-gray-900 mt-2">Products List</h1>
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
								placeholder="Search Product..."
								class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
							/>
						</div>
					</form>
					<!-- Filter Dropdown -->
					<div class="relative inline-block text-left">
						<!-- Toggle Button -->
						<button
							@click="toggleCategoryDropdown"
							id="filterDropdownButton"
							class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:border-red-500 bg-white rounded-lg border border-gray-300 hover:bg-red-100 hover:text-red-500 focus:z-10 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 dark:bg-red-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-blue-400 dark:hover:bg-gray-700"
							type="button"
						>
							<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
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
										{{ category.name }} ({{ category.count }})
									</label>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- Buttons -->
				<div class="flex items-center ml-auto space-x-3">
					<!-- Icon Buttons -->
					<button @click="exportToExcel" class="flex items-center justify-center w-9 h-9 rounded-full bg-yellow-100 hover:bg-yellow-200" title="Export to excel">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9v10h12V9M6 5h12v4H6z" />
						</svg>
					</button>
					<button class="flex items-center justify-center w-9 h-9 rounded-full bg-purple-100 hover:bg-purple-200" title="Export">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
						</svg>
					</button>
					<!-- Add Category Button -->
					<button @click="openAddModal" class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition duration-300">
						+ New Product
					</button>
				</div>
			</div>

			<div class="overflow-x-auto">
				<div v-if="products.length === 0" class="text-gray-500 text-center py-8">
					No products yet
				</div>
				<table class="min-w-full text-left text-sm font-light text-gray-700">
					<thead class="text-xs text-gray-700 uppercase bg-gray-200 text-left">
						<tr>
							<th scope="col" class="px-6 py-4">Product Code</th>
							<th scope="col" class="px-6 py-4">Name</th>
							<th scope="col" class="px-6 py-4">Category</th>
							<th scope="col" class="px-6 py-4">Price</th>
							<th scope="col" class="px-6 py-4">Description</th>
							<th scope="col" class="px-6 py-4">Quantity</th>
							<th scope="col" class="px-6 py-4">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item in paginatedProducts" :key="item.id" class="border-b border-neutral-200 transition hover:bg-neutral-100 cursor-pointer" @click="openModal('show', item)">
							<td class="whitespace-nowrap px-6 py-3">#9ca3af{{ item.id }}</td>
							<td class="whitespace-nowrap px-6 py-3">{{ item.name }}</td>
							<td class="whitespace-nowrap px-6 py-3">{{ categoryMap[item.category_id] || 'Uncategorized' }}</td>
							<td class="whitespace-nowrap px-6 py-3"><a>₱ </a>{{ Number(item.price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</td>
							<td class="whitespace-nowrap px-6 py-3">
								{{ item.description.length > 25 ? item.description.slice(0, 25) + '...' : item.description }}
							</td>
							<td class="whitespace-nowrap px-6 py-3">{{ item.quantity }}</td>
							<td class="whitespace-nowrap px-6 py-3">
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
								<div v-if="dropdownOpen === item.id" class="absolute right-0 z-50 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
									<ul class="py-1 text-sm" aria-labelledby="apple-ipad-air-dropdown-button">
										<li>
											<button @click.stop="openAddStockModal(item)" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
												<svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
													<path
														d="M12 4C11.448 4 11 4.448 11 5V11H5C4.448 11 4 11.448 4 12C4 12.552 4.448 13 5 13H11V19C11 19.552 11.448 20 12 20C12.552 20 13 19.552 13 19V13H19C19.552 13 20 12.552 20 12C20 11.448 19.552 11 19 11H13V5C13 4.448 12.552 4 12 4Z"
													/>
												</svg>
												Add stock
											</button>
										</li>
										<li>
											<button
												@click.stop="openModal('edit', item)"
												@click="openModal('edit', item)"
												class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200"
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
												@click.stop="openDeleteModal(item.name, item.id)"
												@click="openDeleteModal(item.name, item.id)"
												class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400"
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

		<AddStock :isOpen="addStock" :product="selectedProduct" :categories="categories" @close="closeModal" @save="updateProductQuantity" />
		<ShowModal :isOpen="showModal" :category="categories" :product="selectedProduct" @close="closeModal" />
		<EditModal :isOpen="editModal" :product="selectedProduct" :categories="categories" @close="closeModal" @save="updateProduct" />
		<AddProductModal :isOpen="addModal" :categories="categories" @close="closeAddModal" @add="addProduct" />
		<AddCategoryModal :isOpen="isCategoryModalOpen" @add="addCategory" @close="closeAddCategoryModal" />
		<DeleteConfirmationModal :isOpen="deleteModal" :productName="productNameToDelete" @close="closeDeleteModal" @confirm="confirmDeleteProduct" />
	</DashboardLayout>
</template>

<script setup>
		import { ref, watch, computed, defineProps } from 'vue';
		import ShowModal from './Show.vue';
		import EditModal from './Edit.vue';
		import AddProductModal from './AddProductModal.vue';
		import AddCategoryModal from './AddCategoryModal.vue';
		import { Inertia } from '@inertiajs/inertia';
		import DeleteConfirmationModal from './DeleteConfirmationModal.vue';
		import DashboardLayout from '@/Layouts/DashboardLayout.vue';
		import { onMounted, onBeforeUnmount } from 'vue';
		import Dropdown from '@/Components/Dropdown.vue';
		import DropdownLink from '@/Components/DropdownLink.vue';
		import { utils, writeFile } from 'xlsx';
		import AddStock from './AddStock.vue';

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

		const showModal = ref(false);
		const editModal = ref(false);
		const addStock = ref(false);
		const addModal = ref(false);
		const deleteModal = ref(false);
		const productNameToDelete = ref('');
		const isCategoryModalOpen = ref(false);
		const selectedProduct = ref(null);
		const searchQuery = ref('');
		const currentPage = ref(1);
		const itemsPerPage = ref(5);
		const isCategoryDropdownOpen1 = ref ('');
		const selectedCategories = ref([]); // Array to store selected categories

		const toggleCategoryDropdown = () => {
		    isCategoryDropdownOpen1.value = !isCategoryDropdownOpen1.value;
		};

		const closeAddCategoryModal = () => {
		  isCategoryModalOpen.value = false;
		};

		const addCategory = (categoryName) => {
		  console.log('Category:', categoryName); // Logs the category name being sent to the backend
		  Inertia.post(route('categories.store'), { name: categoryName }, {
		    onSuccess: () => {
		      closeAddCategoryModal(); // Close the modal when the category is added successfully
		      console.log('Category added successfully');
		    },
		    onError: (errors) => {
		      console.error('Error adding category:', errors); // Logs backend validation errors or other issues
		    }
		  });
		};

		// Computed property for filtering products by search
		const filteredProducts = computed(() => {
		    let filtered = props.products;
		    if (searchQuery.value) {
		        filtered = filtered.filter(product =>
		            product.name.toLowerCase().includes(searchQuery.value.toLowerCase())
		        );
		    }
		    if (selectedCategories.value.length > 0) {
		    filtered = filtered.filter(product =>
		      selectedCategories.value.includes(product.category_id)
		    );
		  }
		    return filtered;
		});

		// Computed properties for pagination
		const totalItems = computed(() => filteredProducts.value.length);
		const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1);
		const endItem = computed(() => Math.min(startItem.value + paginatedProducts.value.length - 1, totalItems.value));

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

		// Modal management

		// Open the Add Stock Modal and set the selected product
	const openAddStockModal = (item) => {
	  closeDropdown();
	  isCategoryDropdownOpen1.value = false;
	  addStock.value = true;
	  selectedProduct.value = item;
	};

	const updateProductQuantity = (updatedProduct) => {
		    Inertia.put(route('products.addStock', updatedProduct.id), {
		        name: updatedProduct.name,
		        price: updatedProduct.price,
		        description: updatedProduct.description,
		        category_id: updatedProduct.category_id,
		        quantity: updatedProduct.quantity
		    }, {
		        onSuccess: () => {
		            console.log('Product updated successfully'); // Log success
		            closeModal();
		        },
		        onError: (errors) => {
		            console.error('Update failed:', errors); // Log errors
		        }
		    });
	};

		const openModal = (type, item) => {
			closeDropdown();
			isCategoryDropdownOpen1.value = false;
		    selectedProduct.value = item;
		    if (type === 'show') showModal.value = true;
		    if (type === 'edit') editModal.value = true;
		};

		const closeModal = () => {
		    showModal.value = false;
		    editModal.value = false;
			addStock.value = false;
		    selectedProduct.value = null;
		};

		// Open the modal
		const openAddModal = () => {
		  addModal.value = true;
		  isCategoryDropdownOpen1.value = false;
		};

		// Close the modal
		const closeAddModal = () => {
		  addModal.value = false;
		};
		// CRUD Operations
		const deleteProduct = (productId) => {
		        Inertia.delete(route('products.destroy', productId));
		};

		const updateProduct = (updatedProduct) => {
		    console.log('Received Updated Product:', updatedProduct); // Check if id is present
		    Inertia.put(route('products.update', updatedProduct.id), {
		        name: updatedProduct.name,
		        price: updatedProduct.price,
		        description: updatedProduct.description,
		        category_id: updatedProduct.category_id,
		        quantity: updatedProduct.quantity
		    }, {
		        onSuccess: () => {
		            console.log('Product updated successfully'); // Log success
		            closeModal();
		        },
		        onError: (errors) => {
		            console.error('Update failed:', errors); // Log errors
		        }
		    });
		};

		const addProduct = (product) => {
		    console.log('Product data:', product); // Check what data is being passed
		    Inertia.post(route('products.store'), {
		        name: product.name,
		        price: product.price,
		        category_id: product.category_id, // Ensure this matches your modal's v-model
		        description: product.description,
		        quantity: product.quantity
		    }, {
		        onSuccess: () => {
		            closeAddModal(); // Close the modal after a successful addition
		            console.log('Product added successfully');
		        },
		        onError: (errors) => {
		            console.error('Error adding product:', errors);
		        }
		    });
		};


		//Delete script
		const openDeleteModal = (productName, productId) => {
			closeDropdown();
			isCategoryDropdownOpen1.value = false;
		    productNameToDelete.value = productName; // Store product name
		    selectedProduct.value = productId; // Store the product ID for deletion
		    deleteModal.value = true; // Open delete confirmation modal
		};

		const closeDeleteModal = () => {
		    deleteModal.value = false; // Close delete confirmation modal
		    productNameToDelete.value = ''; // Clear product name
		};

		const confirmDeleteProduct = () => {
		    deleteProduct(selectedProduct.value); // Call the delete function
		    closeDeleteModal(); // Close the modal after deletion
		};

		// Create a mapping of category IDs to category names
		const categoryMap = computed(() => {
		    const map = {};
		    props.categories.forEach(category => {
		        map[category.id] = category.name; // Map category ID to category name
		    });
		    return map;
		});
		//for dropdown modal add, edit, delete
		const dropdownOpen = ref(null); // Store the id of the opened dropdown

		const toggleDropdown = (itemId) => {
		    dropdownOpen.value = dropdownOpen.value === itemId ? null : itemId; // Toggle dropdown visibility
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
		    window.removeEventListener('click', closeDropdown, handleClickOutside );
		});

	const exportToExcel = () => {
	    const worksheetData = props.products.map((product) => ({
	        Id: product.id,
	        Name: product.name,
	        Category: categoryMap.value[product.category_id] || 'Uncategorized',
	        Price: `₱ ${Number(product.price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}`,
	        Description: product.description.length > 25 ? product.description.slice(0, 25) + '...' : product.description,
	        Quantity: product.quantity,
	    }));

	    const worksheet = utils.json_to_sheet(worksheetData);
	    const workbook = utils.book_new();
	    utils.book_append_sheet(workbook, worksheet, 'Products');

	    // Generate and download the Excel file
	    writeFile(workbook, 'Products_List.xlsx');
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