<template>
    <DashboardLayout>
<!-- Alert -->
<transition name="alert-fade">
            <div
                v-if="message"
                :class="[
                    'flex items-center px-4 py-3 mb-4 shadow-md',
                    messageType === 'success' ? 'bg-green-100 border-t-4 border-green-700' : 'bg-red-100 border-t-4 border-red-700',
                ]"
            >
                <div class="flex items-center">
                    <!-- Icon -->
                    <svg
                        v-if="messageType === 'success'"
                        class="w-6 h-6 text-green-700"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <svg
                        v-else
                        class="w-6 h-6 text-red-700"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <!-- Alert Text -->
                    <span :class="['ml-2 font-medium', messageType === 'success' ? 'text-green-700' : 'text-red-700']">{{ message }}</span>
                </div>
            </div>
        </transition>
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
                                    <a v-if="$page.props.auth.user.roles[0].name === 'admin'" href="/admin/dashboard" class="inline-flex items-center text-sm font-medium text-black group hover:text-red-600">
                                        Admin Dashboard
                                    </a>

                                    <a v-if="$page.props.auth.user.roles[0].name === 'clerk'" href="/clerk/dashboard" class="inline-flex items-center text-sm font-medium text-red-600 group hover:text-red-600">
                                        Clerk Dashboard
                                    </a>

                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
    <a href="../patients" class="inline-flex items-center text-sm font-medium text-black group hover:text-red-600">
        Patient List
    </a>
    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
    </svg>


                                    <a href="patients" class="inline-flex items-center text-sm font-medium text-red-600">
                                        Patient Detail
                                    </a>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="mt-2 text-xl font-semibold text-gray-900">Patient information</h1>
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
        <!-- Patient Details Section -->
        <div class="relative px-2 overflow-visible bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <!-- Left Section -->
                <h2 class="px-4 py-4 mt-2 text-xl font-semibold text-gray-900">Patient Details</h2>
                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <!-- Add New Record Button -->
                    <button @click="opeEditPatientModal" class="px-4 py-2 mr-4 text-sm font-semibold text-white transition duration-300 bg-red-500 rounded-lg hover:bg-gray-600">
                        Update Details
                    </button>
                </div>
            </div>
            <!-- Patient Details -->
            <hr class="w-full border-t border-gray-300" />
            <div v-if="patient" class="px-4 py-4">
                <div class="mb-2">
                    <p><strong>Name:</strong> <span class="text-gray-700 capitalize">{{ patient.first_name }} {{ patient.last_name }}</span></p>
                </div>
                <div class="mb-2">
                    <p><strong>Gender:</strong> <span class="text-gray-700 capitalize">{{ patient.gender }}</span></p>
                </div>
                <div class="mb-2">
                    <p><strong>Email:</strong> <span class="text-gray-700">{{ patient.email }}</span></p>
                </div>
                <div class="mb-2">
                    <p><strong>Phone:</strong> <span class="text-gray-700">+63 {{ patient.phone }}</span></p>
                </div>
                <div class="mb-2">
                    <p><strong>Occupation:</strong> <span class="text-gray-700 capitalize">{{ patient.occupation }}</span></p>
                </div>
                <div class="mb-2">
                    <p><strong>Address:</strong> <span class="text-gray-700 capitalize">{{ patient.address }}</span></p>
                </div>
                <div class="mb-2">
                    <p><strong>Age:</strong> <span class="text-gray-700">{{ calculateAge(patient.date_of_birth) }}</span></p>
                </div>
            </div>
        </div>
        <div class="relative mt-4 overflow-visible bg-white rounded-lg shadow-lg" v-if="$page.props.auth.user.roles[0].name === 'admin'">
    <!-- Header Section -->
    <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200">
      <h2 class="text-lg font-semibold text-gray-700">Patient Details</h2>
      <div>
        <button
          @click="showTable = 'prescriptions'"
          :class="['px-4 py-2 text-sm font-semibold rounded-lg', showTable === 'prescriptions' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700']"
        >
          Prescriptions
        </button>
        <button
          @click="showTable = 'purchasedItems'"
          :class="['px-4 py-2 text-sm font-semibold rounded-lg ml-2', showTable === 'purchasedItems' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700']"
        >
          Purchased Items
        </button>
      </div>
    </div>

    <!-- Date Filters -->
