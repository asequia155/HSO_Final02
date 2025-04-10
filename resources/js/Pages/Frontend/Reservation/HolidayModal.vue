<template>
    <!-- Modal Overlay -->
    <div
      v-if="isOpen"
      class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50"
    >
      <!-- Modal Content -->
      <div
        class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800"
      >
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-4 py-3 pb-4 bg-red-500 rounded-t-lg">
          <h3 class="text-lg font-bold text-white">
            All Holidays
          </h3>
          <button
            @click="close"
            aria-label="Close"
            class="text-white hover:text-gray-200"
          >
            <span class="text-2xl">&times;</span>
          </button>
        </div>
<!-- Year Filter -->
<div class="my-4">
          <label for="yearFilter" class="block mb-1 font-medium text-gray-700 dark:text-gray-200">Filter by Year:</label>
          <select
            id="yearFilter"
            v-model="selectedYear"
            @change="filterHolidaysByYear"
            class="w-full p-2 border rounded-md dark:bg-gray-700 dark:text-gray-300"
          >
            <option v-for="year in availableYears" :key="year" :value="year">{{ year }}</option>
          </select>
        </div>
        <!-- Modal Body -->
        <div class="mt-4">
          <!-- Loading Indicator -->
          <div v-if="loading" class="text-center text-gray-500">
            Loading holidays...
          </div>

          <!-- Holiday List -->
          <ul
            v-else-if="paginatedHolidays.length"
            class="space-y-4"
          >
            <li
              v-for="holiday in paginatedHolidays"
              :key="holiday.id"
              class="flex items-center justify-between p-3 bg-gray-100 rounded-md"
            >
              <div>
                <p class="text-sm font-medium text-gray-900">{{ holiday.name }}</p>
                <p class="text-xs text-gray-600">
                  {{ formatDate(holiday.date) }}
                </p>
              </div>
              <!-- Delete Button -->
              <button
                @click="openDeleteModal(holiday)"
                class="px-2 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-700"
              >
                Delete
              </button>
            </li>
          </ul>

          <!-- No Holidays Available -->
          <p v-else class="text-center text-gray-500">
            No holidays available.
          </p>
        </div>

        <!-- Pagination -->
        <div
          v-if="totalPages > 1"
          class="flex items-center justify-between mt-6"
        >
          <span class="text-sm text-gray-500">
            Showing <span class="font-semibold">{{ startItem }}</span> -
            <span class="font-semibold">{{ endItem }}</span> of
            <span class="font-semibold">{{ totalItems }}</span>
          </span>
          <ul class="inline-flex items-center space-x-1">
            <li>
              <button
                @click="prevPage"
                :disabled="currentPage === 1"
                class="px-3 py-1 border rounded-l"
              >
                Prev
              </button>
            </li>
            <li v-if="currentPage > 3">
              <button
                @click="changePage(1)"
                class="px-3 py-1 bg-white border"
              >
                1
              </button>
              <span class="px-2">...</span>
            </li>
            <li
              v-for="page in visiblePages"
              :key="page"
            >
              <button
                @click="changePage(page)"
                :class="[ 'px-3 py-1 border', currentPage === page ? 'bg-gray-300' : 'bg-white' ]"
              >
                {{ page }}
              </button>
            </li>
            <li v-if="currentPage < totalPages - 2">
              <span class="px-2">...</span>
              <button
                @click="changePage(totalPages)"
                class="px-3 py-1 bg-white border"
              >
                {{ totalPages }}
              </button>
            </li>
            <li>
              <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
                class="px-3 py-1 border rounded-r"
              >
                Next
              </button>
            </li>
          </ul>
        </div>

        <!-- Modal Footer -->
        <div class="mt-6 text-right">
          <button
            @click="close"
            class="px-4 py-2 text-sm text-gray-600 bg-gray-200 rounded hover:bg-gray-300"
          >
            Close
          </button>
        </div>
      </div>
    </div>

    <!-- Delete Holiday Modal -->
    <DeleteHolidayModal
    :isOpen="deleteModalOpen"
    :holidayId="selectedHolidayId"
    :holidayName="selectedHolidayName"
    @close="closeDeleteHolidayModal"
    @refreshHolidays="fetchHolidays"
