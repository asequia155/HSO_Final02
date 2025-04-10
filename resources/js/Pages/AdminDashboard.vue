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
        :todayTotalAppointments="todayTotalAppointments"
        userRole="admin"
      />

      <!-- Wrapper for Sales Chart and Today's Reservation -->
      <div class="flex justify-between">
        <!-- Sales Chart Component -->
        <div class="w-1/2 ">
          <SalesChart :data="salesChartData" />
        </div>

        <!-- Today's Reservation Component -->
        <div class="w-1/2 ">
          <TodaysReservation :TodaysReservationList="TodaysReservationList" />
        </div>
      </div>

    </DashboardLayout>
  </template>

  <script setup>
  import DashboardLayout from "@/Layouts/DashboardLayout.vue";
  import DashboardHeader from "@/Components/DashboardHeader.vue";
  import DashboardCard from "@/Components/DashboardCard.vue";
  import SalesChart from "@/Components/Chart/SalesChart.vue";
  import TodaysReservation from "@/Components/TodaysReservation.vue";

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
    todayTotalAppointments: Number,
    TodaysReservationList: Array,
  });

  // Debugging
  console.log("Props salesChartData received in AdminDashboard:", props.salesChartData);
  console.log("Received notifications:", props.notifications);
console.log("NUMBER APPOINTMENT:", props.TodaysReservationList);
  </script>

  <style scoped>
  </style>