<div class="flex items-center justify-between px-4 py-2 border-b border-gray-200">
  <!-- Left Section: Date Filters -->
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

  <!-- Right Section: Button -->
  <div class="flex items-center space-x-4" v-if="$page.props.auth.user.roles[0].name === 'admin' && showTable === 'prescriptions'">
    <button @click="openAddModal" class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-500 rounded-lg hover:bg-gray-600">
      New Record
    </button>
  </div>
</div>


    <!-- Conditional Table Rendering -->
    <div v-if="showTable === 'prescriptions'" class="overflow-x-auto">
      <!-- Display message when no prescriptions are available -->
      <div v-if="filteredPrescriptions.length === 0" class="p-4 text-center">
        <p class="text-gray-500">No prescriptions available.</p>
      </div>

      <!-- Prescription Table -->
      <table v-else class="min-w-full text-sm font-light text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
          <tr>
            <th scope="col" class="px-6 py-4">Date</th>
            <th scope="col" class="px-6 py-4">OD</th>
            <th scope="col" class="px-6 py-4">OS</th>
            <th scope="col" class="px-6 py-4">ADD</th>
            <th scope="col" class="px-6 py-4">PD</th>
            <th scope="col" class="px-6 py-4">Remarks</th>
            <th scope="col" class="px-6 py-4">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="prescription in paginatedPrescriptions" :key="prescription.id" class="border-b border-neutral-200 hover:bg-neutral-100">
            <td class="px-6 py-3 whitespace-nowrap">{{ new Date(prescription.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }}</td>
            <td class="px-6 py-3 whitespace-nowrap">{{ prescription.od }}</td>
            <td class="px-6 py-3 whitespace-nowrap">{{ prescription.os }}</td>
            <td class="px-6 py-3 whitespace-nowrap">{{ prescription.add }}</td>
            <td class="px-6 py-3 whitespace-nowrap">{{ prescription.pd }}</td>
            <td class="px-6 py-3 whitespace-nowrap">{{ prescription.remarks }}</td>
            <td class="px-6 py-3 whitespace-nowrap">
                <!-- Dropdown button for actions -->
                <button
                    @click.stop="toggleDropdown(prescription.id)"
                    class="inline-flex items-center text-sm font-medium hover:bg-gray-100  p-1.5 dark:hover:bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                >
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div v-if="dropdownOpen === prescription.id" class="absolute right-0 z-50 bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-1 text-sm">
                        <!-- Edit Button -->
                        <li>
                            <button @click.stop="openModal('edit', prescription)" class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-200">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                </svg>
                                Edit
                            </button>
                        </li>
                        <!-- Delete Button -->
                        <li>
                            <button @click.stop="openDeleteModal(prescription.id)" class="flex items-center w-full px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-red-400">
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
                        <!-- Export to Excel Button -->
                        <li>
                            <button
                                @click.stop="generateAndPrintPDF(prescription)"
                                class="flex items-center w-full px-4 py-2 text-yellow-600 hover:bg-yellow-100 dark:hover:bg-yellow-200"
                                title="Print Prescription"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9v10h12V9M6 5h12v4H6z" />
                                </svg>
                                Print Prescription
                            </button>
                        </li>
                    </ul>
                </div>
            </td>
          </tr>
        </tbody>
      </table>
       <!-- Pagination -->
       <div class="relative z-10 flex flex-col items-center justify-between p-4 border-t md:flex-row border-neutral-200">
            <span class="text-sm font-normal text-gray-500"> Showing <span class="font-semibold">{{ startItem }}</span> - <span class="font-semibold">{{ endItem }}</span> of <span class="font-semibold">{{ totalItems }}</span> </span>
            <ul class="inline-flex items-stretch mt-2 -space-x-px md:mt-0">
                <li>
                    <button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1.5 border rounded-l-lg">Prev</button>
                </li>
                <li v-for="page in totalPages" :key="page">
                    <button @click="changePage(page)" :class="['px-3 py-1.5 border', currentPage === page ? 'bg-gray-300' : 'bg-white']">
                        {{ page }}
                    </button>
                </li>
                <li>
                    <button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1.5 border rounded-r-lg">Next</button>
                </li>
            </ul>
        </div>
    </div>


    <div v-else-if="showTable === 'purchasedItems'" class="overflow-x-auto">
      <!-- Display message when no purchased items are available -->
      <div v-if="filteredPurchasedItems.length === 0" class="p-4 text-center">
        <p class="text-gray-500">No purchased items available.</p>
      </div>

      <!-- Purchased Items Table -->
      <table v-else class="min-w-full text-sm font-light text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
          <tr>
            <th scope="col" class="px-6 py-4">Date</th>
            <th scope="col" class="px-6 py-4">Item</th>
            <th scope="col" class="px-6 py-4">Quantity</th>
            <th scope="col" class="px-6 py-4">Price</th>
            <th scope="col" class="px-6 py-4">Total</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="transaction in paginatedPurchasedItems" :key="transaction.id">
            <tr class="border-b border-neutral-200 hover:bg-neutral-100">
              <td class="px-6 py-3 whitespace-nowrap" :rowspan="transaction.items.length">
                {{ new Date(transaction.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }}
              </td>
              <td class="px-6 py-3 whitespace-nowrap">{{ transaction.items[0].product.name }}</td>
              <td class="px-6 py-3 whitespace-nowrap">{{ transaction.items[0].quantity }}</td>
              <td class="px-6 py-3 whitespace-nowrap">₱{{ Number(transaction.items[0].price).toFixed(2) }}</td>
              <td class="px-6 py-3 whitespace-nowrap">₱{{ (Number(transaction.items[0].price) * transaction.items[0].quantity).toFixed(2) }}</td>
            </tr>
            <tr v-for="(item, index) in transaction.items.slice(1)" :key="index" class="border-b border-neutral-200 hover:bg-neutral-100">
              <td class="px-6 py-3 whitespace-nowrap">{{ item.product.name }}</td>
              <td class="px-6 py-3 whitespace-nowrap">{{ item.quantity }}</td>
              <td class="px-6 py-3 whitespace-nowrap">₱{{ Number(item.price).toFixed(2) }}</td>
              <td class="px-6 py-3 whitespace-nowrap">₱{{ (Number(item.price) * item.quantity).toFixed(2) }}</td>
            </tr>
          </template>
        </tbody>
      </table>
        <!-- Pagination Section -->
        <div class="relative z-10 flex flex-col items-center justify-between p-4 border-t md:flex-row border-neutral-200">
        <span class="text-sm font-normal text-gray-500">
            Showing <span class="font-semibold">{{ startPurchasedItem }}</span> - <span class="font-semibold">{{ endPurchasedItem }}</span> of <span class="font-semibold">{{ totalPurchasedItems }}</span>
            </span>
            <ul class="inline-flex items-stretch mt-2 -space-x-px md:mt-0">
                <li>
                <button @click="prevPurchasedItemsPage" :disabled="currentPurchasedItemsPage === 1" class="px-3 py-1.5 border rounded-l-lg">Prev</button>
                </li>
                <li v-for="page in totalPurchasedItemsPages" :key="page">
                <button @click="changePurchasedItemsPage(page)" :class="['px-3 py-1.5 border', currentPurchasedItemsPage === page ? 'bg-gray-300' : 'bg-white']">
                    {{ page }}
                </button>
                </li>
                <li>
                <button @click="nextPurchasedItemsPage" :disabled="currentPurchasedItemsPage === totalPurchasedItemsPages" class="px-3 py-1.5 border rounded-r-lg">Next</button>
                </li>
            </ul>
        </div>
    </div>
  </div>
        <AddPatientRecord :isOpen="addModal" :patientId="patient.id" @close="closeAddModal" @add="addRecord" />
        <!-- Edit Modal -->
        <EditPatientRecord :isOpen="editModal" :patientData="selectedPatient" @edit="handleEdit" @close="closeEditModal" />
        <EditModal :isOpen="editPatientModal" :patientData="selectedPatients" @close="closeModal" @edit="updatePatient" />
        <DeletePatientRecord :isOpen="deleteModal" :prescriptionId="selectedPrescriptionId" :patientId="patient.id" @close="closeDeleteModal" @delete="handleDelete" />
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Link } from "@inertiajs/inertia-vue3";
import { ref, defineProps, computed } from 'vue';
import { onMounted, onBeforeUnmount, watch } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import AddPatientRecord from './AddPatientRecord.vue';
import { Inertia } from '@inertiajs/inertia';
import { route } from 'ziggy-js';
import EditPatientRecord from './EditPatientRecord.vue';
import EditModal from './EditPatientModal.vue';
import DeletePatientRecord from './DeletePatientRecord.vue';
import { jsPDF } from "jspdf";
import autoTable from "jspdf-autotable";


    const props = defineProps({
        patient: Object,
        flash: Object,
        notifications: {
            type: Array,
            default: () => [], // Default to an empty array
        },
    });

    const showTable = ref('prescriptions'); // State to toggle between tables
//For purchased item table
    const patientData = computed(() => props.patient);
    // Pagination variables for purchased items
const currentPurchasedItemsPage = ref(1);
const itemsPerPurchasedItemsPage = ref(5);
// Compute total purchased items
const totalPurchasedItems = computed(() => patientData.value.transactions.length);

// Compute start and end indices for the current page
const startPurchasedItem = computed(() => (currentPurchasedItemsPage.value - 1) * itemsPerPurchasedItemsPage.value + 1);
const endPurchasedItem = computed(() => Math.min(currentPurchasedItemsPage.value * itemsPerPurchasedItemsPage.value, totalPurchasedItems.value));

// Compute paginated purchased items
const paginatedPurchasedItems = computed(() => {
  const start = (currentPurchasedItemsPage.value - 1) * itemsPerPurchasedItemsPage.value;
  const end = start + itemsPerPurchasedItemsPage.value;
  return patientData.value.transactions.slice(start, end);
});

// Calculate total pages for purchased items
const totalPurchasedItemsPages = computed(() => {
  return Math.ceil(patientData.value.transactions.length / itemsPerPurchasedItemsPage.value);
});

// Pagination navigation for purchased items
const prevPurchasedItemsPage = () => {
  if (currentPurchasedItemsPage.value > 1) currentPurchasedItemsPage.value--;
};

const nextPurchasedItemsPage = () => {
  if (currentPurchasedItemsPage.value < totalPurchasedItemsPages.value) currentPurchasedItemsPage.value++;
};
//end of purchased item table

    // State for dropdown visibility and notifications list
    const notifDropdownOpen = ref(false);

    // Toggle the dropdown visibility
    const toggleNotifDropdown = () => {
    notifDropdownOpen.value = !notifDropdownOpen.value;
    };

    const message = ref(props.flash?.message || '');
    const messageType = ref(props.flash?.message_type || 'info');
    console.log(message);
    console.log(messageType);
    const dropdownOpen = ref(null);
    const editModal = ref(false);
    const selectedPatient = ref(null);
    const deleteModal = ref(false);
    const editPatientModal = ref(false);
    const selectedPatients = ref(null);
    const selectedPrescriptionId = ref(null);
    const prescriptions = ref(props.patient?.prescriptions || []); // Safely access `patient.prescriptions`
    const currentPage = ref(1);
    const itemsPerPage = ref(5);

    const totalItems = computed(() => filteredPrescriptions.value.length);
    const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage.value));

    const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1);
    const endItem = computed(() => Math.min(currentPage.value * itemsPerPage.value, totalItems.value));

    const paginatedPrescriptions = computed(() =>
    prescriptions.value.slice(startItem.value - 1, endItem.value)
    );

    const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
    };

    const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
    };

    const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
    };

    const openDeleteModal = (prescriptionId) => {
    selectedPrescriptionId.value = prescriptionId;
    deleteModal.value = true;
    };

    const closeDeleteModal = () => {
    deleteModal.value = false;
    selectedPrescriptionId.value = null;
    };

    const filters = ref({
        startDate: '',
        endDate: ''
    });

