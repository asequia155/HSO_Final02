<template>
    <div class="flex flex-col items-center w-56 min-h-screen text-black bg-white right-shadow">
      <!-- Logo -->
      <Link
  v-if="$page.props.auth.user.roles[0].name === 'admin'"
  class="flex items-center w-full mt-3 px-4"
  :href="route('admin.dashboard')"
>
  <div class="flex items-center justify-center">
    <img src="./logored.svg" alt="Logo" class="w-40 h-20" />
  </div>
</Link>

<Link
  v-if="$page.props.auth.user.roles[0].name === 'clerk'"
  class="flex items-center w-full mt-3 px-4"
  :href="route('clerk.dashboard')"
>
  <div class="flex items-center justify-center">
    <img src="./logored.svg" alt="Logo" class="w-40 h-20" />
  </div>
</Link>


      <!-- Navigation Links -->
      <div class="w-full px-2">
        <div class="flex flex-col items-center w-full mt-3 border-t border-blue-gray-700">

<!-- Admin Dashboard -->
<Link
  v-if="$page.props.auth.user.roles[0].name === 'admin'"
  :href="route('admin.dashboard')"
  :class="{ 'bg-red-600 font-bold text-white': $page.component === 'AdminDashboard' }"
  class="flex items-center w-full h-12 px-3 mt-6 rounded hover:bg-red-600 hover:text-white"
>
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
    </svg>
    <span class="ml-2 text-sm font-medium">Admin Dashboard</span>
</Link>
<!-- Clerk Dashboard -->
<Link
  v-if="$page.props.auth.user.roles[0].name === 'clerk'"
  :href="route('clerk.dashboard')"
  :class="{ 'bg-red-600 font-bold text-white': $page.component === 'ClerkDashboard' }"
  class="flex items-center w-full h-12 px-3 mt-6 rounded hover:bg-red-600 hover:text-white"
>
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
    </svg>
    <span class="ml-2 text-sm font-medium">Clerk Dashboard</span>
</Link>

          <!-- Patients -->
          <Link
            @click="closeDropdown"
            v-if="$page.props.auth.user.roles[0].name === 'admin'"
            :class="{ 'bg-red-600  font-bold text-white': $page.component === 'Frontend/Patient/Index' }"
            class="flex items-center w-full h-12 px-3 mt-1 rounded hover:bg-red-600 hover:text-white"
            :href="route('patients')"
          >
          <svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
			</svg>
            <span class="ml-2 text-sm font-medium">Patients</span>
          </Link>

          <!-- Products Dropdown -->
          <div class="w-full">
            <button
              @click="toggleDropdown"
              class="flex items-center w-full h-12 px-3 mt-1 rounded hover:bg-red-600 hover:text-white"
              aria-expanded="dropdownOpen"
            >
            <svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="black">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
					  </svg>
              <span class="ml-2 text-sm font-medium">Products</span>
              <svg class="w-4 h-4 ml-auto text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#9ca3af">
                <path d="M5.5 7.5L10 12l4.5-4.5H5.5z" />
              </svg>
            </button>
            <div v-if="dropdownOpen" class="ml-6">
              <Link
                :href="route('products.index')"
                :class="{ 'bg-red-600  font-bold text-white': $page.component === 'Frontend/Product/Index' }"
                class="block px-4 py-2 mt-1 text-sm text-black rounded hover:bg-red-600 hover:text-white"
              >
                Product List
              </Link>
              <Link
                :href="route('products.category')"
                :class="{ 'bg-red-600  font-bold text-white': $page.component === 'Frontend/Product/CategoryList' }"
                class="block px-4 py-2 mt-1 text-sm text-black rounded hover:bg-red-600 hover:text-white"
              >
                Categories
              </Link>
            </div>
          </div>

          <!-- POS -->
          <Link
            @click="closeDropdown"
            v-if="$page.props.auth.user.roles[0].name === 'clerk'"

            :class="{ 'bg-red-600  font-bold text-white': $page.component === 'Frontend/POS/Index' }"
            class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-red-600 hover:text-white"
            :href="route('pos.index')"
          >
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
					</svg>
            <span class="ml-2 text-sm font-medium">Point-Of-Sales</span>
          </Link>
          <div class="flex flex-col items-center w-full mt-6 border-t border-gray-700"></div>

          <!-- Report -->
          <Link
            @click="closeDropdown"
            :class="{ 'bg-red-600  font-bold text-white': $page.component === 'Frontend/POS/GetTransactionHistory' }"
            class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-red-600 hover:text-white"
            :href="route('transactions.report')"
          >
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
					</svg>
            <span class="ml-2 text-sm font-medium">Transaction</span>
          </Link>

          <!-- Notification -->
          <Link
            @click="closeDropdown"
            class="relative flex items-center w-full h-12 px-3 mt-1 rounded hover:bg-gray-700 hover:text-white"
            :href="route('placeholder')"
          >
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
					</svg>
            <span class="ml-2 text-sm font-medium">Notification</span>
            <span class="absolute top-0 left-0 w-2 h-2 mt-2 ml-2 bg-red-500 rounded-full"></span>
          </Link>

          <!-- Settings -->
          <Link
            @click="closeDropdown"
            class="flex items-center w-full h-12 px-3 mt-1 rounded hover:bg-gray-700 hover:text-white"
            :href="route('placeholder')"
          >
					<svg class="w-6 h-6 stroke-current"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
					</svg>
            <span class="ml-2 text-sm font-medium">Settings</span>
          </Link>

        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { Link, usePage } from "@inertiajs/inertia-vue3";
  import { ref, onMounted, onBeforeUnmount } from 'vue';
  import logored from "./logored.vue";

  const dropdownOpen = ref(false);

// Function to toggle dropdown
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
    localStorage.setItem('dropdownOpen', dropdownOpen.value);
};

const closeDropdown = () => {
    localStorage.setItem('dropdownOpen', false);
}


// Restore dropdown state on component mount
onMounted(() => {
    const savedState = localStorage.getItem('dropdownOpen');
    if (savedState !== null ) {
        dropdownOpen.value = savedState === 'true';
    }
});

// Close dropdown when navigating away
onBeforeUnmount(() => {
    dropdownOpen.value = false;
    localStorage.setItem("dropdownOpen", "false");
});
  </script>

  <style scoped>
  .right-shadow {
    box-shadow: 5px 0 10px rgba(0, 0, 0, 0.1);
  }
  </style>
