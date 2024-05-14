<template>
    <q-page>
        <div class="q-pa-md" style="text-align: center;">
            <q-card class="my-card bg-white q-pa-md">
                <div class="row justify-center">
                    <div class="col">
                        <h4>Chi tiết đơn hàng</h4>
                        <div>
                            <strong>Loại:</strong> {{ offlineOrder.type }}
                        </div>
                        <div>
                            <strong>Hình thức thanh toán:</strong> {{ offlineOrder.payment_type }}
                        </div>
                        <div>
                            <strong>Tổng tiền:</strong> {{ offlineOrder.total }}
                        </div>
                        <div>
                            <strong>Thời gian mua:</strong> {{ formatDate(offlineOrder.created_at) }}
                        </div>
                        <h5>Các sản phẩm</h5>
                        <div v-for="product in offlineOrder.products" :key="product.id">
                            <div>
                                <strong>Tên sản phẩm:</strong> {{ product.name }}
                            </div>
                            <div>
                                <strong>Số lượng:</strong> {{ product.pivot.qty }}
                            </div>
                        </div>
                        <q-btn class="q-mt-md" color="primary" label="Xuất file PDF" @click="exportToPdf" />
                    </div>
                </div>
            </q-card>
        </div>
    </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useOfflineOrderStore } from '@/store/offline-order';
import html2pdf from 'html2pdf.js';

const router = useRouter();
const offlineOrderStore = useOfflineOrderStore();
const offlineOrder = ref({});

const fetchDetailOfflineOrder = async (orderId) => {
    try {
        const response = await offlineOrderStore.getDetailOfflineOrder(orderId);
        offlineOrder.value = response.data;
    } catch (error) {
        console.error('Error fetching offline order details:', error);
    }
};

onMounted(() => {
    const orderId = router.currentRoute.value.params.id;
    fetchDetailOfflineOrder(orderId);
});

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'numeric', day: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', options);
};

const exportToPdf = () => {
  const targetElement = document.querySelector('.my-card');

  const options = {
    margin: 10,
    filename: 'order_details.pdf',
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
  };

  html2pdf(targetElement, options);
};
</script>
