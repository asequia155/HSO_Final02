<template>
    <DashboardLayout>
    <div class="container p-6 mx-auto">
        <div class="p-8 bg-white rounded-lg shadow-md">


            <!-- Header -->
            <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">
                Schedule Your Appointment
            </h1>
            <p class="mb-8 text-center text-gray-600">
                Select a preferred date and time for your appointment.
            </p>
            <p class="mt-4 text-2xl font-semibold text-center text-gray-600">
    Month: <span class="px-2 py-1 font-bold text-white bg-red-500 rounded text--800">{{ currentMonthName }}</span>
</p>



            <!-- Calendar Navigation -->
            <div class="flex items-center justify-between mb-6">

                <button
                    @click="prevMonth"
                    class="px-4 py-2 font-medium text-white bg-red-500 rounded-md shadow hover:bg-red-600"
                >
                    Previous
                </button>

                <p class="mt-4 text-2xl text-center text-gray-600">
                    Today is: <span class="font-bold text-gray-800">{{ formattedCurrentDate }}</span>
                </p>

                <button
                    @click="nextMonth"
                    class="px-4 py-2 font-medium text-white bg-red-500 rounded-md shadow hover:bg-red-600"
                >
                    Next
                </button>
            </div>

            <!-- Days of the Week -->
            <div class="grid grid-cols-7 mb-4 font-semibold text-center text-gray-600 uppercase">
                <div v-for="(day, index) in daysOfWeek" :key="index" class="py-2">
                    {{ day }}
                </div>
            </div>

            <!-- Calendar Dates -->
            <div class="grid grid-cols-7 gap-1">
                <div
                    v-for="(day, index) in days"
                    :key="index"
                    class="relative text-center"
                >
                    <button
                        :class="{
                            'bg-red-600 text-white': isSelectedDate(day.date),
                            'bg-gray-300 text-black cursor-not-allowed': day.isDayOff || day.isPast,
                            'bg-red-300 hover:bg-red-500 text-gray-800': !day.isDayOff && !day.isPast && !isSelectedDate(day.date),
                            'bg-white': day.date === null,
                        }"
        :disabled="day.isDayOff || day.isPast"
        @click="selectDate(day.date)"
                        class="w-full p-4 transition-all duration-150 rounded-md shadow-sm"
                    >
                        {{ day.date ? day.date.getDate() : '' }}
                    </button>
                    <!-- Holiday Name -->
                    <p
                        v-if="day.isHoliday"
                        class="absolute bottom-0 left-0 w-full mt-1 text-xs text-center text-red-600"
                    >
                        {{ day.holidayName }}
                    </p>
                </div>
            </div>

            <!-- Selected Date -->
            <div v-if="selectedDate" class="mt-8 text-center">
                <h3 class="text-lg font-semibold text-gray-800">
                    Selected Date: <span class="text-red-600">{{ selectedDate.toDateString() }}</span>
                </h3>
            </div>

            <!-- Time Slots -->
            <div v-if="selectedDate" class="mt-6">
                <table class="w-full overflow-hidden border border-collapse border-gray-300 rounded-lg shadow-sm">
                    <thead>
                        <tr class="text-gray-700 bg-gray-200">
                            <th class="p-3 border">Time</th>
                            <th class="p-3 border">Available Slots</th>
                            <th class="p-3 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="slot in timeSlots"
                            :key="slot.time"
                            :class="{ 'bg-gray-100': slot.isFull }"
                        >
                        <td class="p-4 text-center text-gray-600 border">{{ slot.time }}</td>
<td class="p-4 text-center text-gray-600 border">
    {{ slot.isFull ? 'Full' : slot.slots }}
</td>
<td class="p-4 text-center border">
    <button
        v-if="!slot.isFull"
        @click="selectTime(slot.time)"
        :class="{
            'bg-red-600 text-white': form.appointmentTime === slot.time,
            'bg-gray-100 text-gray-600 cursor-not-allowed': slot.isFull || slot.isPast,
            'hover:bg-red-400 hover:text-white': !slot.isFull && !slot.isPast,
        }"
        :disabled="slot.isFull || slot.isPast"
        class="px-4 py-2 transition-all duration-150 rounded-md shadow-md"
    >
        Select
    </button>
</td>

