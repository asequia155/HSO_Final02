<template>
  <div>
    <canvas v-if="transactions && transactions.length > 0" ref="transactionChart" id="transactionChart"></canvas>
    <p v-else>No data available for the chart</p>
  </div>
</template>


<script setup>
import { ref, onMounted, watch } from 'vue';
import { Chart } from 'chart.js';

const props = defineProps({
  transactions: {
    type: Array,
    required: true,
    default: () => [],
  },
});

const transactionChart = ref(null);
let chartInstance = null;

watch(
  () => props.transactions,
  (newTransactions) => {
    if (newTransactions && newTransactions.length > 0) {
      if (chartInstance) {
        chartInstance.destroy(); // Destroy the old chart instance to avoid duplicates
      }
      chartInstance = renderChart(newTransactions);
    }
  },
  { immediate: true } // Runs watcher immediately to handle initial data load
);

onMounted(() => {
  if (props.transactions && props.transactions.length > 0) {
    chartInstance = renderChart(props.transactions);
  }
});

const renderChart = (transactions) => {
  if (!transactionChart.value) return;

  const ctx = transactionChart.value.getContext('2d');
  const labels = transactions.map((transaction) => formatDate(transaction.created_at));
  const data = transactions.map((transaction) => transaction.total);

  return new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Transaction Total',
          data: data,
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderWidth: 2,
          fill: true,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
};

const formatDate = (date) => {
  const options = { year: 'numeric', month: 'short', day: 'numeric' };
  return new Date(date).toLocaleDateString(undefined, options);
};

</script>

<style scoped>
#transactionChart {
  max-width: 600px;
  margin: auto;
}
</style>
