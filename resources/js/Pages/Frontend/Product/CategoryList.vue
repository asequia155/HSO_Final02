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
										Categories
									</a>
								</div>
							</li>
						</ol>
                    </nav>
                    <h1 class="text-xl font-semibold text-gray-900 mt-2">Categories</h1>
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

        <!-- Category List Section -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Search bar -->
            <div class="flex items-center p-4 border-b border-neutral-200 justify-between">
                <div class="relative w-80">
                    <label for="search" class="sr-only">Search</label>
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-gray-500"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="search"
                        v-model="searchQuery"
                        placeholder="Search Categories..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    />
                </div>
                                <!-- Buttons -->
                                <div class="flex items-center space-x-3">
                    <!-- Icon Buttons -->
                    <button
                        class="flex items-center justify-center w-9 h-9 rounded-full bg-yellow-100 hover:bg-yellow-200"
                        title="Print"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9v10h12V9M6 5h12v4H6z" />
                        </svg>
                    </button>
                    <button
                        class="flex items-center justify-center w-9 h-9 rounded-full bg-purple-100 hover:bg-purple-200"
                        title="Export"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
                        </svg>
                    </button>

                    <!-- Add Category Button -->
                    <button
                        @click="openAddCategoryModal"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition duration-300"
                    >
                        + New Category
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div>
                <table class="table-auto w-full text-left text-sm font-light text-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th class="px-6 py-4">Id</th>
                            <th class="px-6 py-4">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Products
                            </th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="paginatedCategories.length === 0">
                            <td colspan="4" class="text-center py-4 text-gray-500">No categories found.</td>
                        </tr>
                        <tr
                            v-for="item in paginatedCategories"
                            :key="item.id"
                            class="border-b border-neutral-200 transition hover:bg-neutral-100"
                        >
                            <td class="whitespace-nowrap px-6 py-3">{{ item.id }}</td>
                            <td class="whitespace-nowrap px-6 py-3">{{ item.name }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap">
                                ({{ item.products_count }}) Products
                            </td>
                            <td class="relative px-6 py-3 text-sm text-gray-500 whitespace-nowrap">
								<button
									id="apple-ipad-air-dropdown-button"
									@click="toggleDropdown(item.id)"
									class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover:bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
									type="button"
								>
									<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
										<path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
									</svg>
								</button>
								<!-- Dropdown and edit/delete actions can go here -->
								<div v-if="dropdownOpen === item.id" class="absolute z-50 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
									<ul class="py-1 text-sm" aria-labelledby="apple-ipad-air-dropdown-button">
										<li>
											<button @click="openModal('edit', item)" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
												<svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
													<path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
													<path fill-rule="evenodd" clip-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
												</svg>
												Edit
											</button>
										</li>
										<li>
											<button @click="openDeleteModal(item.name, item.id)" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400">
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
    </DashboardLayout>
    	<!-- Add Category Modal -->
	<AddCategoryModal :isOpen="isCategoryModalOpen" @add="addCategory" @close="closeAddCategoryModal" />
	<EditCategory :isOpen="editModal" :category="selectedCategory" :categories="categories" @close="closeModal" @save="updateCategory" />
	<DeleteCategory :isOpen="deleteModal" :categoryName="categoryNameToDelete" @close="closeDeleteModal" @confirm="confirmDeleteCategory" />
</template>

<script setup>
import { ref, computed, onMounted, defineProps } from 'vue';
import AddCategoryModal from './AddCategoryModal.vue';
import EditCategory from './EditCategory.vue';
import DeleteCategory from './DeleteCategory.vue';
import { Inertia } from '@inertiajs/inertia';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

// Props and State
const props = defineProps({ 
	categories: Array ,			
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

const searchQuery = ref('');
const dropdownOpen = ref(null);
const isCategoryModalOpen = ref(false);
const selectedCategory = ref(null);
const editModal = ref(false);
const categoryNameToDelete = ref('');
const deleteModal = ref(false);

// Pagination
const currentPage = ref(1);
const perPage = 5;

// Computed Data
const filteredCategories = computed(() =>
    props.categories.filter((category) =>
        category.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
);
const paginatedCategories = computed(() => {
    const start = (currentPage.value - 1) * perPage;
    return filteredCategories.value.slice(start, start + perPage);
});
const totalPages = computed(() => Math.ceil(filteredCategories.value.length / perPage));
const startItem = computed(() => (currentPage.value - 1) * perPage + 1);
const endItem = computed(() => Math.min(currentPage.value * perPage, filteredCategories.value.length));
const totalItems = computed(() => filteredCategories.value.length);

// Methods
const openAddCategoryModal = () => (isCategoryModalOpen.value = true);
const closeAddCategoryModal = () => (isCategoryModalOpen.value = false);
const openModal = (type, item) => {
    selectedCategory.value = item;
	dropdownOpen.value = null;
    if (type === 'edit') editModal.value = true;
};
const closeModal = () => (editModal.value = false);
const openDeleteModal = (name, id) => {
	dropdownOpen.value = null;
    categoryNameToDelete.value = name;
    selectedCategory.value = id;
    deleteModal.value = true;
};
const closeDeleteModal = () => (deleteModal.value = false);
const toggleDropdown = (id) => {
    dropdownOpen.value = dropdownOpen.value === id ? null : id;
};
const addCategory = (categoryName) => {
    Inertia.post(route('categories.store'), { name: categoryName }, { onSuccess: closeAddCategoryModal });
};
const updateCategory = (updatedCategory) => {
    Inertia.put(route('categories.update', updatedCategory.id), { name: updatedCategory.name }, { onSuccess: closeModal });
};
const confirmDeleteCategory = () => {
    Inertia.delete(route('categories.destroy', selectedCategory.value), { onSuccess: closeDeleteModal });
};
const prevPage = () => currentPage.value > 1 && currentPage.value--;
const nextPage = () => currentPage.value < totalPages.value && currentPage.value++;
const changePage = (page) => (currentPage.value = page);
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
