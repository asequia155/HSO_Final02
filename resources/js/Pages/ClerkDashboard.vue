<template>
    <DashboardLayout>
        <DashboardHeader />
        <DashboardCard
    :totalProducts="totalProducts"
    :todayTotalSales="todayTotalSales"
    :totalSales="totalSales"

    userRole="clerk"
/>

    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardHeader from '@/Components/DashboardHeader.vue';
import DashboardCard from '@/Components/DashboardCard.vue';

// Define props for the limited features available to the clerk
const props = defineProps({
    totalProducts: Number, // Number of products (specific to clerk view)
    todayTotalSales: [Number, String], // Today's total sales
    totalSales: [Number, String],

});
</script>