<p v-if="errors.appointmentTime" class="mt-2 text-sm text-red-500">
        {{ errors.appointmentTime }}
    </p>

                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Form -->
            <form @submit.prevent="handleSubmit" class="p-6 mt-8 space-y-6 rounded-lg shadow-lg bg-gray-50">
                <!-- Remarks -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Remarks</label>
                    <textarea
                        v-model="form.remarks"
                        placeholder="Enter any additional remarks..."
                        class="w-full px-4 py-2 border rounded-md"
                    ></textarea>
                    <span v-if="errors.remarks" class="text-sm text-red-500">{{ errors.remarks }}</span>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button
                        type="button"
                        @click="prepareSubmission"
                        class="px-6 py-3 font-medium text-white transition-all duration-150 bg-blue-500 rounded-lg shadow-md hover:bg-blue-600"
                        :disabled="form.processing || !form.appointmentTime || !form.appointmentDate"
                        >
                        Submit
                    </button>

                </div>
            </form>
        </div>

        <!-- Custom Modal -->

        <Modal
    v-model:show="showModal"
    title="Confirm Reservation"
    message="Are you sure you want to submit this reservation?"
    :data="{
        appointmentDate: form.appointmentDate,
        appointmentTime: form.appointmentTime,
        remarks: form.remarks
    }"
                @confirm="submit"

/>
    </div>
</DashboardLayout>
</template>




<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Modal from '@/Pages/Frontend/User/Modal.vue';
import { computed } from 'vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Inertia } from '@inertiajs/inertia';


const currentMonthName = computed(() => {
    return months[monthIndex.value];
});

const formattedCurrentDate = computed(() => {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    return now.toLocaleDateString('en-US', options);
});


const daysOfWeek = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
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

const currentDate = ref(new Date());
const year = ref(currentDate.value.getFullYear());
const monthIndex = ref(currentDate.value.getMonth());
const selectedDate = ref(null);
const timeSlots = ref([]);


const form = useForm({
    remarks: '',
    appointmentDate: '',
    appointmentTime: '',
});

const isSelectedDate = (date) => {
    return selectedDate.value && date && date.getTime() === selectedDate.value.getTime();
};

const errors = ref({});

const allTimeSlots = [
    { time: "08:00 AM" },
    { time: "09:00 AM" },
    { time: "10:00 AM" },
    { time: "11:00 AM" },
    { time: "12:00 PM" },
    { time: "01:00 PM" },
    { time: "02:00 PM" },
    { time: "03:00 PM" },
    { time: "04:00 PM" },
    { time: "05:00 PM" },
];


const days = ref([]);
const holidays = ref([]); // List of holidays
const isPastTime = (time) => {
    const now = new Date();
    const [hour, minute] = time.split(/[: ]/);
    const isPM = time.includes("PM");
    let hourIn24 = parseInt(hour, 10);

    if (isPM && hourIn24 !== 12) hourIn24 += 12; // Convert to 24-hour format
    if (!isPM && hourIn24 === 12) hourIn24 = 0; // Handle 12 AM

    const slotTime = new Date();
    slotTime.setHours(hourIn24, parseInt(minute, 10), 0, 0);

    return slotTime < now; // Compare slot time with current time
};



const generateDays = () => {
    const daysInMonth = new Date(year.value, monthIndex.value + 1, 0).getDate();
    const firstDayOfMonth = new Date(year.value, monthIndex.value, 1).getDay();
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset time for comparison


    days.value = Array.from({ length: firstDayOfMonth }, () => ({
        date: null,
        isDayOff: false,
        isHoliday: false,
        holidayName: null,
        isPast: false,

    }));

    for (let i = 1; i <= daysInMonth; i++) {
        const date = new Date(year.value, monthIndex.value, i);
        const holiday = holidays.value.find(
            (h) => new Date(h.date).toDateString() === date.toDateString()
        );

        days.value.push({
            date,
            isDayOff: date.getDay() === 0 || date.getDay() === 6 || !!holiday, // Treat holidays as days off
            isHoliday: !!holiday,
            holidayName: holiday ? holiday.name : null,
            isPast: date < today, // Check if the date is in the past

        });
    }
};





generateDays();


const nextMonth = () => {
    if (monthIndex.value === 11) {
        monthIndex.value = 0;
        year.value++;
    } else {
        monthIndex.value++;
    }
    generateDays();
};

const prevMonth = () => {
    if (monthIndex.value === 0) {
        monthIndex.value = 11;
        year.value--;
    } else {
        monthIndex.value--;
    }
    generateDays();
};

