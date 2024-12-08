<template>
  <div class="chart-container p-4 bg-white rounded-lg shadow-lg mt-7">
    <h2 class="text-xl font-semibold mb-4">Total Sales Overview</h2>
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

// Reactive chart data
const chartData = ref({
  labels: [],
  datasets: [
    {
      label: 'Sales (₱)',
      backgroundColor: 'rgba(255, 99, 132, 0.2)', // Light red for background fill
      borderColor: 'rgba(229, 57, 53, 1)',       // Red for line color
      pointBackgroundColor: 'rgba(255, 99, 132, 1)', // Red for points
      pointBorderColor: '#ffffff',                // White border around points
      pointHoverBackgroundColor: '#ffffff',       // White fill when hovered
      pointHoverBorderColor: 'rgba(255, 99, 132, 1)', // Red border when hovered
      data: [],
      fill: true,
      tension: 0.4, // Smooth line effect
    },
  ],
});

// Chart configuration options - must be properly defined
const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: true,
      labels: {
        color: '#333333', // Text color for legend labels
        font: {
          size: 14, // Font size for the legend labels
        },
      },
    },
    tooltip: {
      backgroundColor: 'rgba(255, 99, 132, 0.8)', // Red tooltip background
      titleColor: '#ffffff',                      // White tooltip title
      bodyColor: '#ffffff',                       // White tooltip text
    },
  },
  scales: {
    x: {
      beginAtZero: true,
      grid: {
        color: 'rgba(255, 99, 132, 0.2)', // Light red for grid lines on x-axis
      },
      ticks: {
        color: '#333333', // Dark grey for x-axis labels
      },
    },
    y: {
      beginAtZero: true,
      grid: {
        color: 'rgba(255, 99, 132, 0.2)', // Light red for grid lines on y-axis
      },
      ticks: {
        color: '#333333', // Dark grey for y-axis labels
      },
    },
  },
});

// Watch the props data for updates
watch(
  () => props.data,
  (newData) => {
    if (newData && Array.isArray(newData) && newData.length > 0) {
      chartData.value.labels = newData.map(entry => entry.label);
      chartData.value.datasets[0].data = newData.map(entry => entry.value);
    } else {
      console.warn('No valid data found, using fallback data.');
      chartData.value.labels = ['Jan', 'Feb', 'Mar', 'Apr'];
      chartData.value.datasets[0].data = [500, 700, 300, 1000];
    }
  },
  { immediate: true }
);
</script>

<style scoped>
.chart-container {
  height: 400px;
  width: 49%;
  position: relative;
}

.chart {
  height: 300px;
  width: 100%;
  position: relative;
}
</style>
