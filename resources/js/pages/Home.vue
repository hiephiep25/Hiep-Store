<template>
  <q-page>
    <div class="center-text">Chào mừng đến với trang chủ</div>
    <div>
      <RevenueChartMonth />
    </div>
    <q-card-section>
      <div class="row">
        <q-card class="q-mx-sm">
          <OnlineRevenueChartMonth />
        </q-card>
        <q-card class="q-mx-sm">
          <OfflineRevenueChartMonth />
        </q-card>
      </div>
    </q-card-section>
  </q-page>
</template>

<script setup>
import RevenueChartMonth from "@/components/charts/RevenueChartMonth.vue";
import OnlineRevenueChartMonth from "@/components/charts/OnlineRevenueChartMonth.vue";
import OfflineRevenueChartMonth from "@/components/charts/OfflineRevenueChartMonth.vue";
</script>

<style scoped>
.center-text {
  text-align: center;
  font-weight: bold;
  font-size: 32px;
}

.row {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin-top: 20px;
}

.q-card {
  flex: 1;
  margin: 10px;
  max-width: 48%;
}

.q-mx-sm {
  margin-left: 8px;
  margin-right: 8px;
}
</style>
