<template>
    <div class="p-4 bg-white rounded-lg shadow-lg mt-7">
      <div class="reservations">
        <h2 class="mb-4 text-xl font-semibold">Today's Appointments</h2>
        <div v-if="limitedTodaysReservationList.length">
            <table class="min-w-full text-sm font-light text-left text-gray-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
              <tr>
                <th scope="col" class="px-6 py-4">Name</th>
                <th scope="col" class="px-6 py-4">Date</th>
                <th scope="col" class="px-6 py-4">Time</th>
              </tr>
            </thead>
            <tbody>
              <tr
              v-for="reservation in limitedTodaysReservationList"
                :key="reservation.id"
                class="transition border-b cursor-pointer border-neutral-200 hover:bg-neutral-100"
              >
                <td class="px-6 py-3 whitespace-nowrap">
                  {{ reservation.first_name }} {{ reservation.middle_name }} {{ reservation.last_name }}
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                  {{ new Date(reservation.appointment_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }}
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                  {{ formatTo12Hour(reservation.appointment_time) }}
                </td>
              </tr>
            </tbody>
          </table>
          <div class="flex justify-center mt-4">
            <Link :href="route('reservations.index')" class="mb-3 font-bold text-gray-700">
              Show All Appointments
            </Link>
          </div>
        </div>
        <div v-else>
          <p class="text-gray-600">No appointments for today.</p>
        </div>
      </div>
    </div>
  </template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

// Define props
const props = defineProps({
  TodaysReservationList: {
    type: Array,
    required: true,
  },
});

// Function to format time to 12-hour format
const formatTo12Hour = (time) => {
  const [hour, minute] = time.split(":");
  let hourIn12 = parseInt(hour, 10);
  const period = hourIn12 >= 12 ? "PM" : "AM";
  hourIn12 = hourIn12 % 12 || 12; // Convert 0 or 12 to 12 in 12-hour format
  return `${hourIn12}:${minute} ${period}`;
};

// Filter and sort reservations for today's date and time range
const todayDate = new Date().toISOString().split("T")[0];
const filteredTodaysReservationList = computed(() => {
  return props.TodaysReservationList.filter((reservation) => {
    if (reservation.appointment_date !== todayDate) return false;

    // Parse the appointment time
    const [hour] = reservation.appointment_time.split(":").map(Number);

    // Check if the time is between 8:00 AM and 5:00 PM
    return hour >= 7 && hour < 18; // 17 is exclusive to ensure it ends before 5:00 PM
  }).sort((a, b) => {
    // Sort by time in ascending order
    const timeA = a.appointment_time;
    const timeB = b.appointment_time;
    return timeA.localeCompare(timeB);
  });
});
// Limit the list to the first 5 appointments
const limitedTodaysReservationList = computed(() => {
  return filteredTodaysReservationList.value.slice(0, 5);
});
</script>

  <style scoped>
  .shadow-md {
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
  .shadow-sm {
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
  }
  </style>