const filteredPrescriptions = computed(() => {
  const start = filters.value.startDate ? new Date(`${filters.value.startDate}T00:00:00`) : null;
  const end = filters.value.endDate ? new Date(`${filters.value.endDate}T23:59:59`) : null;
  return patientData.value.prescriptions.filter((prescription) => {
    const date = new Date(prescription.created_at);
    return (!start || date >= start) && (!end || date <= end);
  });
});

const filteredPurchasedItems = computed(() => {
  const start = filters.value.startDate ? new Date(`${filters.value.startDate}T00:00:00`) : null;
  const end = filters.value.endDate ? new Date(`${filters.value.endDate}T23:59:59`) : null;
  return patientData.value.transactions.filter((transaction) => {
    const date = new Date(transaction.created_at);
    return (!start || date >= start) && (!end || date <= end);
  });
});

    const handleDelete = ({ prescriptionId, patientId }) => {
    Inertia.delete(`/patients/${patientId}/prescriptions/${prescriptionId}`, {
        onSuccess: () => {
        alert('Prescription deleted successfully!');
        deleteModal.value = false; // Close the modal
        },
        onError: (errors) => {
        console.error('Error deleting prescription:', errors);
        alert('Failed to delete the prescription.');
        },
    });
    };


    const handleEdit = (updatedData) => {
    console.log('Edited Patient Data:', updatedData);

    Inertia.put(`/patients/${props.patient.id}/prescriptions/${updatedData.id}`, updatedData, {
        onSuccess: () => {
        alert('Prescription updated successfully!');
        editModal.value = false; // Close the modal
        },
        onError: (errors) => {
        console.error('Error updating prescription:', errors);
        alert('Failed to update the prescription.');
        },
    });
    };


    const closeEditModal = () => {
        editModal.value = false;
    }

    const toggleDropdown = (id) => {
        dropdownOpen.value = dropdownOpen.value === id ? null : id; // Toggle dropdown based on id
    };

    const openModal = (type, item) => {
        closeDropdown(); // Close the dropdown whenever a modal is opened

        if (type === 'edit') {
            selectedPatient.value = item; // Set the selected patient
            editModal.value = true;
        }
    };

    const closeDropdown = () => {
        dropdownOpen.value = null;
    };


    onMounted(() => {
        setTimeout(() => {
            message.value = ''; // Clear the message after 3 seconds
            messageType.value = '';
        }, 3000);
    });

    const addModal = ref(false);
    const openAddModal = () => {
        addModal.value = true;
    };

    const closeAddModal = () => {
        addModal.value = false;
    };
        // Calculate Age Function
    const calculateAge = (dateOfBirth) => {
        if (!dateOfBirth) return null;
            const birthDate = new Date(dateOfBirth);
            const ageDiff = Date.now() - birthDate.getTime();
            const ageDate = new Date(ageDiff);
            return Math.abs(ageDate.getUTCFullYear() - 1970);
    };


    const addRecord = (data) => {
    Inertia.post(`/patients/${props.patient.id}/prescriptions`, data, {
        preserveScroll: true,
        onSuccess: (response) => {
            // Update the prescriptions with the latest data
            prescriptions.value = response.props.patient.prescriptions;

            // Find the newly added prescription
            const newPrescription = prescriptions.value.find(
                (prescription) => prescription.id === response.props.newPrescriptionId
            );

            console.log("New Prescription:", newPrescription); // Debugging

            // Generate and print the PDF
            if (newPrescription) {
                generateAndPrintPDF(newPrescription);
            } else {
                alert("New prescription not found.");
            }

            // Close the Add Modal
            closeAddModal();
        },
        onError: (errors) => {
            console.error("Error adding prescription:", errors);
            alert("Failed to add the prescription. Please try again.");
        },
    });
};



    const opeEditPatientModal = () => {
        editPatientModal.value = true;
        selectedPatients.value = props.patient;
        }

        const closeModal = () => {
            editPatientModal.value = false;
            };

            const updatePatient = (updatedPatient) => {
            console.log('Updated patient data:', updatedPatient); // Check updated patient data
            Inertia.put(route('patients.update', updatedPatient.id), updatedPatient, {
                onSuccess: () => {
                flashMessage.value = 'Patient updated successfully!';
                close();
                },
                onError: (errors) => {
                console.error('Error updating patient:', errors);
                flashMessage.value = 'Error updating patient. Please try again.';
                },
            });
            };

    // Automatically dismiss the alert after 3 seconds
