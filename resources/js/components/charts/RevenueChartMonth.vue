<template>
    <div>
        <canvas ref="chart" style="height: 400px;"></canvas>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import Chart from 'chart.js/auto';
import { useOrderStore } from '../../store/order';

export default {
    name: 'RevenueChartMonth',
    setup() {
        const orderStore = useOrderStore();
        const chart = ref(null);

        onMounted(() => {
            orderStore.getRevenuesByMonth().then((data) => {
                console.log(data.data);
                const labels = data.data.map((entry) => `Tháng ${entry.month}`);
                const values = data.data.map((entry) => entry.total_revenue);

                const ctx = chart.value.getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [
                            {
                                label: 'Doanh thu theo tháng',
                                data: values,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                            },
                        ],
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                        },
                        maintainAspectRatio: false,
                    },
                });
            });
        });

        return {
            chart,
        };
    },
};
</script>

<style scoped></style>