/>

  </template>

  <script setup>
  import { ref, computed, watch } from "vue";
  import axios from "axios";
  import DeleteHolidayModal from "./DeleteHolidayModal.vue";

  const props = defineProps({
    isOpen: Boolean, // Track when the modal is open
  });

  const emit = defineEmits(["close", "refreshHolidays"]);

  const holidays = ref([]);
  const loading = ref(false);
  const deleteModalOpen = ref(false);
  const selectedHolidayId = ref(null);
  const selectedHolidayName = ref("");
  const currentPage = ref(1);
  const itemsPerPage = ref(5);
  const filteredHolidays = ref([]); // Holds holidays filtered by year
const selectedYear = ref(new Date().getFullYear()); // Default to the current year
const availableYears = computed(() => {
    // Generate a list of unique years from holidays
    const years = [...new Set(holidays.value.map((holiday) => new Date(holiday.date).getFullYear()))];
    if (!selectedYear.value && years.length > 0) {
        selectedYear.value = years[0]; // Default to the first available year
    }
    return years;
});



const filterHolidaysByYear = () => {
  // Filter holidays by the selected year
  filteredHolidays.value = holidays.value.filter(
    (holiday) => new Date(holiday.date).getFullYear() === selectedYear.value
  );
  currentPage.value = 1; // Reset pagination
};

const totalItems = computed(() => filteredHolidays.value.length);
  const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage.value));
  const startItem = computed(() => Math.min((currentPage.value - 1) * itemsPerPage.value + 1, totalItems.value));
  const endItem = computed(() => Math.min(currentPage.value * itemsPerPage.value, totalItems.value));

  const paginatedHolidays = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return filteredHolidays.value.slice(start, start + itemsPerPage.value);
});

  const visiblePages = computed(() => {
    const pages = [];
    const maxVisible = 5;
    let startPage = Math.max(currentPage.value - 2, 1);
    let endPage = Math.min(currentPage.value + 2, totalPages.value);

    if (totalPages.value > maxVisible) {
      if (currentPage.value <= 3) {
        endPage = maxVisible;
      } else if (currentPage.value >= totalPages.value - 2) {
        startPage = totalPages.value - (maxVisible - 1);
      }
    }

    for (let i = startPage; i <= endPage; i++) {
      pages.push(i);
    }
    return pages;
  });


const fetchHolidays = async () => {
    loading.value = true;
    try {
        const response = await axios.get(route("reservations.fetchHolidays"));
        holidays.value = response.data;
        filterHolidaysByYear(); // Apply year filter immediately
    } catch (error) {
        console.error("Error fetching holidays:", error);
    } finally {
        loading.value = false;
    }
};

  // Watch for when the modal is opened to fetch holidays
  watch(
    () => props.isOpen,
    (newVal) => {
      if (newVal) {
        fetchHolidays();
      }
    }
  );

  const changePage = (page) => {
    currentPage.value = page;
  };

  const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
  };

  const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
  };

  const openDeleteModal = (holiday) => {
    selectedHolidayId.value = holiday.id;
    selectedHolidayName.value = holiday.name;
    deleteModalOpen.value = true;

  };

  const closeDeleteHolidayModal = () => {
    deleteModalOpen.value = false; // Close the delete modal
    fetchHolidays(); // Refresh the list of holidays
};

  const close = () => {
    emit("close");
  };

  const formatDate = (date) => {
    const parsedDate = new Date(date);
    return isNaN(parsedDate.getTime())
      ? "Invalid Date"
      : parsedDate.toLocaleDateString("en-US", {
          year: "numeric",
          month: "long",
          day: "numeric",
        });
  };
  </script>

  <style scoped>
  /* Modal hover effect */
  ul li:hover {
    background-color: #db8181;
  }
  </style>
