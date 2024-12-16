<template>
    <DashboardLayout>
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
									<a href="/" class="inline-flex items-center group text-red-600 hover:text-red-600 text-sm font-medium">
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
										Notification
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="text-xl font-semibold text-gray-900 mt-2">Notification List</h1>
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
      <!-- Header Section -->
      <div class="flex items-center p-4 border-b border-neutral-200 justify-between w-full">
        <div class="flex items-center space-x-4">
          <!-- Search Bar -->
          <form class="flex items-center">
            <label for="search" class="sr-only">Search</label>
            <div class="relative w-80">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
              </div>
              <input
                type="text"
                id="search"
                v-model="searchQuery"
                placeholder="Search notifications..."
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 p-2"
              />
            </div>
          </form>
        </div>
      </div>
  
      <!-- Table Section -->
      <div class="overflow-x-auto">
        <div v-if="filteredNotifications.length === 0" class="text-gray-500 text-center py-8">
          No notifications found.
        </div>
        <table class="min-w-full text-left text-sm font-light text-gray-700">
          <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
              <th scope="col" class="px-6 py-4">ID</th>
              <th scope="col" class="px-6 py-4">Title</th>
              <th scope="col" class="px-6 py-4">Message</th>
              <th scope="col" class="px-6 py-4">Status</th>
              <th scope="col" class="px-6 py-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="notification in paginatedNotifications" :key="notification.id" class="border-b border-neutral-200 hover:bg-neutral-100">
              <td class="whitespace-nowrap px-6 py-3">#{{ notification.id }}</td>
              <td class="whitespace-nowrap px-6 py-3">{{ notification.title }}</td>
              <td class="whitespace-nowrap px-6 py-3">
                {{ notification.message.length > 25 ? notification.message.slice(0, 25) + '...' : notification.message }}
              </td>
              <td class="whitespace-nowrap px-6 py-3">{{ notification.is_read ? 'Read' : 'Unread' }}</td>
              <td class="whitespace-nowrap px-6 py-3">
                <button @click="markAsRead(notification.id)" class="text-blue-500 hover:underline">Mark as Read</button>
                <button @click="deleteNotification(notification.id)" class="text-red-500 hover:underline ml-4">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Pagination -->
      <div class="flex justify-between items-center p-4 border-t border-neutral-200">
        <span class="text-sm text-gray-500">Showing {{ startItem }} to {{ endItem }} of {{ totalItems }} notifications</span>
        <ul class="inline-flex items-stretch -space-x-px">
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
  import DashboardLayout from '@/Layouts/DashboardLayout.vue';
  import Dropdown from '@/Components/Dropdown.vue';
  import DropdownLink from '@/Components/DropdownLink.vue';
import { ref, computed } from 'vue';

// Mock data for demonstration
const notifications = ref([
  { id: 1, title: 'Welcome', message: 'Welcome to the platform!', is_read: false },
  { id: 2, title: 'Reminder', message: 'Don’t forget to update your profile.', is_read: true },
  // Add more notifications as needed
]);

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = 5;

// Computed properties
const filteredNotifications = computed(() =>
  notifications.value.filter((notification) =>
    notification.title.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
);

const totalItems = computed(() => filteredNotifications.value.length);

const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));

const paginatedNotifications = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredNotifications.value.slice(start, start + itemsPerPage);
});

const startItem = computed(() => (currentPage.value - 1) * itemsPerPage + 1);

const endItem = computed(() => Math.min(currentPage.value * itemsPerPage, totalItems.value));

// Methods
const markAsRead = (notificationId) => {
  const notification = notifications.value.find((n) => n.id === notificationId);
  if (notification) notification.is_read = true;
};

const deleteNotification = (notificationId) => {
  notifications.value = notifications.value.filter((n) => n.id !== notificationId);
};

const changePage = (page) => {
  currentPage.value = page;
};

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};

</script>
