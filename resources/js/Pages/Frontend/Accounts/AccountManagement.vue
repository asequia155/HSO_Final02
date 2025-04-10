<template>
    <DashboardLayout>
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
									<a href="/dashboard"  class="inline-flex items-center text-sm font-medium text-red-600 group hover:text-red-600">
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
									<a href="accounts.index" class="inline-flex items-center text-sm font-medium text-red-600">
										User Management
									</a>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="mt-2 text-xl font-semibold text-gray-900">Accounts</h1>
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

      <!-- Account Table -->
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
      href="/accounts/add-clerk"
      class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-500 rounded-lg hover:bg-gray-600"
    >
      +Add Clerk
    </a>


  </div>

		</div>
        <div class="overflow-x-auto">
          <!-- If no accounts are found -->
          <div v-if="filteredAccounts.length === 0" class="py-8 text-center text-gray-500">
            No accounts found.
          </div>

          <!-- Account Table -->
          <table v-else class="min-w-full text-sm font-light text-left text-gray-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
              <tr>
                <th scope="col" class="px-6 py-4">Name</th>
                <th scope="col" class="px-6 py-4">Email</th>
                <th scope="col" class="px-6 py-4">Roles</th>
                <th scope="col" class="px-6 py-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="account in paginatedAccounts"
                :key="account.id"
                class="border-b border-neutral-200 hover:bg-neutral-100"
              >
                <td class="px-6 py-3 whitespace-nowrap">{{ account.name }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ account.email }}</td>
                <td class="px-6 py-3 whitespace-nowrap">
                  <span
                    v-for="role in account.roles"
                    :key="role.id"
                    class="inline-block px-2 py-1 text-sm text-white bg-blue-500 rounded-full"
                  >
                    {{ role.name }}
                  </span>
                </td>

                <td class="px-6 py-3 whitespace-nowrap">

                  <button
                    @click="deleteAccount(account.id)"
                    class="ml-4 text-red-500 hover:underline"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
         <!-- Edit Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="w-full max-w-lg bg-white rounded-lg shadow-lg">
        <header class="p-4 border-b">
          <h2 class="text-lg font-medium text-gray-900">Edit User</h2>
        </header>

        <form @submit.prevent="saveAccount" class="p-4 space-y-6">
          <div>
            <InputLabel for="name" value="Name" />
            <TextInput id="name" v-model="form.name" class="block w-full mt-1" required />
            <InputError :message="form.errors.name" />
          </div>

          <div>
            <InputLabel for="email" value="Email" />
            <TextInput id="email" v-model="form.email" class="block w-full mt-1" required />
            <InputError :message="form.errors.email" />
          </div>

          <footer class="flex justify-end gap-4">
            <PrimaryButton @click="saveAccount" :disabled="form.processing">
  Save
</PrimaryButton>
            <button @click="closeModal" type="button" class="text-gray-500 hover:underline">Cancel</button>
          </footer>
        </form>
      </div>
    </div>
        <!-- Pagination Section -->
        <div class="relative z-10 flex flex-col items-center justify-between p-4 border-t md:flex-row border-neutral-200">
          <span class="text-sm font-normal text-gray-500">
            Showing <span class="font-semibold">{{ startItem }}</span> - <span
              class="font-semibold"
            >{{ endItem }}</span>
            of <span class="font-semibold">{{ totalItems }}</span>
          </span>
          <ul class="inline-flex items-stretch mt-2 -space-x-px md:mt-0">
            <li>
              <button
                @click="prevPage"
                :disabled="currentPage === 1"
                class="px-3 py-1.5 border rounded-l-lg"
              >
                Prev
              </button>
            </li>
            <li
              v-for="page in visiblePages"
              :key="page"
              :class="['px-3 py-1.5 border', page === currentPage ? 'bg-gray-300' : 'bg-white']"
            >
              <button @click="changePage(page)">{{ page }}</button>
            </li>
            <li>
              <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
                class="px-3 py-1.5 border rounded-r-lg"
              >
                Next
              </button>
            </li>
          </ul>
        </div>
      </div>
      <div
  v-if="showModal"
  class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
>
  <div class="w-full max-w-lg bg-white rounded-lg shadow-lg">
    <header class="p-4 border-b">
      <h2 class="text-lg font-medium text-gray-900">Edit User</h2>
    </header>

    <form @submit.prevent="saveAccount" class="p-4 space-y-6">
      <div>
        <InputLabel for="name" value="Name" />
        <TextInput id="name" v-model="form.name" class="block w-full mt-1" required />
        <InputError :message="form.errors.name" />
      </div>

      <div>
        <InputLabel for="email" value="Email" />
        <TextInput id="email" v-model="form.email" class="block w-full mt-1" required />
        <InputError :message="form.errors.email" />
      </div>

      <footer class="flex justify-end gap-4">
        <PrimaryButton @click="saveAccount" :disabled="form.processing">Save</PrimaryButton>
        <button @click="closeModal" type="button" class="text-gray-500 hover:underline">
          Cancel
        </button>
      </footer>
    </form>
  </div>
</div>

    </DashboardLayout>
  </template>

  <script setup>
  import DashboardLayout from '@/Layouts/DashboardLayout.vue';
  import { ref, computed, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';


  const props = defineProps({
    users: {
      type: Array,
      required: true, // Ensure users are passed as a prop
    },
  });

  // Initialize accounts using the users prop
  const accounts = ref([]);
  const showModal = ref(false);
  const selectedAccount = ref(null);

  const itemsPerPage = 5;
  const currentPage = ref(1);
  const searchQuery = ref('');



const saveAccount = () => {
  form.put(route('accounts.update', { id: selectedAccount.value.id }), {
    onSuccess: () => {
      showModal.value = false; // Close modal on success
    },
  });
};

const closeModal = () => {
  showModal.value = false;
};


  // Watch for changes in the users prop and update accounts dynamically
  watch(
    () => props.users,
    (newUsers) => {
      // Filter accounts with roles 'clerk' or 'admin'
      accounts.value = newUsers.filter((user) =>
        user.roles.some((role) => ['clerk', 'admin'].includes(role.name))
      );
    },
    { immediate: true } // Ensure the filter is applied on component mount
  );

  // Filtered accounts based on the search query
  const filteredAccounts = computed(() => {
    if (!searchQuery.value) return accounts.value;
    return accounts.value.filter((account) =>
      account.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });

  // Pagination logic
  const totalItems = computed(() => filteredAccounts.value.length);
  const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));
  const startItem = computed(() => (currentPage.value - 1) * itemsPerPage + 1);
  const endItem = computed(() => Math.min(currentPage.value * itemsPerPage, totalItems.value));
  const paginatedAccounts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    return filteredAccounts.value.slice(start, start + itemsPerPage);
  });

  // Visible pages for pagination
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

  // Navigation functions
  const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
  };
  const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
  };
  const changePage = (page) => {
    currentPage.value = page;
  };

  // Toggle active state


  // Edit account
  const AccountEdit = (id) => {
  const account = accounts.value.find((acc) => acc.id === id);
  if (account) {
    selectedAccount.value = account;
    form.name = account.name;
    form.email = account.email;
    showModal.value = true; // Open the modal
  }
};



  // Delete account
  const deleteAccount = (id) => {
  // Use Inertia to make a delete request
  Inertia.delete(route('accounts.destroy', id), {
    onSuccess: () => {
      console.log(`Account with ID ${id} deleted successfully.`);
    },
    onError: (error) => {
      console.error('Error deleting account:', error);
    },
  });
};


  </script>
