<template>
    <div class="p-6 mt-10 bg-white rounded-lg shadow-lg chart-container">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Total Sales Overview</h2>
        <!-- Dropdown filter -->
        <div class="relative">
          <label for="filter" class="sr-only">Filter by</label>
          <select
            id="filter"
            v-model="selectedFilter"
            class="block w-48 px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm"
            @change="applyFilter"
            @click="toggleDropdown"
          >
            <option value="all">All</option>
            <option value="last7days">Last 7 Days</option>
            <option value="last30days">Last 30 Days</option>
            <option value="lastYear">Last Year</option>
          </select>
          <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg
              :class="{'rotate-180': dropdownOpen, 'rotate-0': !dropdownOpen}"
              class="w-4 h-4 text-gray-400 transition-transform duration-200"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 9l4 4 4-4"
              />
            </svg>
          </div>
        </div>
      </div>

      <div class="chart">
        <Line :data="chartData" :options="chartOptions" />
      </div>
    </div>
  </template>

  <script setup>
  import { ref, watch } from 'vue';
  import { Line } from 'vue-chartjs';
  import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Filler,
  } from 'chart.js';

  // Register chart components
  ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, Filler);

  // Define props to receive data
  const props = defineProps({
    data: {
      type: Array,
      required: true,
    },
  });

  // Reactive state for selected filter
  const selectedFilter = ref("all");

  // Reactive state for dropdown arrow
  const dropdownOpen = ref(false);

  // Toggle the dropdown arrow
  const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
  };

  // Reactive chart data
  const chartData = ref({
    labels: [],
    datasets: [
      {
        label: 'Sales (₱)',
        backgroundColor: 'rgba(255, 255, 255, 0.2)', // Light white with transparency for the background fill
        borderColor: 'rgb(255, 0, 0)',             // Solid red for the line
        pointBackgroundColor: '#FFFFFF',          // White for points
        pointBorderColor: 'rgb(255, 0, 0)',       // Red border around points
        pointHoverBackgroundColor: '#FFFFFF',     // White fill when hovered
        pointHoverBorderColor: 'rgb(255, 0, 0)',  // Red border when hovered
        data: [], // Data will be dynamically populated
        fill: true, // Enable fill below the line
        tension: 0.4, // Smooth line effect
      },
    ],
  });

  // Chart configuration options
  const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        labels: {
          color: '#FF0000',
          font: {
            size: 14,
          },
        },
      },
      tooltip: {
        backgroundColor: 'rgb(250, 247, 247)',
        titleColor: '#FF0000',
        bodyColor: '#FF0000',
      },
    },
    scales: {
      x: {
        beginAtZero: true,
        grid: {
          color: 'rgba(99, 132, 255, 0.2)',
        },
        ticks: {
          color: '#333333',
        },
      },
      y: {
        beginAtZero: true,
        grid: {
          color: 'rgba(99, 132, 255, 0.2)',
        },
        ticks: {
          color: '#333333',
        },
      },
    },
  });

  // Function to filter data based on the selected filter
  const applyFilter = () => {
    let filteredData = [];
    const now = new Date();

    switch (selectedFilter.value) {
      case "last7days":
        filteredData = props.data.filter((entry) => {
          const entryDate = new Date(entry.date);
          return now - entryDate <= 7 * 24 * 60 * 60 * 1000;
        });
        break;
      case "last30days":
        filteredData = props.data.filter((entry) => {
          const entryDate = new Date(entry.date);
          return now - entryDate <= 30 * 24 * 60 * 60 * 1000;
        });
        break;
      case "lastYear":
        filteredData = props.data.filter((entry) => {
          const entryDate = new Date(entry.date);
          return entryDate.getFullYear() === now.getFullYear() - 1;
        });
        break;
      default:
        filteredData = props.data;
        break;
    }

    updateChart(filteredData);
  };

  // Function to update chart data
  const updateChart = (data) => {
    if (data && Array.isArray(data) && data.length > 0) {
      chartData.value.labels = data.map((entry) => entry.label);
      chartData.value.datasets[0].data = data.map((entry) => entry.value);
    } else {
      chartData.value.labels = ['Jan', 'Feb', 'Mar', 'Apr'];
      chartData.value.datasets[0].data = [500, 700, 300, 1000];
    }
  };

  // Watch the props data for updates
  watch(
    () => props.data,
    (newData) => {
      updateChart(newData);
    },
    { immediate: true }
  );
  </script>


  <style scoped>
  .chart-container {
    height: 450px;
    width: 100%;
    max-width: 900px;
    margin: auto;
  }

  .chart {
    height: 300px;
    width: 100%;
    position: relative;
  }
  </style>
