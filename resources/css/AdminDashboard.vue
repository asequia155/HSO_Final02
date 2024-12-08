<template>
    <DashboardLayout>
      <DashboardHeader />
  
      <!-- Dashboard Card Component -->
      <DashboardCard
        :totalPatients="props.totalPatients"
        :totalProducts="props.totalProducts"
        :totalSales="props.totalSales"
        :todayTotalSales="props.todayTotalSales"
        userRole="admin"
      />
  
      <!-- Sales Chart Component -->
      <SalesChart :data="props.salesChartData" />
    </DashboardLayout>
  </template>
  
  <script setup>
  import DashboardLayout from '@/Layouts/DashboardLayout.vue';
  import DashboardHeader from '@/Components/DashboardHeader.vue';
  import DashboardCard from '@/Components/DashboardCard.vue';
  import SalesChart from '@/Components/Chart/SalesChart.vue';
  
  const props = defineProps({
    totalPatients: Number,
    totalProducts: Number,
    totalSales: [Number, String],
    todayTotalSales: [Number, String],
    salesChartData: {
      type: Array,
      required: true,
    },
  });
  
  // Debugging line to verify props are received correctly
  console.log('Props salesChartData received in AdminDashboard:', props.salesChartData);
  </script>
  
  <style scoped>
  </style>
  