<template>
    <div>
        <div class="year-selection">
            <label for="year">Chọn năm:</label>
            <input v-model="selectedYear" type="number" id="year" min="2000" max="2100" class="year-input">
            <button @click="updateChart" class="update-button">Cập nhật</button>
        </div>

        <canvas ref="chart" style="max-height: 400px;"></canvas>
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
        const selectedYear = ref(new Date().getFullYear());
        let currentChart = null;

        const updateChart = async () => {
            const data = await orderStore.getRevenuesByMonth(selectedYear.value);
            console.log(data.data);

            const labels = data.data.map((entry) => `Tháng ${entry.month}`);
            const values = data.data.map((entry) => entry.total_revenue);

            const ctx = chart.value.getContext('2d');

            if (currentChart) {
                currentChart.destroy();
            }

            currentChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        {
                            label: `Doanh thu theo tháng của năm ${selectedYear.value}`,
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
                },
            });
        };

        onMounted(() => {
            updateChart(); // Initial chart rendering
        });

        return {
            chart,
            selectedYear,
            updateChart,
        };
    },
};
</script>

<style scoped>
.year-selection {
    display: flex;
    align-items: center;
}

.year-input {
    margin-right: 10px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.update-button {
    padding: 7px 15px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.update-button:hover {
    background-color: #45a049;
}
</style>
