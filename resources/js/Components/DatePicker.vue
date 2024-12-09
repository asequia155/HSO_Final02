<template>
    <div class="relative w-full max-w-md mx-auto">
      <input
        v-model="formattedDate"
        @click="toggleDatepicker"
        type="text"
        placeholder="Select date"
        class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-purple-300"
        readonly
      />
  
      <div v-if="isDatepickerVisible" class="absolute w-full mt-2 bg-white border rounded-lg shadow-lg z-50">
        <!-- Datepicker Header -->
        <div class="flex items-center justify-between px-4 py-2 border-b">
          <button @click="prevMonth" class="text-gray-600 hover:text-purple-500">
            Prev
          </button>
  
          <div class="flex items-center space-x-2">
            <select v-model="selectedMonth" class="px-2 py-1 border rounded">
              <option v-for="(month, index) in months" :key="index" :value="index">
                {{ month }}
              </option>
            </select>
            <input
              v-model="selectedYear"
              type="number"
              class="w-16 px-2 py-1 border rounded focus:outline-none focus:ring focus:ring-purple-300"
            />
          </div>
  
          <button @click="nextMonth" class="text-gray-600 hover:text-purple-500">
            Next
          </button>
        </div>
  
        <!-- Days Header -->
        <div class="grid grid-cols-7 gap-2 px-4 py-2 text-center">
          <span class="text-sm font-semibold text-gray-600" v-for="day in days" :key="day">
            {{ day }}
          </span>
        </div>
  
        <!-- Dates -->
        <div class="grid grid-cols-7 gap-2 px-4 py-2">
          <button
            v-for="date in calendar"
            :key="date.key"
            :disabled="date.disabled"
            @click="selectDate(date.date)"
            :class="[
              'px-2 py-1 text-sm rounded',
              date.today ? 'bg-purple-100 text-purple-500' : '',
              date.selected ? 'bg-purple-500 text-white' : '',
              date.disabled ? 'text-gray-400 cursor-not-allowed' : 'hover:bg-gray-200'
            ]"
          >
            {{ date.day }}
          </button>
        </div>
  
        <!-- Footer -->
        <div class="flex justify-end px-4 py-2 border-t">
          <button @click="cancel" class="px-4 py-2 text-sm text-gray-600 hover:text-purple-500">
            Cancel
          </button>
          <button
            @click="apply"
            class="px-4 py-2 ml-2 text-sm text-white bg-purple-500 rounded hover:bg-purple-600"
          >
            Apply
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  const isDatepickerVisible = ref(false);
  const selectedDate = ref(new Date());
  const selectedYear = ref(new Date().getFullYear());
  const selectedMonth = ref(new Date().getMonth());
  const formattedDate = ref("");
  
  const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  
  const calendar = computed(() => {
    const firstDayOfMonth = new Date(selectedYear.value, selectedMonth.value, 1).getDay();
    const lastDateOfMonth = new Date(selectedYear.value, selectedMonth.value + 1, 0).getDate();
    const lastDayOfPrevMonth = new Date(selectedYear.value, selectedMonth.value, 0).getDate();
  
    let dates = [];
    // Last week of previous month
    for (let i = firstDayOfMonth - 1; i >= 0; i--) {
      dates.unshift({
        day: lastDayOfPrevMonth - i,
        date: new Date(selectedYear.value, selectedMonth.value - 1, lastDayOfPrevMonth - i),
        disabled: true,
        today: false,
        selected: false,
        key: `prev-${i}`,
      });
    }
  
    // Current month
    for (let i = 1; i <= lastDateOfMonth; i++) {
      const date = new Date(selectedYear.value, selectedMonth.value, i);
      dates.push({
        day: i,
        date,
        disabled: false,
        today: isToday(date),
        selected: isSelected(date),
        key: `current-${i}`,
      });
    }
  
    // First week of next month
    const remainingDays = 42 - dates.length;
    for (let i = 1; i <= remainingDays; i++) {
      dates.push({
        day: i,
        date: new Date(selectedYear.value, selectedMonth.value + 1, i),
        disabled: true,
        today: false,
        selected: false,
        key: `next-${i}`,
      });
    }
  
    return dates;
  });
  
  const toggleDatepicker = () => {
    isDatepickerVisible.value = !isDatepickerVisible.value;
  };
  
  const cancel = () => {
    isDatepickerVisible.value = false;
  };
  
  const apply = () => {
    formattedDate.value = selectedDate.value.toLocaleDateString("en-US", {
      year: "numeric",
      month: "2-digit",
      day: "2-digit",
    });
    isDatepickerVisible.value = false;
  };
  
  const selectDate = (date) => {
    selectedDate.value = date;
  };
  
  const prevMonth = () => {
    if (selectedMonth.value === 0) {
      selectedMonth.value = 11;
      selectedYear.value--;
    } else {
      selectedMonth.value--;
    }
  };
  
  const nextMonth = () => {
    if (selectedMonth.value === 11) {
      selectedMonth.value = 0;
      selectedYear.value++;
    } else {
      selectedMonth.value++;
    }
  };
  
  const isToday = (date) => {
    const today = new Date();
    return (
      today.getFullYear() === date.getFullYear() &&
      today.getMonth() === date.getMonth() &&
      today.getDate() === date.getDate()
    );
  };
  
  const isSelected = (date) => {
    return (
      selectedDate.value.getFullYear() === date.getFullYear() &&
      selectedDate.value.getMonth() === date.getMonth() &&
      selectedDate.value.getDate() === date.getDate()
    );
  };
  </script>
  
  <style scoped>
  /* Optional Tailwind Customizations */
  </style>
  