const selectDate = async (date) => {
    selectedDate.value = date;

    // Format date as YYYY-MM-DD
    const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, "0")}-${String(date.getDate()).padStart(2, "0")}`;
    form.appointmentDate = formattedDate;

    // Fetch booked slots from the backend
    try {
        const response = await axios.get(route('reservations.slots'), { params: { date: formattedDate } });
        const bookedSlots = response.data;

        const today = new Date();
        const isToday = date.toDateString() === today.toDateString();

        // Update available time slots based on bookings and current time
        timeSlots.value = allTimeSlots.map((slot) => {
            const bookedSlot = bookedSlots.find((b) => b.appointment_time === formatTime(slot.time));
            const slotsAvailable = bookedSlot ? Math.max(2 - bookedSlot.count, 0) : 2; // Max slots = 2

            const isPast = isToday && isPastTime(slot.time); // Disable past times only for today's date

            return {
                ...slot,
                slots: slotsAvailable,
                isFull: slotsAvailable === 0 || isPast,
                isPast, // Add a flag to indicate past time
            };
        });
    } catch (error) {
        console.error("Error fetching booked slots:", error);
        alert("Failed to fetch available slots.");
    }
};

// Helper function to format AM/PM time to HH:MM:SS
const formatTime = (time) => {
    const timeParts = time.split(/[: ]/);
    let hours = parseInt(timeParts[0], 10);
    const minutes = timeParts[1];
    const meridian = timeParts[2];

    if (meridian === "PM" && hours !== 12) hours += 12;
    if (meridian === "AM" && hours === 12) hours = 0;

    return `${String(hours).padStart(2, "0")}:${minutes}:00`;
};


const selectTime = (time) => {
    form.appointmentTime = time;
};

const validateForm = () => {
    errors.value = {};
    if (!form.appointmentDate) errors.value.appointmentDate = "Date is required.";
    if (!form.appointmentTime) errors.value.appointmentTime = "Time is required.";


    console.log(errors.value); // Log validation errors
    return Object.keys(errors.value).length === 0;
};



const prepareSubmission = () => {
    if (validateForm()) {
        showModal.value = true;
    }
};

const submit = async () => {
    if (validateForm()) {
        // Format date and time as needed
        if (selectedDate.value) {
            form.appointmentDate = `${selectedDate.value.getFullYear()}-${String(selectedDate.value.getMonth() + 1).padStart(2, "0")}-${String(selectedDate.value.getDate()).padStart(2, "0")}`;
        }

        if (form.appointmentTime) {
            const timeParts = form.appointmentTime.split(/[: ]/);
            let hours = parseInt(timeParts[0], 10);
            const minutes = timeParts[1];
            const meridian = timeParts[2];

            if (meridian === "PM" && hours !== 12) hours += 12;
            if (meridian === "AM" && hours === 12) hours = 0;

            form.appointmentTime = `${String(hours).padStart(2, "0")}:${minutes}:00`;
        }

        try {
            console.log("Submitting form data:", form.data());
            await form.post(route("user.applyReservation.store"), {
                onSuccess: () => {
                    Inertia.visit(route('user.applyReservation'));
                },
                onError: (errors) => {
                    console.error("Error submitting the form:", errors);
                    alert("Error submitting the form.");
                },
            });
        } catch (error) {
            console.error("Error submitting the form:", error.response?.data || error);
            alert("Error submitting the form.");
        }
    }
};


onMounted(() => {
    // Removed automatic date selection
});


const showModal = ref(false);

const handleModalConfirm = () => {
    console.log("User clicked OK");
    // You can add more actions here, like redirecting
};
const capitalizeFirstLetter = (field) => {
    form[field] = form[field]
        .replace(/\b\w/g, (char) => char.toUpperCase()) // Capitalize the first letter of each word
        .replace(/[^a-zA-Z\s]/g, ''); // Remove any non-alphabetic characters except spaces
};


const getHolidayName = (date) => {
    const holiday = holidays.value.find(
        (holiday) => new Date(holiday.date).toDateString() === date.toDateString()
    );
    return holiday ? holiday.name : '';
};
//
// Fetch holidays from the backend
const fetchHolidays = async () => {
    try {
        const response = await axios.get(route('reservations.fetchHolidays')); // Use the correct route name
        holidays.value = response.data;
        generateDays(); // Refresh the calendar days after fetching holidays
    } catch (error) {
        console.error("Error fetching holidays:", error);
        alert("Failed to fetch holidays.");
    }
};


onMounted(async () => {
    await fetchHolidays(); // Fetch holidays and initialize calendar
});
</script>

<style scoped>
textarea {
    min-height: 100px;
}

/* Custom Media Query */
@media (max-width: 767px) {
    .back-desktop {
        display: none; /* Hide desktop version on mobile */
    }

    .back-mobile {
        display: flex;
        justify-content: center;
        align-items:center;; /* Show mobile version */
    }
}

@media (min-width: 768px) {
    .back-desktop {
        display: block; /* Show desktop version */
    }

    .back-mobile {
        display: none; /* Hide mobile version */
    }
}


button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.grid div:empty {
    visibility: hidden;
}
</style>