watch([message, messageType], () => {
    if (message.value) {
        setTimeout(() => {
            message.value = '';
            messageType.value = '';
        }, 3000);
    }
});

const generateAndPrintPDF = (prescription) => {

// Initialize jsPDF in A5 Landscape
const doc = new jsPDF({
orientation: "landscape",
unit: "mm",
format: "A5",
});

// Define colors and styles
const headerBgColor = "#FF0000"; // Red
const headerTextColor = "#FFFFFF"; // White
const footerBgColor = "#FF0000"; // Red
const footerTextColor = "#FFFFFF"; // White



//Add logo
const logo = new Image();
logo.src = '/images/logo.png';
doc.addImage(logo, 'PNG', 30, 3, 25, 20);

doc.setFontSize(18);
doc.setFont('Helvetica', 'bold');
doc.setTextColor('#e74c3c');
doc.text("Hollywood Spectacles Optical", 105, 10, { align: "center" });

doc.setFontSize(12);
doc.setFont('Roboto', 'normal');
doc.setTextColor('#000');
doc.text("Aguinaldo Street, Iligan City", 105, 15, { align: "center" });
doc.text("Contact No: 091277747297", 105, 20, { align: "center" });

doc.setDrawColor(231, 76, 60);
doc.line(10, 25, 200, 25);

//Add Patient Name
doc.setFontSize(14);
doc.setTextColor("black");
doc.text(`Name: ${props.patient.first_name} ${props.patient.last_name}`, 20, 40); // Name on the left
doc.text(`Date: ${new Date(prescription.created_at).toLocaleDateString()}`, 150, 37); // Date below the name

// Rx Symbol - Bungig Style
doc.setFontSize(50);
doc.setFont('Roboto', 'normal');
doc.setTextColor("#FF0000"); // Red color for Rx symbol
doc.text("Rx", 15, 65, { align: "left" }); // Place Rx below name, left-aligned


// Table Head
const tableHead = [["OD", "OS", "ADD", "PD", "Remarks"]];

// Table Body
const tableBody = [[
prescription.od || "",
prescription.os || "",
prescription.add || "",
prescription.pd || "",
prescription.remarks || ""
]];

// Generate the table using autoTable
// Generate the table using autoTable
doc.autoTable({
startY: 73, // Starting Y position
head: tableHead, // Header row
body: tableBody, // Data rows
theme: "grid", // Table theme (grid for borders)
styles: {
    fontSize: 12, // General font size
    halign: "center", // Horizontal alignment for all cells
    overflow: 'linebreak', // Wrap text if it exceeds cell width
},
headStyles: {
    fillColor: [255, 0, 0], // Red background for header
    textColor: [255, 255, 255], // White text for header
    fontStyle: "bold", // Bold text for header
},
bodyStyles: {
    cellPadding: 4, // Padding for table cells
},
columnStyles: {
    4: { // Specific column (index 4: Remarks)
        cellWidth: 'wrap', // Enable text wrapping for Remarks
        halign: "left", // Align text to the left for Remarks
    },
},
});



const tableEndY = doc.lastAutoTable.finalY; // Get the Y position where the table ends
doc.setFontSize(12);
doc.text("Prescribed by: Dr. Dializa Remedios", 125, tableEndY + 23); // Add text below the table on the left side
doc.text("Licensed No.:______________________", 125, tableEndY + 28);

// // Add Footer
// const pageHeight = doc.internal.pageSize.height;
//     doc.setFontSize(10);
//     doc.setFont('Helvetica', 'normal');
//     doc.setTextColor('#000');
//     doc.text("Generated by Hollywood Spectacles Optical", 105, pageHeight - 10, { align: "center" });


// 	//Add a border line
// 	doc.setDrawColor(231, 76, 60);
// 	doc.line(15, pageHeight - 15, 195, pageHeight - 15);


    // Output the PDF as a Blob
    const pdfBlob = doc.output("blob");

    dropdownOpen.value = false;

    // Create a hidden iframe
    const iframe = document.createElement("iframe");
    iframe.style.position = "absolute";
    iframe.style.width = "1px";
    iframe.style.height = "1px";
    iframe.style.top = "-9999px"; // Hide the iframe
    document.body.appendChild(iframe);

    // Use the Blob URL as the iframe source
    const pdfURL = URL.createObjectURL(pdfBlob);
    iframe.src = pdfURL;

    // Trigger printing only when the iframe is fully loaded
    iframe.onload = () => {
        try {
            iframe.contentWindow.focus(); // Ensure the iframe content is focused
            iframe.contentWindow.print(); // Trigger the print dialog

            // Keep the iframe in the DOM until the user interacts with the print dialog
            console.log("Print dialog triggered. Waiting for user interaction...");
        } catch (error) {
            console.error("Error triggering print dialog:", error);
        }
    };

    // Add cleanup on unload to ensure it doesn't interfere with the print dialog
    window.addEventListener("afterprint", () => {
        console.log("Print completed. Cleaning up resources.");
        document.body.removeChild(iframe);
        URL.revokeObjectURL(pdfURL);
    });
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
