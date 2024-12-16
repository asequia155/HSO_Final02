<template>
        <div class="bg-white shadow-md rounded-lg p-4 mb-6">
    <div class="flex justify-between items-center">
        <!-- Breadcrumbs and Title -->
        <div class="flex items-center">
            <svg class="w-8 h-6 text-black mr-1 group-hover:text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <h1 class="text-xl font-semibold text-gray-900 mt-1">Dashboard</h1>
        </div>

        <div class="flex items-center space-x-3">
            <div class="mt-2" style="margin-right: -10px;">
    <button @click="toggleDropdown">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405C18.317 14.74 18 13.38 18 12V9c0-3.866-3.134-7-7-7S4 5.134 4 9v3c0 1.38-.317 2.74-.595 3.595L2 17h5m8 0a3 3 0 01-6 0m6 0H9" />
      </svg>
    </button>
    <div v-if="dropdownOpen">
      <ul>
        <li v-for="notification in notifications" :key="notification.id">
          <div>
            <h4>{{ notification.title }}</h4>
            <p>{{ notification.message }}</p>
            <button @click="markAsRead(notification.id)">Mark as Read</button>
            <button @click="deleteNotification(notification.id)">Delete</button>
          </div>
        </li>
      </ul>
      <div v-if="notifications.length === 0">No new notifications</div>
    </div>
  </div>

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
</template>

<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

// import { ref, watch } from "vue";
// import { Inertia } from "@inertiajs/inertia";

// // Props passed from Laravel via Inertia
// defineProps({
//   initialNotifications: Array, // Prop for the initial list of notifications
// });

// const notifications = ref([...initialNotifications]); // Reactive list of notifications
// const dropdownOpen = ref(false);

// // Toggle dropdown visibility
// const toggleDropdown = () => {
//   dropdownOpen.value = !dropdownOpen.value;
//   if (dropdownOpen.value) {
//     fetchNotifications();
//   }
// };

// // Fetch updated notifications (if needed)
// const fetchNotifications = () => {
//   Inertia.get("/notifications", {}, { preserveState: true }).then(({ props }) => {
//     notifications.value = props.notifications;
//   });
// };

// // Mark a single notification as read
// const markAsRead = (id) => {
//   Inertia.post(`/notifications/${id}/read`, {}, { preserveState: true }).then(() => {
//     // Update notifications locally after marking as read
//     notifications.value = notifications.value.filter((n) => n.id !== id);
//   });
// };

// // Delete a notification
// const deleteNotification = (id) => {
//   Inertia.delete(`/notifications/${id}`, { preserveState: true }).then(() => {
//     // Update notifications locally after deletion
//     notifications.value = notifications.value.filter((n) => n.id !== id);
//   });
// };
</script>