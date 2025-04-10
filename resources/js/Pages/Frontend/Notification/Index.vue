<template>
    <DashboardLayout>
        <!-- Alert -->
		<transition name="alert-fade">
			<div v-if="messageType === 'success'" class="flex items-center px-4 py-3 mb-4 bg-green-100 border-t-4 border-green-700 shadow-md">
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

        <div class="p-4 mb-6 bg-white rounded-lg shadow-md">
			<div class="flex items-center justify-between">
				<!-- Breadcrumbs and Title -->
				<div>
					<nav class="flex" aria-label="Breadcrumb">
						<ol class="inline-flex items-center space-x-1 md:space-x-3">
							<!-- Home Icon and Link -->
							<li>
								<div class="flex items-center space-x-1">
									<a href="/admin/dashboard" class="inline-flex items-center text-sm font-medium text-red-600 group hover:text-red-600">
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

									<a href="patients" class="inline-flex items-center text-sm font-medium text-red-600">
										Notification
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="mt-2 text-xl font-semibold text-gray-900">Notification List</h1>
				</div>
				<div class="flex items-center space-x-3">
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
                    <div class="flex items-center space-x-3">
					<!-- Mark all read -->
					<div class="relative">
						<button  @click.prevent="markAllAsRead" class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-600 rounded-lg hover:bg-gray-600">
							Mark all read
						</button>
					</div>
				</div>
            </div>

            <div class="overflow-x-auto">
                <div v-if="filteredNotifications.length === 0" class="py-8 text-center text-gray-500">
                    No notifications found.
                </div>
                <table class="min-w-full text-sm font-light text-left text-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4">Date</th>
                            <th scope="col" class="px-6 py-4">Title</th>
                            <th scope="col" class="px-6 py-4">Message</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="notification in paginatedNotifications" :key="notification.id" class="border-b border-neutral-200 hover:bg-neutral-100">
                            <td class="px-6 py-3 whitespace-nowrap">{{ formatDate(notification.created_at) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">{{ notification.title }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                {{ notification.message }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <span :class="notification.is_read ? 'text-green-600' : 'text-red-600'">
                                    {{ notification.is_read ? 'Read' : 'Unread' }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <button @click="markAsRead(notification.id)" :disabled="notification.is_read" class="text-blue-500 hover:underline">
                                    Mark as Read
                                </button>
                                <button @click="deleteNotification(notification.id)" class="ml-4 text-red-500 hover:underline">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

			<!-- Pagination with Visible Pages -->
            <div class="relative z-10 flex flex-col items-center justify-between p-4 border-t md:flex-row border-neutral-200">
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
                    <li v-for="page in visiblePages" :key="page" :class="['px-3 py-1.5 border', page === currentPage ? 'bg-gray-300' : 'bg-white']">
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
  import DashboardLayout from '@/Layouts/DashboardLayout.vue';
  import Dropdown from '@/Components/Dropdown.vue';
  import DropdownLink from '@/Components/DropdownLink.vue'
  import { route } from 'ziggy-js';
  import { ref, computed, defineProps } from 'vue';
  import { onMounted, onBeforeUnmount } from 'vue';
  import { Inertia } from '@inertiajs/inertia';

  const props = defineProps({
    notifications: {
        type: Array,
        default: () => [], // Provide a default empty array
    },
    message: String,
	message_type: String,
});

const message = ref(props.message || '');
const messageType = ref(props.message_type || 'info');
console.log(message.value);   // Log message content
console.log(messageType.value); // Log message type
const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = 5;

onMounted(() => {
		setTimeout(() => {
			message.value = ''; // Clear the message after 3 seconds
			messageType.value = '';
		}, 3000);
	});

const filters = ref({
		startDate: '',
		endDate: '',
	});

// Computed properties
const filteredNotifications = computed(() => {
    if (!filters.value.startDate || !filters.value.endDate) {
			return props.notifications; // Show all transactions if no date range is set
		}

		const start = new Date(filters.value.startDate).setHours(0, 0, 0, 0);
		const end = new Date(filters.value.endDate).setHours(23, 59, 59, 999);

		return props.notifications.filter((notification) => {
			const notificationDate = new Date(notification.created_at).getTime();
			return notificationDate >= start && notificationDate <= end;
		});
});



// Pagination Logic
const totalItems = computed(() => filteredNotifications.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));
const startItem = computed(() => (currentPage.value - 1) * itemsPerPage + 1);
const endItem = computed(() => Math.min(currentPage.value * itemsPerPage, totalItems.value));
const paginatedNotifications = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    return filteredNotifications.value.slice(start, start + itemsPerPage);
});

// Visible Pages Logic
const visiblePages = computed(() => {
    const pages = [];
    const range = 2;
    const start = Math.max(1, currentPage.value - range);
    const end = Math.min(totalPages.value, currentPage.value + range);

    for (let i = start; i <= end; i++) {
        pages.push(i);
    }
    return pages;
});

// Navigation Functions
const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};
const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
};
const changePage = page => {
    currentPage.value = page;
};

// Methods
function markAsRead(id) {
    Inertia.post(route('notifications.markAsRead', id), {}, {
        preserveScroll: true,
        onSuccess: () => {
            // Update the local state
            const notification = paginatedNotifications.value.find(n => n.id === id);
            if (notification) notification.is_read = true;
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}

function deleteNotification(id) {
    Inertia.delete(route('notifications.delete', id), {
        preserveScroll: true,
        onSuccess: () => {
            // Remove the deleted notification from the local state
            paginatedNotifications.value = paginatedNotifications.value.filter(n => n.id !== id);
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}

const formatDate = (date) => {
		const options = { year: 'numeric', month: 'long', day: 'numeric' };
		return new Date(date).toLocaleDateString(undefined, options);
	};

    function markAllAsRead() {
    Inertia.post(route('notifications.markAllAsRead'), {}, {
        preserveScroll: true,
        onSuccess: () => {
            // Update all notifications locally
            props.notifications.forEach(notification => {
                notification.is_read = true;
            });
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
}
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
