<template>
  <DashboardLayout>
    <!-- Dashboard Header -->
    <DashboardHeader :notifications="notifications" />

    <!-- Dashboard Card Component -->
    <DashboardCard
      :totalPatients="totalPatients"
      :totalProducts="totalProducts"
      :totalSales="totalSales"
      :todayTotalSales="todayTotalSales"
      userRole="admin"
    />

    <!-- Sales Chart Component -->
    <SalesChart :data="salesChartData" />
  </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import DashboardHeader from "@/Components/DashboardHeader.vue";
import DashboardCard from "@/Components/DashboardCard.vue";
import SalesChart from "@/Components/Chart/SalesChart.vue";

const props = defineProps({
  totalPatients: Number,
  totalProducts: Number,
  totalSales: [Number, String],
  todayTotalSales: [Number, String],
  salesChartData: {
    type: Array,
    required: true,
  },
  notifications: {
    type: Array,
    required: true,
  },
});

// Debugging
console.log("Props salesChartData received in AdminDashboard:", props.salesChartData);
console.log("Received notifications:", props.notifications);

</script>

<style scoped>
</style>
