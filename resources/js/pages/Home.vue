<template>
    <q-page>
        <div class="center-text">
            Welcome to home page !
        </div>
        <div>
            <RevenueChartMonth />
        </div>
    </q-page>
</template>

<script setup>
import RevenueChartMonth from '@/components/charts/RevenueChartMonth.vue';
</script>

<style scoped>
.center-text {
    text-align: center;
    font-weight: bold;
    font-size: 32px;
}
</style>
