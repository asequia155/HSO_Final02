<template>
    <DashboardLayout>
        <DashboardHeader />
        <DashboardCard
    :totalPatients="totalPatients"
    :totalProducts="totalProducts"
    :totalSales="totalSales"
    :todayTotalSales="todayTotalSales"
    userRole="admin"
/>

    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardHeader from '@/Components/DashboardHeader.vue';
import DashboardCard from '@/Components/DashboardCard.vue';

const props = defineProps({
    totalPatients: Number,
    totalProducts: Number,
    totalSales: [Number, String],
    todayTotalSales: [Number, String],
});
</script>
